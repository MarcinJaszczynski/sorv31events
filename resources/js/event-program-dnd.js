// Minimal drag & drop helper for Event Program points
document.addEventListener('DOMContentLoaded', function () {
    function getRelationReorderUrl() {
        // Filament relation manager reorder uses POST to current page + '/reorder'
        // We'll send to window.location.href + '/reorder' which works in Filament context for the relation
        return window.location.href.replace(/\/$/, '') + '/reorder';
    }

    function sendOrder(payload) {
        fetch(getRelationReorderUrl(), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: JSON.stringify({ order: payload })
        }).then(r => {
            if (!r.ok) throw new Error('Reorder failed');
            return r.json();
        }).then(() => {
            window.dispatchEvent(new CustomEvent('eventProgramReordered'));
        }).catch(e => {
            console.error(e);
            window.dispatchEvent(new CustomEvent('eventProgramReorderFailed', { detail: { error: e.message } }));
        });
    }

    // Very small drag & drop behaviour: items must have data-pp-id and data-parent-id
    // Buttons with class .pp-dnd-save will collect current DOM order and POST
    document.querySelectorAll('.pp-dnd-save').forEach(function (btn) {
        btn.addEventListener('click', function () {
            // find rows in .pp-dnd-list container
            const list = document.querySelectorAll('.pp-dnd-list .pp-row');
            const payload = [];
            list.forEach(function (row) {
                const id = row.getAttribute('data-pp-id');
                const parent = row.getAttribute('data-parent-id') || null;
                const day = row.getAttribute('data-day') || row.closest('[data-day]')?.getAttribute('data-day') || null;
                const order = row.getAttribute('data-order') || Array.prototype.indexOf.call(list, row) + 1;
                payload.push({ id: parseInt(id), parent_id: parent ? parseInt(parent) : null, day: day ? parseInt(day) : null, order: parseInt(order) });
            });

            sendOrder(payload);
        });
    });
});
