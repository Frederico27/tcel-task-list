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
    const statusFilter = document.getElementById('statusFilter');
    const clearBtn = document.getElementById('clearFilterBtn');
    const tableBody = document.querySelector('#dataTable tbody');
    if (!statusFilter || !tableBody) return;

    function applyFilter() {
        const val = statusFilter.value;
        const rows = tableBody.querySelectorAll('tr');
        rows.forEach(row => {
            const s = (row.getAttribute('data-status') || '').toLowerCase();
            if (val === 'all' || val === s) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    statusFilter.addEventListener('change', applyFilter);
    if (clearBtn) {
        clearBtn.addEventListener('click', function (e) {
            e.preventDefault();
            statusFilter.value = 'all';
            applyFilter();
        });
    }
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
    const tableBody = document.querySelector('#dataTable tbody');
    const searchInput = document.getElementById('tableSearch');
    if (!statusFilter || !tableBody) return;

    function rowMatchesSearch(row, term) {
        if (!term) return true;
        term = term.toLowerCase();
        // check relevant columns: document name, period, approved_by, and status text
        const cols = [0, 1, 4, 3]; // index positions in the row
        for (let i of cols) {
            const cell = row.children[i];
            if (!cell) continue;
            const txt = (cell.textContent || '').toLowerCase();
            if (txt.indexOf(term) !== -1) return true;
        }
        return false;
    }

    function applyFilter() {
        const statusVal = statusFilter.value;
        const searchTerm = (searchInput && searchInput.value) ? searchInput.value.trim().toLowerCase() : '';
        const rows = tableBody.querySelectorAll('tr');
        rows.forEach(row => {
            const s = (row.getAttribute('data-status') || '').toLowerCase();
            const statusOk = (statusVal === 'all' || statusVal === s);
            const searchOk = rowMatchesSearch(row, searchTerm);
            if (statusOk && searchOk) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // debounce helper
    function debounce(fn, wait) {
        let t;
        return function (...args) {
            clearTimeout(t);
            t = setTimeout(() => fn.apply(this, args), wait);
        };
    }

    const debouncedApply = debounce(applyFilter, 200);

    statusFilter.addEventListener('change', applyFilter);
    if (clearBtn) {
        clearBtn.addEventListener('click', function (e) {
            e.preventDefault();
            statusFilter.value = 'all';
            if (searchInput) searchInput.value = '';
            applyFilter();
        });
    }

    if (searchInput) {
        searchInput.addEventListener('input', debouncedApply);
    }
});

