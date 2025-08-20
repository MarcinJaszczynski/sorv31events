<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Http\Request;
use App\Models\EventTemplate;
use App\Models\Event;

class CreateEvent extends CreateRecord
{
    protected static string $resource = EventResource::class;

    protected ?EventTemplate $template = null;

    public function mount(): void
    {
        parent::mount();

        $templateId = request()->query('template');
        if ($templateId) {
            $this->template = EventTemplate::find($templateId);
            if ($this->template) {
                // Prefill some form data from template
                $this->form->fill([
                    'event_template_id' => $this->template->id,
                    'duration_days' => $this->template->duration_days,
                    'transfer_km' => $this->template->transfer_km,
                    'program_km' => $this->template->program_km,
                    'bus_id' => $this->template->bus_id,
                    'markup_id' => $this->template->markup_id,
                    'name' => $this->template->name,
                ]);
            }
        }
    }

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        // If template present, use Event::createFromTemplate to ensure deep-copy behavior
        if ($this->template) {
            $event = Event::createFromTemplate($this->template, $data);
            return $event;
        }

        return parent::handleRecordCreation($data);
    }
}
