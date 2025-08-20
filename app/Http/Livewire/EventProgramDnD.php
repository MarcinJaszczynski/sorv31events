<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Event;
use App\Models\EventProgramPoint;
use Illuminate\Support\Facades\Log;

class EventProgramDnD extends Component
{
    public $eventId;
    public $points = [];

    public function mount($eventId)
    {
        $this->eventId = $eventId;
        $this->loadPoints();
    $this->listeners = ['saveOrderFromDnDPayload' => 'saveOrder'];
    }

    public function loadPoints()
    {
        $event = Event::find($this->eventId);
        if (!$event) {
            $this->points = [];
            return;
        }

        $this->points = $event->programPoints()->orderBy('day')->orderBy('order')->get()->map(function ($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'day' => $p->day,
                'order' => $p->order,
                'parent_id' => $p->parent_id,
            ];
        })->toArray();
    }

    public function saveOrder($payload)
    {
        try {
            \DB::transaction(function () use ($payload) {
                foreach ($payload as $item) {
                    $id = $item['id'] ?? null;
                    if (!$id) continue;
                    $newDay = $item['day'] ?? null;
                    $newOrder = $item['order'] ?? null;
                    $newParent = array_key_exists('parent_id', $item) ? ($item['parent_id'] !== '' ? (int)$item['parent_id'] : null) : null;

                    EventProgramPoint::where('id', $id)->update([
                        'day' => $newDay,
                        'order' => $newOrder,
                        'parent_id' => $newParent,
                    ]);
                }
            });

            $this->loadPoints();
            $this->dispatchBrowserEvent('toast', ['type' => 'success', 'message' => 'Kolejność zapisana']);
        } catch (\Throwable $e) {
            Log::error('Błąd zapisu kolejności DnD: ' . $e->getMessage());
            $this->dispatchBrowserEvent('toast', ['type' => 'error', 'message' => 'Błąd zapisu kolejności']);
        }
    }

    public function render()
    {
        return view('livewire.event-program-dnd');
    }
}
