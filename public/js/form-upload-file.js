(function () {
    // Helper to check extension
    function extensionOf(name) {
        return (name || '').split('.').pop().toLowerCase();
    }

    // Helper to get basename without querystring
    function basename(path) {
        return (path || '').split('/').pop().split('?')[0];
    }

    // When Upload / Preview button clicked
    document.addEventListener('click', function (e) {
        var btn = e.target.closest('.upload-btn');
        if (!btn) return;
        var docId = btn.getAttribute('data-id');
        var fileUrl = btn.getAttribute('data-file') || '';

        document.getElementById('modal_doc_id').value = docId;
        // reset UI
        document.getElementById('document_file').value = '';
        // reset label text
        var fileLabel = document.querySelector('label[for="document_file"].custom-file-label');
        if (fileUrl) {
            // if an existing file, show its name in the label
            fileLabel.textContent = basename(fileUrl);
        } else {
            fileLabel.textContent = 'Choose file';
        }

        document.getElementById('noPreview').classList.remove('d-none');
        document.getElementById('pdfPreview').classList.add('d-none');
        document.getElementById('otherPreview').classList.add('d-none');

        if (fileUrl) {
            // try determine extension from url
            var ext = extensionOf(fileUrl.split('?')[0]);
            if (ext === 'pdf') {
                document.getElementById('pdfIframe').src = fileUrl;
                document.getElementById('noPreview').classList.add('d-none');
                document.getElementById('pdfPreview').classList.remove('d-none');
            } else {
                document.getElementById('otherMsg').textContent = 'Preview is not available for .' +
                    ext + ' files. You can download the existing file.';
                var dl = document.getElementById('existingDownload');
                dl.href = fileUrl;
                document.getElementById('noPreview').classList.add('d-none');
                document.getElementById('otherPreview').classList.remove('d-none');
            }
        }

        $('#uploadModal').modal('show');
    });

    // When user selects a file to preview before upload
    document.getElementById('document_file').addEventListener('change', function (e) {
        var file = this.files[0];
        var fileLabel = document.querySelector('label[for="document_file"].custom-file-label');
        if (!file) {
            // reset label when no file chosen
            fileLabel.textContent = 'Choose file';
            return;
        }
        // show selected filename on the label
        fileLabel.textContent = file.name;

        var ext = extensionOf(file.name);
        // Accept only allowed types client-side
        var allowed = ['pdf', 'docx', 'xls', 'xlsx'];
        if (allowed.indexOf(ext) === -1) {
            alert('File type not allowed. Allowed: PDF, DOCX, Excel.');
            this.value = '';
            fileLabel.textContent = 'Choose file';
            return;
        }
        if (ext === 'pdf') {
            var url = URL.createObjectURL(file);
            document.getElementById('pdfIframe').src = url;
            document.getElementById('noPreview').classList.add('d-none');
            document.getElementById('otherPreview').classList.add('d-none');
            document.getElementById('pdfPreview').classList.remove('d-none');
        } else {
            document.getElementById('otherMsg').textContent =
                'Selected file preview is not available for .' + ext +
                ' files. After uploading you will be able to download it.';
            document.getElementById('noPreview').classList.add('d-none');
            document.getElementById('pdfPreview').classList.add('d-none');
            document.getElementById('otherPreview').classList.remove('d-none');
            document.getElementById('existingDownload').href = '#';
        }
    });
})();
