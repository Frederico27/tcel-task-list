document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.toggle-child').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var selector = btn.getAttribute('data-child');
            var child = document.querySelector(selector);
            if (!child) return;
            var isHidden = child.style.display === 'none' || getComputedStyle(child)
                .display === 'none';
            if (isHidden) {
                child.style.display = '';
                btn.textContent = 'Details (-)';
                btn.setAttribute('aria-expanded', 'true');
            } else {
                child.style.display = 'none';
                btn.textContent = 'Details (+)';
                btn.setAttribute('aria-expanded', 'false');
            }
        });
    });
});

    // Enhanced bulk selection and AJAX submit
    document.addEventListener('DOMContentLoaded', function () {
        const bulkButton = document.getElementById('bulk-approve-button');
        const bulkInputs = document.getElementById('bulk-inputs');
        const bulkForm = document.getElementById('bulk-approve-form');
        const globalSelectAll = document.getElementById('global-select-all');

        function getCheckedIds() {
            return Array.from(document.querySelectorAll('.task-checkbox:checked')).map(cb => cb.value);
        }

        function updateBulkInputs() {
            bulkInputs.innerHTML = '';
            const checked = getCheckedIds();
            if (checked.length > 0) {
                bulkButton.disabled = false;
                checked.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'ids[]';
                    input.value = id;
                    bulkInputs.appendChild(input);
                });
            } else {
                bulkButton.disabled = true;
            }
        }

        // Global select all visible (only toggles currently rendered checkboxes)
        if (globalSelectAll) {
            globalSelectAll.addEventListener('change', function () {
                const all = document.querySelectorAll('.task-checkbox');
                all.forEach(cb => cb.checked = globalSelectAll.checked);
                // also toggle per-document headers
                document.querySelectorAll('.select-all-child').forEach(h => h.checked = globalSelectAll
                    .checked);
                updateBulkInputs();
            });
        }

        // per-document select-all
        document.querySelectorAll('.select-all-child').forEach(function (selectAll) {
            selectAll.addEventListener('change', function () {
                const header = selectAll.closest('thead');
                if (!header) return;
                const tbody = header.parentElement.querySelector('tbody');
                if (!tbody) return;
                const checkboxes = tbody.querySelectorAll('.task-checkbox');
                checkboxes.forEach(cb => cb.checked = selectAll.checked);
                updateBulkInputs();
            });
        });

        // individual checkboxes
        document.addEventListener('change', function (e) {
            if (e.target && e.target.classList.contains('task-checkbox')) {
                updateBulkInputs();
            }
        });

        // AJAX submit for bulk form (progressive enhancement)
        bulkForm.addEventListener('submit', function (ev) {
            // If JS-enabled, prevent default and send AJAX request
            ev.preventDefault();
            const ids = getCheckedIds();
            if (!ids.length) return;

            if (!confirm('Approve selected documents?')) return;

            // Prepare FormData
            const formData = new FormData();
            ids.forEach(id => formData.append('ids[]', id));
            // CSRF token
            const token = document.querySelector('input[name="_token"]').value;

            fetch(bulkForm.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    body: formData,
                }).then(r => r.json())
                .then(data => {
                    if (data.success) {
                        // Update UI for each approved task
                        ids.forEach(id => {
                            const row = document.querySelector('tr[data-task-id="' + id +
                                '"]');
                            if (!row) return;
                            const statusCell = row.querySelector('.task-status');
                            const approvedByCell = row.querySelector('.task-approved-by');
                            if (statusCell) statusCell.textContent = 'approved';
                            if (approvedByCell) approvedByCell.textContent = data
                                .approved_by || 'Admin';
                            // remove action buttons
                            const actionCell = row.querySelector('td.position-relative');
                            if (actionCell) actionCell.innerHTML =
                                '<p class="text-muted d-inline-block mr-2">No actions available</p>';
                            // uncheck the checkbox
                            const cb = row.querySelector('.task-checkbox');
                            if (cb) cb.checked = false;
                        });
                        updateBulkInputs();
                        alert(data.message || (ids.length + ' item(s) approved'));
                    } else {
                        alert(data.message || 'Failed to approve items');
                    }
                }).catch(err => {
                    console.error(err);
                    alert('An error occurred while approving items');
                });
        });

        // Single approve button enhancement: intercept and update UI without full reload
        document.addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('single-approve-btn')) {
                // allow default form submission to proceed if user cancels confirm
                // but enhance with fetch if confirmed
                e.preventDefault();
                const btn = e.target;
                const taskId = btn.getAttribute('data-task-id');
                if (!confirm('Are you sure you want to approve this document?')) return;
                const action = btn.closest('form').action;
                const token = document.querySelector('input[name="_token"]').value;
                const fd = new FormData();
                // empty payload; route expects only CSRF
                fetch(action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json'
                        },
                        body: fd
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (data.success) {
                            const row = document.querySelector('tr[data-task-id="' + taskId + '"]');
                            if (row) {
                                const statusCell = row.querySelector('.task-status');
                                const approvedByCell = row.querySelector('.task-approved-by');
                                if (statusCell) statusCell.textContent = 'approved';
                                if (approvedByCell) approvedByCell.textContent = data.approved_by ||
                                    'Admin';
                                const actionCell = row.querySelector('td.position-relative');
                                if (actionCell) actionCell.innerHTML =
                                    '<p class="text-muted d-inline-block mr-2">No actions available</p>';
                            }
                            alert(data.message || 'Document approved');
                        } else {
                            alert(data.message || 'Failed');
                        }
                    }).catch(err => {
                        console.error(err);
                        alert('An error occurred');
                    });
            }
        });
    });

// Rejection modal handling
document.addEventListener('DOMContentLoaded', function () {
    const rejectModalEl = document.getElementById('rejectModal');
    if (!rejectModalEl) return;

    // Using Bootstrap's modal via jQuery (project already uses Bootstrap)
    const $rejectModal = window.jQuery ? window.jQuery(rejectModalEl) : null;
    const rejectForm = document.getElementById('reject-form');
    const rejectionTextarea = document.getElementById('rejection_reason');
    const rejectError = document.getElementById('reject-error');

    let currentAction = null;
    let currentTaskId = null;

    // Open modal when clicking reject button
    document.addEventListener('click', function (e) {
        const btn = e.target.closest && e.target.closest('.reject-btn');
        if (!btn) return;
        currentAction = btn.getAttribute('data-action');
        currentTaskId = btn.getAttribute('data-task-id');
        if (rejectError) rejectError.classList.add('d-none');
        if (rejectionTextarea) rejectionTextarea.value = '';
        // set form action (for progressive enhancement / fallback)
        if (rejectForm) rejectForm.action = currentAction;
        if ($rejectModal) $rejectModal.modal('show');
    });

    // Handle form submit via AJAX
    if (rejectForm) {
        rejectForm.addEventListener('submit', function (ev) {
            ev.preventDefault();
            const reason = rejectionTextarea ? rejectionTextarea.value.trim() : '';
            if (!reason) {
                if (rejectError) {
                    rejectError.textContent = 'Please provide a reason for rejection.';
                    rejectError.classList.remove('d-none');
                }
                return;
            }

            const tokenInput = rejectForm.querySelector('input[name="_token"]');
            const token = tokenInput ? tokenInput.value : (document.querySelector('input[name="_token"]') ? document.querySelector('input[name="_token"]').value : null);
            if (!currentAction) {
                console.error('No action URL for reject');
                return;
            }

            const fd = new FormData();
            fd.append('rejection_reason', reason);

            if (token) fd.append('_token', token);

            fetch(currentAction, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json'
                },
                body: fd
            }).then(r => r.json())
            .then(data => {
                if (data.success) {
                    // update UI: find the task row
                    if (currentTaskId) {
                        const row = document.querySelector('tr[data-task-id="' + currentTaskId + '"]');
                        if (row) {
                            const statusCell = row.querySelector('.task-status');
                            const approvedByCell = row.querySelector('.task-approved-by');
                            if (statusCell) {
                                // make status clickable and store rejection reason
                                const reason = data.rejection_reason || (rejectionTextarea ? rejectionTextarea.value.trim() : '');
                                statusCell.setAttribute('data-rejection', reason);
                                statusCell.classList.add('clickable-rejection');
                                statusCell.innerHTML = '<a href="#" class="show-rejection" data-rejection="' + (reason ? reason.replace(/"/g, '&quot;') : '') + '">rejected</a>';
                            }
                            if (approvedByCell) approvedByCell.textContent = data.rejected_by || 'Admin';
                            const actionCell = row.querySelector('td.position-relative');
                            if (actionCell) actionCell.innerHTML = '<p class="text-muted">Rejected</p>';
                        }
                    }
                    if ($rejectModal) $rejectModal.modal('hide');
                    alert(data.message || 'Document rejected');
                } else {
                    if (rejectError) {
                        rejectError.textContent = data.message || 'Failed to reject document';
                        rejectError.classList.remove('d-none');
                    } else {
                        alert(data.message || 'Failed to reject document');
                    }
                }
            }).catch(err => {
                console.error(err);
                if (rejectError) {
                    rejectError.textContent = 'An error occurred while rejecting the document.';
                    rejectError.classList.remove('d-none');
                } else {
                    alert('An error occurred while rejecting the document.');
                }
            });
        });
    }
});

// Show rejection reason modal (view-only)
document.addEventListener('DOMContentLoaded', function () {
    const viewModalEl = document.getElementById('viewRejectionModal');
    if (!viewModalEl) return;
    const $viewModal = window.jQuery ? window.jQuery(viewModalEl) : null;
    const viewText = document.getElementById('viewRejectionText');

    document.addEventListener('click', function (e) {
        const a = e.target.closest && e.target.closest('.show-rejection');
        if (!a) return;
        e.preventDefault();
        const reason = a.getAttribute('data-rejection') || '';
        if (viewText) viewText.textContent = reason || 'No reason provided.';
        if ($viewModal) $viewModal.modal('show');
    });
});
