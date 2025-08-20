<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\EventTemplate;
use App\Models\EventTemplatePricePerPerson;
use App\Services\EventTemplateCalculationEngine;

class CompareCalculationCommand extends Command
{
    protected $signature = 'eventtemplate:compare-calc {templateId} {startPlaceId?}';
    protected $description = 'Compare stored prices with calculation engine for given event template and optional start place';

    public function handle()
    {
        $templateId = $this->argument('templateId');
        $startPlaceId = $this->argument('startPlaceId');

    // allow comparing soft-deleted templates as well
    $template = EventTemplate::withTrashed()->find($templateId);
        if (!$template) {
            $this->error("EventTemplate id={$templateId} not found");
            return 1;
        }

        $engine = new EventTemplateCalculationEngine();
        $calc = $engine->calculateDetailed($template, $startPlaceId ? (int)$startPlaceId : null);

        $this->info("Calculated variants: " . implode(', ', array_keys($calc)));

        foreach ($calc as $qty => $data) {
            $this->line("Qty={$qty}: calc.price_per_person={$data['price_per_person']}, base={$data['price_base']}, markup={$data['markup_amount']}, tax={$data['tax_amount']}, transport={$data['transport_cost']}");

            $stored = EventTemplatePricePerPerson::where('event_template_id', $template->id)
                ->whereHas('eventTemplateQty', function($q) use ($qty){ $q->where('qty', $qty); })
                ->when($startPlaceId, fn($q) => $q->where('start_place_id', (int)$startPlaceId), fn($q) => $q->whereNull('start_place_id'))
                ->first();

            if ($stored) {
                $this->line(" -> stored.price_per_person={$stored->price_per_person}, base={$stored->price_base}, markup={$stored->markup_amount}, tax={$stored->tax_amount}, transport={$stored->transport_cost}");
                $diff = $data['price_per_person'] - $stored->price_per_person;
                $this->line(sprintf(' -> diff price_per_person = %.2f', $diff));
            } else {
                $this->line(' -> No stored price found for this qty/start_place combo');
            }
        }

        $this->info('Done');
        return 0;
    }
}
