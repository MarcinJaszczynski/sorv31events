<?php

namespace App\Jobs;

use App\Models\EventTemplate;
use App\Models\EventTemplatePricePerPerson;
use App\Services\EventTemplatePriceCalculator;
use Filament\Notifications\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class RecalculateSelectedEventTemplatePricesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public array $templateIds;
    public int $userId;

    public function __construct(array $templateIds, int $userId)
    {
        $this->templateIds = $templateIds;
        $this->userId = $userId;
    }

    public function handle(): void
    {
        $calculator = new EventTemplatePriceCalculator();
        $totalTemplates = 0;
        $totalPricesCreated = 0;
        $totalPricesAfter = 0;
        $errors = 0;

        foreach ($this->templateIds as $id) {
            $template = EventTemplate::withTrashed()->find($id);
            if (!$template) continue;
            try {
                $before = EventTemplatePricePerPerson::where('event_template_id', $template->id)->count();
                $calculator->calculateAndSave($template);
                $after = EventTemplatePricePerPerson::where('event_template_id', $template->id)->count();
                $totalTemplates++;
                $totalPricesCreated += max($after - $before, 0);
                $totalPricesAfter += $after;
            } catch (\Throwable $e) {
                $errors++;
                Log::error('Recalculate selected job error for template #' . $template->id . ': ' . $e->getMessage());
            }
        }

        // Notify user
        try {
            $user = \App\Models\User::find($this->userId);
            if ($user) {
                Notification::make()
                    ->title('Przeliczanie cen - wybrane szablony zakończone')
                    ->body("Szablony: {$totalTemplates}, Nowe rekordy: {$totalPricesCreated}, Razem rekordów po przeliczeniu: {$totalPricesAfter}, Błędów: {$errors}")
                    ->success()
                    ->sendToDatabase($user);

                if (!empty($user->email)) {
                    $summary = "Szablony: {$totalTemplates}\nNowe rekordy: {$totalPricesCreated}\nRazem rekordów po przeliczeniu: {$totalPricesAfter}\nBłędów: {$errors}";
                    Mail::raw('Przeliczanie cen zakończone.\n' . $summary, function ($m) use ($user) {
                        $m->to($user->email)->subject('Podsumowanie przeliczania cen');
                    });
                }
            }
        } catch (\Throwable $e) {
            Log::warning('Failed to send completion notification: ' . $e->getMessage());
        }
    }
}
