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


// --- Edit modal: mirror the same behavior as add modal but for edit-* IDs ---
$(function () {
    // init select2 for edit selects if present
    var $selEditPic = $('#edit-multiple-select-field-pic');
    if ($selEditPic.length) {
        $selEditPic.select2({
            theme: 'bootstrap-5',
            width: $selEditPic.data('width') ? $selEditPic.data('width') : ($selEditPic.hasClass('w-100') ? '100%' : 'style'),
            placeholder: $selEditPic.data('placeholder'),
            closeOnSelect: false,
            dropdownParent: $('#editTaskModal')
        });
    }

    var $selEditApproval = $('#edit-multiple-select-field-approval');
    if ($selEditApproval.length) {
        $selEditApproval.select2({
            theme: 'bootstrap-5',
            width: $selEditApproval.data('width') ? $selEditApproval.data('width') : ($selEditApproval.hasClass('w-100') ? '100%' : 'style'),
            placeholder: $selEditApproval.data('placeholder'),
            closeOnSelect: false,
            dropdownParent: $('#editTaskModal')
        });
    }

    var $selEditWeekly = $('#edit-multiple-select-field-weekly');
    if ($selEditWeekly.length) {
        $selEditWeekly.select2({
            theme: 'bootstrap-5',
            width: $selEditWeekly.data('width') ? $selEditWeekly.data('width') : ($selEditWeekly.hasClass('w-100') ? '100%' : 'style'),
            placeholder: $selEditWeekly.data('placeholder'),
            closeOnSelect: false,
            dropdownParent: $('#editTaskModal')
        });
    }

    // datepicker for edit modal
    if ($('#edit-multi-datepicker').length) {
        $('#edit-multi-datepicker').datepicker({
            format: "dd MM",
            multidate: true,
            autoclose: false,
            clearBtn: true,
            todayHighlight: true
        });
    }

    // handle edit form submit: convert selected dates into hidden inputs (Yearly case)
    $('#editTaskForm').on('submit', function () {
        // clear any previous hidden inputs
        $('#edit-selected-dates-container').empty();
        var type = $('#edit_type_periods').val();
        if (type === 'Yearly') {
            var datesVal = $('#edit-multi-datepicker').val() ? $('#edit-multi-datepicker').val().trim() : '';
            if (datesVal.length) {
                var dates = datesVal.split(',').map(function (s) { return s.trim(); });
                dates.forEach(function (d) {
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'periods[]',
                        value: d
                    }).appendTo('#edit-selected-dates-container');
                });
            }
        }
        // allow submit
    });

    // visibility toggling for edit modal controls
    (function () {
        const $dateGroup = $('#edit-multi-datepicker').closest('.form-group');
        const $weeklyGroup = $('#edit-multiple-select-field-weekly').closest('.form-group');
        const $weeklySelect = $('#edit-multiple-select-field-weekly');
        const $dateInput = $('#edit-multi-datepicker');

        function updateVisibility() {
            const val = $('#edit_type_periods').val();

            if (val === 'Daily') {
                $dateGroup.hide();
                $weeklyGroup.hide();

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

        $(document).on('change', '#edit_type_periods', updateVisibility);
        $('#editTaskModal').on('shown.bs.modal', updateVisibility);
        updateVisibility();
    })();
});


  document.addEventListener('DOMContentLoaded', function() {
            // populate edit modal when edit button clicked
            document.querySelectorAll('.edit-btn').forEach(function(btn) {
                btn.addEventListener('click', function(ev) {
                    const id = this.dataset.id;
                    const type_document = this.dataset.type_document || '';
                    const pic = JSON.parse(this.dataset.pic || '[]');
                    const approval = JSON.parse(this.dataset.approval || '[]');
                    const type_periods = this.dataset.type_periods || '';
                    const periods = JSON.parse(this.dataset.periods || '[]');
                    const creating_task = this.dataset.creating_task || '';

                    document.getElementById('edit_type_document').value = type_document;
                    // set select2 values (ensure select2 is initialized)
                    const picSelect = $('#edit-multiple-select-field-pic');
                    const approvalSelect = $('#edit-multiple-select-field-approval');
                    if (picSelect.length && picSelect.data('select2')) {
                        picSelect.val(pic).trigger('change');
                    } else if (picSelect.length) {
                        picSelect.val(pic);
                    }
                    if (approvalSelect.length && approvalSelect.data('select2')) {
                        approvalSelect.val(approval).trigger('change');
                    } else if (approvalSelect.length) {
                        approvalSelect.val(approval);
                    }

                    document.getElementById('edit_type_periods').value = type_periods;
                    // periods select
                    const periodsSelect = $('#edit-multiple-select-field-weekly');
                    if (periodsSelect.length && periodsSelect.data('select2')) {
                        periodsSelect.val(periods).trigger('change');
                    } else if (periodsSelect.length) {
                        periodsSelect.val(periods);
                    }

                    document.getElementById('edit_creating_task').value = creating_task;

                    // set form action
                    const form = document.getElementById('editTaskForm');
                    if (form) {
                        form.action = "{{ url('admin') }}/" + id;
                    }
                    // If the selected period type is Yearly, populate the edit datepicker input
                    try {
                        if ((type_periods || '').toString() === 'Yearly') {
                            // periods may be an array of strings like ['01 January', '15 March']
                            if (Array.isArray(periods) && periods.length) {
                                // If the datepicker is initialized, use its API to set the dates so selections show correctly
                                var $editDp = $('#edit-multi-datepicker');
                                if ($editDp.length && $editDp.data('datepicker')) {
                                    try {
                                        // bootstrap-datepicker accepts an array of Date objects or date strings matching the format.
                                        // We'll attempt to set the raw strings first; if that fails, fallback to input value.
                                        $editDp.datepicker('setDates', periods);
                                    } catch (innerErr) {
                                        // fallback: set the input value
                                        $editDp.val(periods.join(', '));
                                    }
                                } else {
                                    $editDp.val(periods.join(', '));
                                }
                            }
                        } else {
                            // clear datepicker when not Yearly
                            $('#edit-multi-datepicker').val('');
                        }
                    } catch (e) {
                        // ignore any JS errors here to avoid blocking modal
                        console.warn('Error populating edit datepicker', e);
                    }

                    // Show the modal programmatically after populating to ensure select2 & datepicker are initialized
                    $('#editTaskModal').modal('show');
                });
            });
        });
