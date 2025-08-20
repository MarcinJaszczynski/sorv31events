<div>
    <div class="pp-dnd-list">
        @foreach($points as $p)
            <div class="pp-row" data-pp-id="{{ $p['id'] }}" data-parent-id="{{ $p['parent_id'] }}" data-day="{{ $p['day'] }}" data-order="{{ $p['order'] }}">
                <div class="flex items-center justify-between p-2 border rounded mb-1 bg-white">
                    <div>{{ $p['name'] }} <span class="text-xs text-gray-500">(Dzień {{ $p['day'] }})</span></div>
                    <div class="flex gap-2">
                        <button type="button" class="pp-move-up">↑</button>
                        <button type="button" class="pp-move-down">↓</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-2">
        <button type="button" wire:click="$emit('saveOrderFromDnD')" class="filament-button-primary pp-dnd-save">Zapisz kolejność</button>
    </div>
</div>
