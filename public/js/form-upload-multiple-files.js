(function () {
    // Store temporary file objects
    let selectedFiles = [];
    let currentPreviewFile = null;

    // Helper to check extension
    function extensionOf(name) {
        return (name || '').split('.').pop().toLowerCase();
    }

    // Helper to format file size
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
    }

    // Render the file list
    function renderFileList() {
        const fileListContainer = document.getElementById('fileList');
        const fileListSection = document.getElementById('fileListSection');
        const previewSection = document.getElementById('previewSection');
        
        if (selectedFiles.length === 0) {
            fileListSection.classList.add('d-none');
            previewSection.classList.add('d-none');
            return;
        }

        fileListSection.classList.remove('d-none');
        previewSection.classList.remove('d-none');
        
        fileListContainer.innerHTML = '';

        selectedFiles.forEach((fileObj, index) => {
            const file = fileObj.file;
            const ext = extensionOf(file.name);
            let iconClass = 'fas fa-file';
            let textColor = 'text-secondary';

            if (ext === 'pdf') {
                iconClass = 'fas fa-file-pdf';
                textColor = 'text-danger';
            } else if (['doc', 'docx'].includes(ext)) {
                iconClass = 'fas fa-file-word';
                textColor = 'text-primary';
            } else if (['xls', 'xlsx'].includes(ext)) {
                iconClass = 'fas fa-file-excel';
                textColor = 'text-success';
            }

            const itemDiv = document.createElement('div');
            itemDiv.className = 'list-group-item d-flex justify-content-between align-items-center';
            itemDiv.innerHTML = `
                <div class="d-flex align-items-center flex-grow-1" style="cursor: ${ext === 'pdf' ? 'pointer' : 'default'};">
                    <i class="${iconClass} ${textColor} mr-2"></i>
                    <div>
                        <div class="font-weight-bold">${file.name}</div>
                        <small class="text-muted">${formatFileSize(file.size)}</small>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-danger remove-file-btn" data-index="${index}">
                    <i class="fas fa-times"></i>
                </button>
            `;

            // Add click event to preview PDF files
            if (ext === 'pdf') {
                const clickableArea = itemDiv.querySelector('.d-flex.align-items-center');
                clickableArea.addEventListener('click', function() {
                    previewFile(fileObj);
                    // Highlight selected item
                    document.querySelectorAll('#fileList .list-group-item').forEach(item => {
                        item.classList.remove('active');
                    });
                    itemDiv.classList.add('active');
                });
            }

            // Add remove button event
            const removeBtn = itemDiv.querySelector('.remove-file-btn');
            removeBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                removeFile(index);
            });

            fileListContainer.appendChild(itemDiv);
        });

        // Update custom file label
        updateFileInputLabel();
    }

    // Preview file (for PDFs)
    function previewFile(fileObj) {
        const file = fileObj.file;
        const ext = extensionOf(file.name);

        const noPreview = document.getElementById('noPreview');
        const pdfPreview = document.getElementById('pdfPreview');
        const otherPreview = document.getElementById('otherPreview');
        const pdfIframe = document.getElementById('pdfIframe');

        // Reset preview area
        noPreview.classList.add('d-none');
        pdfPreview.classList.add('d-none');
        otherPreview.classList.add('d-none');

        if (ext === 'pdf') {
            // Create object URL for preview if it doesn't exist
            if (!fileObj.objectUrl) {
                fileObj.objectUrl = URL.createObjectURL(file);
            }
            
            // Always update the iframe src to ensure preview is shown
            // This fixes the bug where clicking back to a previous file doesn't show preview
            pdfIframe.src = '';  // Clear first to force reload
            setTimeout(() => {
                pdfIframe.src = fileObj.objectUrl;
            }, 10);
            
            pdfPreview.classList.remove('d-none');
            currentPreviewFile = fileObj.objectUrl;
        } else {
            const otherMsg = document.getElementById('otherMsg');
            otherMsg.textContent = `Preview not available for .${ext} files. The file will be uploaded when you click Upload button.`;
            otherPreview.classList.remove('d-none');
        }
    }

    // Remove file from selection
    function removeFile(index) {
        const removedFile = selectedFiles[index];
        
        // If this file is currently being previewed, reset the preview
        if (removedFile.objectUrl && removedFile.objectUrl === currentPreviewFile) {
            resetPreview();
            currentPreviewFile = null;
        }
        
        // Revoke object URL if exists
        if (removedFile.objectUrl) {
            URL.revokeObjectURL(removedFile.objectUrl);
        }
        
        selectedFiles.splice(index, 1);
        renderFileList();
        
        // Reset preview if no files left
        if (selectedFiles.length === 0) {
            resetPreview();
        }
    }

    // Reset preview area
    function resetPreview() {
        const pdfIframe = document.getElementById('pdfIframe');
        pdfIframe.src = '';  // Clear the iframe source
        
        document.getElementById('noPreview').classList.remove('d-none');
        document.getElementById('pdfPreview').classList.add('d-none');
        document.getElementById('otherPreview').classList.add('d-none');
    }

    // Update file input label
    function updateFileInputLabel() {
        const fileLabel = document.querySelector('label[for="document_files"]');
        if (selectedFiles.length === 0) {
            fileLabel.textContent = 'Choose files';
        } else if (selectedFiles.length === 1) {
            fileLabel.textContent = '1 file selected';
        } else {
            fileLabel.textContent = `${selectedFiles.length} files selected`;
        }
    }

    // When Upload button is clicked in the table
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.upload-btn');
        if (!btn) return;
        
        const docId = btn.getAttribute('data-id');
        document.getElementById('modal_doc_id').value = docId;
        
        // Reset everything
        selectedFiles = [];
        currentPreviewFile = null;
        document.getElementById('document_files').value = '';
        renderFileList();
        resetPreview();
        
        $('#uploadModal').modal('show');
    });

    // When user selects files
    document.getElementById('document_files').addEventListener('change', function (e) {
        const files = Array.from(this.files);
        const allowed = ['pdf', 'doc', 'docx', 'xls', 'xlsx'];
        
        files.forEach(file => {
            const ext = extensionOf(file.name);
            
            if (!allowed.includes(ext)) {
                alert(`File type not allowed for "${file.name}". Allowed: PDF, DOC, DOCX, XLS, XLSX.`);
                return;
            }
            
            // Check if file already selected
            const exists = selectedFiles.some(f => f.file.name === file.name && f.file.size === file.size);
            if (!exists) {
                selectedFiles.push({
                    file: file,
                    objectUrl: null
                });
            }
        });
        
        renderFileList();
        
        // Clear the input so user can select same files again if needed
        this.value = '';
    });

    // Clean up object URLs when modal is closed
    $('#uploadModal').on('hidden.bs.modal', function () {
        selectedFiles.forEach(fileObj => {
            if (fileObj.objectUrl) {
                URL.revokeObjectURL(fileObj.objectUrl);
            }
        });
    });

    // Before form submission, create a new FormData with selected files
    document.getElementById('uploadForm').addEventListener('submit', function(e) {
        if (selectedFiles.length === 0) {
            e.preventDefault();
            alert('Please select at least one file to upload.');
            return false;
        }

        // Create new FormData to include our selected files
        const formData = new FormData();
        const docId = document.getElementById('modal_doc_id').value;
        
        // Add CSRF token
        const csrfToken = document.querySelector('input[name="_token"]').value;
        formData.append('_token', csrfToken);
        
        // Add all selected files
        selectedFiles.forEach(fileObj => {
            formData.append('document_files[]', fileObj.file);
        });

        // Prevent default and submit via fetch
        e.preventDefault();
        
        // Update form action with correct doc_id
        const form = this;
        form.action = form.action.replace('/user/0/', `/user/${docId}/`);
        
        // Disable upload button to prevent double submission
        const uploadBtn = document.getElementById('uploadBtn');
        const originalText = uploadBtn.innerHTML;
        uploadBtn.disabled = true;
        uploadBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Uploading...';
        
        // Submit using fetch
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (response.ok) {
                return response.text();
            }
            throw new Error('Upload failed');
        })
        .then(() => {
            // Success - reload page to show updated data
            window.location.reload();
        })
        .catch(error => {
            console.error('Upload error:', error);
            alert('Failed to upload files. Please try again.');
            uploadBtn.disabled = false;
            uploadBtn.innerHTML = originalText;
        });
    });
})();
