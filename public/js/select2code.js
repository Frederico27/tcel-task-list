$(function () {
    var $sel = $('#multiple-select-field-pic');
    $sel.select2({
        theme: 'bootstrap-5',
        width: $sel.data('width') ? $sel.data('width') : ($sel.hasClass('w-100') ? '100%' :
            'style'),
        placeholder: $sel.data('placeholder'),
        closeOnSelect: false
    });
});

$(function () {
    var $sel = $('#multiple-select-field-approval');
    $sel.select2({
        theme: 'bootstrap-5',
        width: $sel.data('width') ? $sel.data('width') : ($sel.hasClass('w-100') ? '100%' :
            'style'),
        placeholder: $sel.data('placeholder'),
        closeOnSelect: false
    });
});

$(function () {
    var $sel = $('#multiple-select-field-weekly');
    $sel.select2({
        theme: 'bootstrap-5',
        width: $sel.data('width') ? $sel.data('width') : ($sel.hasClass('w-100') ? '100%' :
            'style'),
        placeholder: $sel.data('placeholder'),
        closeOnSelect: false
    });
});



// Multi-datepicker: show day + month only, allow multiple selections
$('#multi-datepicker').datepicker({
    format: "dd MM", // day and month only in the input display
    multidate: true, // allow multiple dates
    autoclose: false,
    clearBtn: true,
    todayHighlight: true
});

// Before form submit, convert the comma-separated formatted strings into hidden inputs arrays
$('#addTaskModal form').on('submit', function () {
    // remove any previous hidden inputs
    $('#selected-dates-container').empty();
    $('#selected-months-container').empty();

    var type = $('#type_periods').val();

    // Only append date hidden inputs when Yearly is selected.
    // Weekly values come from the multiple-select-field-weekly select (name="periods[]") directly,
    // so do not duplicate them with hidden inputs.
    if (type === 'Yearly') {
        // dates: datepicker returns comma-separated formatted values
        var datesVal = $('#multi-datepicker').val().trim();
        if (datesVal.length) {
            // split by comma and trim
            var dates = datesVal.split(',').map(function (s) {
                return s.trim();
            });
            dates.forEach(function (d) {
                $('<input>').attr({
                    type: 'hidden',
                    name: 'periods[]',
                    value: d
                }).appendTo('#selected-dates-container');
            });
        }
    }

    // allow form to submit; server will receive only the fields relevant to the selected type
});



$(function () {
    const $dateGroup = $('#multi-datepicker').closest('.form-group');
    const $weeklyGroup = $('#multiple-select-field-weekly').closest('.form-group');
    const $weeklySelect = $('#multiple-select-field-weekly');
    const $dateInput = $('#multi-datepicker');

    function updateVisibility() {
        const val = $('#type_periods').val();

        if (val === 'Daily') {
            $dateGroup.hide();
            $weeklyGroup.hide();

            // disable hidden controls so they won't be submitted (and clear validation)
            $weeklySelect.prop('required', false).prop('disabled', true).trigger('change');
            $dateInput.prop('disabled', true);
        } else if (val === 'Weekly') {
            $dateGroup.hide();
            $weeklyGroup.show();

            $weeklySelect.prop('required', true).prop('disabled', false).trigger('change');
            $dateInput.prop('disabled', true);
        } else if (val === 'Yearly') {
            $dateGroup.show();
            $weeklyGroup.hide();

            $weeklySelect.prop('required', false).prop('disabled', true).trigger('change');
            $dateInput.prop('disabled', false);
        } else {
            $dateGroup.show();
            $weeklyGroup.show();

            $weeklySelect.prop('disabled', false).prop('required', false).trigger('change');
            $dateInput.prop('disabled', false);
        }
    }

    $(document).on('change', '#type_periods', updateVisibility);
    $('#addTaskModal').on('shown.bs.modal', updateVisibility);
    updateVisibility();
});
