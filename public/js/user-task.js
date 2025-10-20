document.addEventListener('DOMContentLoaded', function () {
    const uploadButtons = document.querySelectorAll('.upload-btn');
    const modal = document.getElementById('uploadModal');
    const uploadForm = document.getElementById('uploadForm');
    const docIdInput = document.getElementById('modal_doc_id');

    uploadButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const docId = this.dataset.id;

            // Update hidden input
            docIdInput.value = docId;

            // Update form action sesuai format route
            uploadForm.action = "user/" + docId + "/upload";

            // Show modal
            $('#uploadModal').modal('show');
        });
    });
});


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


document.addEventListener('DOMContentLoaded', function () {
    const statusFilter = document.getElementById('statusFilter');
    const clearBtn = document.getElementById('clearFilterBtn');
    const searchInput = document.getElementById('tableSearch');
    
    // Initialize DataTable with client-side pagination
    const table = $('#dataTable').DataTable({
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        order: [[2, 'desc']], // Sort by Upload column (index 2) descending by default
        language: {
            search: "",
            searchPlaceholder: "Search in table...",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            infoEmpty: "No entries available",
            infoFiltered: "(filtered from _MAX_ total entries)",
            paginate: {
                first: "First",
                last: "Last",
                next: "Next",
                previous: "Previous"
            }
        },
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6">>rtip'
    });

    if (!statusFilter) return;

    // Custom filter function for status
    $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex) {
            const statusVal = statusFilter.value;
            const row = table.row(dataIndex).node();
            const rowStatus = (row.getAttribute('data-status') || '').toLowerCase();
            
            // Check status filter
            if (statusVal === 'all' || statusVal === rowStatus) {
                return true;
            }
            return false;
        }
    );

    // Apply filter when status dropdown changes
    statusFilter.addEventListener('change', function() {
        table.draw();
    });

    // Clear filter button
    if (clearBtn) {
        clearBtn.addEventListener('click', function (e) {
            e.preventDefault();
            statusFilter.value = 'all';
            if (searchInput) searchInput.value = '';
            table.search('').draw();
        });
    }

    // Custom search input integration
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            table.search(this.value).draw();
        });
    }
});
