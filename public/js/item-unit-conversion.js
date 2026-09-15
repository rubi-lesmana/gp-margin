/**
 * Reusable module untuk fetch & populate dropdown unit
 * berdasarkan item yang dipilih.
 *
 * Dependency: jQuery
 */
const ItemUnitConversion = (function () {
    let currentRequestItemId = null;

    /**
     * @param {string} itemId
     * @param {jQuery} $unitSelect - elemen <select> untuk unit
     * @param {string|number|null} preselectUnitId - unit_id yang harus otomatis terpilih (opsional, untuk edit)
     * @param {function|null} onLoaded - callback setelah select selesai di-populate (opsional)
     */
    function fetchUnits(itemId, $unitSelect, preselectUnitId = null, onLoaded = null) {
        $unitSelect.empty().append('<option value="">Select Unit</option>');

        if (!itemId) {
            return;
        }

        currentRequestItemId = itemId;

        $unitSelect
            .empty()
            .append('<option value="">Loading...</option>')
            .prop('disabled', true);

        $.ajax({
            url: `/items/${itemId}/unit-conversion-details`,
            method: 'GET',
            dataType: 'json',
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .done(function (details) {
            if (currentRequestItemId !== itemId) return; // race condition guard

            $unitSelect.empty().append('<option value="">Select Unit</option>');

            if (!details || details.length === 0) {
                $unitSelect.append('<option value="">No unit available</option>');
                return;
            }

            $.each(details, function (_, d) {
                $unitSelect.append(
                    $('<option>', { value: d.id, text: d.label })
                );
            });

            // preselect kalau ada (dipakai di form edit)
            if (preselectUnitId) {
                $unitSelect.val(preselectUnitId);
            }

            if (typeof onLoaded === 'function') {
                onLoaded(details);
            }
        })
        .fail(function () {
            if (currentRequestItemId !== itemId) return;
            $unitSelect.empty().append('<option value="">Failed to load unit</option>');
        })
        .always(function () {
            if (currentRequestItemId === itemId) {
                $unitSelect.prop('disabled', false);
            }
        });
    }

    /**
     * Bind event change pada #item-id, otomatis isi description & fetch unit
     *
     * @param {object} options
     * @param {string} options.itemSelector - selector select item, default '#item-id'
     * @param {string} options.unitSelector - selector select unit, default '#unit-id'
     * @param {string} options.descriptionSelector - selector input description, default '#description-item'
     */
    function bindItemChange(options = {}) {
        const itemSelector        = options.itemSelector || '#item-id';
        const unitSelector        = options.unitSelector || '#unit-id';
        const descriptionSelector = options.descriptionSelector || '#description-item';

        $(itemSelector).on('change', function () {
            const selected    = $(this).find(':selected');
            const description = selected.attr('data-description');
            const itemId      = $(this).val();

            $(descriptionSelector).val(description ?? '');
            fetchUnits(itemId, $(unitSelector));
        });
    }

    return {
        fetchUnits,
        bindItemChange
    };
})();