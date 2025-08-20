<?php
// Skript: scripts/rewrite_prices.php
// Cel: Bezpiecznie usunac stare wpisy i zapisać ceny zgodne z EventTemplateCalculationEngine

use App\Models\EventTemplate;
use App\Models\EventTemplatePricePerPerson;
use App\Models\EventTemplateQty;
use App\Models\Currency;
use App\Services\EventTemplateCalculationEngine;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

require __DIR__ . '/../vendor/autoload.php';

// bootstrap aplikacji
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$status = $kernel->handle(
    new Symfony\Component\Console\Input\ArgvInput(),
    new Symfony\Component\Console\Output\ConsoleOutput()
);

// Parametry: --dry (nie zapisuje, tylko podglad), --limit=N (tylko N par), --only=templateId (opcjonalnie)
$options = getopt('', ['dry::', 'limit::', 'only::']);
$dryRun = array_key_exists('dry', $options);
$limit = isset($options['limit']) ? (int)$options['limit'] : null;
$only = isset($options['only']) ? (int)$options['only'] : null;

echo "Dry run: ".($dryRun? 'YES':'NO')."\n";

function database_path($file = '') {
    return __DIR__ . '/../database' . ($file ? DIRECTORY_SEPARATOR . $file : '');
}

$dbPath = database_path('database.sqlite');
$backupPath = database_path('database.sqlite.bak.'.date('Ymd_His'));
if (!$dryRun) {
    echo "Creating DB backup: $backupPath\n";
    copy($dbPath, $backupPath);
}

$engine = new EventTemplateCalculationEngine();

// pobierz pary z availability (only start places that are set)
    $pairs = DB::table('event_template_starting_place_availability')
    ->whereNotNull('start_place_id')
    ->when($only, fn($q) => $q->where('event_template_id', $only))
    ->select('event_template_id', 'start_place_id')
    ->distinct()
    ->get();

if ($limit) {
    $pairs = $pairs->slice(0, $limit);
}

$report = [];
$problematic = [];
$totalSaved = 0;

foreach ($pairs as $p) {
    $templateId = (int)$p->event_template_id;
    $startPlaceId = (int)$p->start_place_id;
    echo "Processing template={$templateId}, start_place={$startPlaceId}\n";

    $template = EventTemplate::withTrashed()->find($templateId);
    if (!$template) {
        $problematic[] = [
            'template_id' => $templateId,
            'start_place_id' => $startPlaceId,
            'reason' => 'template_not_found'
        ];
        continue;
    }

    $calc = $engine->calculateDetailed($template, $startPlaceId);
    if (empty($calc)) {
        $problematic[] = [
            'template_id'=>$templateId, 'start_place_id'=>$startPlaceId, 'reason'=>'no_calc_variants'
        ];
        continue;
    }

    // Existing rows count for info (we will upsert instead of delete+insert)
    $oldCount = DB::table('event_template_price_per_person')
        ->where('event_template_id', $templateId)
        ->where('start_place_id', $startPlaceId)
        ->count();

    echo ($dryRun ? "Would upsert (keep existing) $oldCount existing rows\n" : "Will upsert (keep existing) $oldCount existing rows\n");

    // dla kazdego wariantu qty w calc, zapisac wiersze (mozliwe rozne waluty)
    foreach ($calc as $qty => $data) {
        // znalezienie odpowiadajacego event_template_qty_id
        $qtyModel = null;
        $qtyLookupMethod = null;
        if (!empty($data['event_template_qty_id'])) {
            $qtyModel = EventTemplateQty::find((int)$data['event_template_qty_id']);
            $qtyLookupMethod = 'by_id_from_engine';
        }
        // fallback: engine keys are plain qty numbers (20,25...) - spróbuj znaleźć po wartości qty
        if (!$qtyModel) {
            $qtyModel = EventTemplateQty::where('event_template_id', $templateId)->where('qty', $qty)->first();
            $qtyLookupMethod = $qtyModel ? 'by_qty_value' : 'not_found';
        }

        if (!$qtyModel) {
            $problematic[] = [
                'template_id'=>$templateId, 'start_place_id'=>$startPlaceId, 'qty'=>$qty, 'reason'=>'qty_not_found', 'lookup'=>$qtyLookupMethod
            ];
            continue;
        }

        // data moze zawierac 'currencies' - jesli tak, zapisz dla kazdej waluty
        if (!empty($data['currencies']) && is_array($data['currencies'])) {
            foreach ($data['currencies'] as $currencyCode => $cvals) {
                // znajdz currency_id
                $currency = Currency::where('symbol', $currencyCode)->orWhere('name', $currencyCode)->first();
                if (!$currency) {
                    $problematic[] = [
                        'template_id'=>$templateId, 'start_place_id'=>$startPlaceId, 'qty'=>$qty, 'currency'=>$currencyCode, 'reason'=>'currency_not_found'
                    ];
                    continue;
                }
                $row = [
                    'event_template_id'=>$templateId,
                    'event_template_qty_id'=>$qtyModel->id,
                    'currency_id'=>$currency->id,
                    'start_place_id'=>$startPlaceId,
                    'price_per_person'=>$cvals['price_per_person'] ?? null,
                    'price_base'=>$cvals['price_base'] ?? null,
                    'markup_amount'=>$cvals['markup_amount'] ?? null,
                    'tax_amount'=>$cvals['tax_amount'] ?? null,
                    'transport_cost'=>$cvals['transport_cost'] ?? ($data['transport_cost'] ?? null),
                    'tax_breakdown'=>json_encode($cvals['tax_breakdown'] ?? ($data['tax_breakdown'] ?? [])),
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now()
                ];

                // ensure mandatory ids present
                $missing = [];
                foreach (['event_template_id','event_template_qty_id','currency_id','start_place_id'] as $k) {
                    if (empty($row[$k]) && $row[$k] !== 0) $missing[] = $k;
                }
                if (!empty($missing)) {
                    $problematic[] = array_merge($row, ['reason'=>'missing_ids:'.implode(',', $missing)]);
                    continue;
                }

                if (!$dryRun) {
                    // manual upsert: update if exists else insert (avoid requiring DB unique constraint)
                    $exists = DB::table('event_template_price_per_person')
                        ->where('event_template_id', $row['event_template_id'])
                        ->where('event_template_qty_id', $row['event_template_qty_id'])
                        ->where('currency_id', $row['currency_id'])
                        ->where('start_place_id', $row['start_place_id'])
                        ->first();
                    if ($exists) {
                        DB::table('event_template_price_per_person')
                            ->where('id', $exists->id)
                            ->update(array_merge($row, ['updated_at'=>Carbon::now()]));
                    } else {
                        DB::table('event_template_price_per_person')->insert($row);
                    }
                    $totalSaved++;
                }
            }
        } else {
            // brak rozbicia po walutach: zapisz jako domyslna waluta PLN (lub warn)
            $pln = Currency::where('symbol','PLN')->orWhere('name','Polski złoty')->first();
            if (!$pln) {
                $problematic[] = [
                    'template_id'=>$templateId,'start_place_id'=>$startPlaceId,'qty'=>$qty,'reason'=>'pln_currency_missing'
                ];
                continue;
            }
            $row = [
                'event_template_id'=>$templateId,
                'event_template_qty_id'=>$qtyModel->id,
                'currency_id'=>$pln->id,
                'start_place_id'=>$startPlaceId,
                'price_per_person'=>$data['price_per_person'] ?? null,
                'price_base'=>$data['price_base'] ?? null,
                'markup_amount'=>$data['markup_amount'] ?? null,
                'tax_amount'=>$data['tax_amount'] ?? null,
                'transport_cost'=>$data['transport_cost'] ?? null,
                'tax_breakdown'=>json_encode($data['tax_breakdown'] ?? []),
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ];
            $missing = [];
            foreach (['event_template_id','event_template_qty_id','currency_id','start_place_id'] as $k) {
                if (empty($row[$k]) && $row[$k] !== 0) $missing[] = $k;
            }
            if (!empty($missing)) {
                $problematic[] = array_merge($row, ['reason'=>'missing_ids:'.implode(',', $missing)]);
                continue;
            }
            if (!$dryRun) {
                $exists = DB::table('event_template_price_per_person')
                    ->where('event_template_id', $row['event_template_id'])
                    ->where('event_template_qty_id', $row['event_template_qty_id'])
                    ->where('currency_id', $row['currency_id'])
                    ->where('start_place_id', $row['start_place_id'])
                    ->first();
                if ($exists) {
                    DB::table('event_template_price_per_person')
                        ->where('id', $exists->id)
                        ->update(array_merge($row, ['updated_at'=>Carbon::now()]));
                } else {
                    DB::table('event_template_price_per_person')->insert($row);
                }
                $totalSaved++;
            }
        }
    }
}

// zapisz raporty
$reportPath = __DIR__.'/rewrite_prices_report_'.date('Ymd_His').'.json';
file_put_contents($reportPath, json_encode(['summary'=>['pairs'=>count($pairs),'saved'=>$totalSaved],'problematic'=>$problematic], JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));

echo "Done. Report: $reportPath\n";
if (!empty($problematic)) {
    echo "Problematic combinations found: " . count($problematic) . " - see report.\n";
}

return 0;
