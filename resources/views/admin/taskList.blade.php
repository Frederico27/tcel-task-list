@extends('layouts.app')
@section('title', 'Admin Dashboard')

@section('content')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">


                <!-- Topbar Application Name -->
                <div class="d-none d-sm-inline-block ml-md-3 my-2 my-md-0">
                    <a href="{{ route('admin.taskList') }}">
                        <h5 class="text-danger font-weight-bold m-0">
                            TASK LIST TCEL
                        </h5>
                    </a>
                </div>


                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">

                    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                    <li class="nav-item dropdown no-arrow d-sm-none">
                        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-search fa-fw"></i>
                        </a>
                        <!-- Dropdown - Messages -->
                        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                            aria-labelledby="searchDropdown">
                            <form class="form-inline mr-auto w-100 navbar-search">
                                <div class="input-group">
                                    <input type="text" class="form-control bg-light border-0 small"
                                        placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button">
                                            <i class="fas fa-search fa-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li>

                    <!-- Nav Item - Alerts -->
                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bell fa-fw"></i>
                            <!-- Counter - Alerts -->
                            <span class="badge badge-danger badge-counter">3+</span>
                        </a>
                        <!-- Dropdown - Alerts -->
                        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                            aria-labelledby="alertsDropdown">
                            <h6 class="dropdown-header">
                                Alerts Center
                            </h6>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="mr-3">
                                    <div class="icon-circle bg-primary">
                                        <i class="fas fa-file-alt text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">December 12, 2019</div>
                                    <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="mr-3">
                                    <div class="icon-circle bg-success">
                                        <i class="fas fa-donate text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">December 7, 2019</div>
                                    $290.29 has been deposited into your account!
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="mr-3">
                                    <div class="icon-circle bg-warning">
                                        <i class="fas fa-exclamation-triangle text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">December 2, 2019</div>
                                    Spending Alert: We've noticed unusually high spending for your account.
                                </div>
                            </a>
                            <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                        </div>
                    </li>

                    <!-- Nav Item - Messages -->
                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-envelope fa-fw"></i>
                            <!-- Counter - Messages -->
                            <span class="badge badge-danger badge-counter">7</span>
                        </a>
                        <!-- Dropdown - Messages -->
                        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                            aria-labelledby="messagesDropdown">
                            <h6 class="dropdown-header">
                                Message Center
                            </h6>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="dropdown-list-image mr-3">
                                    <img class="rounded-circle" src="img/undraw_profile_1.svg" alt="...">
                                    <div class="status-indicator bg-success"></div>
                                </div>
                                <div class="font-weight-bold">
                                    <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                        problem I've been having.</div>
                                    <div class="small text-gray-500">Emily Fowler · 58m</div>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="dropdown-list-image mr-3">
                                    <img class="rounded-circle" src="img/undraw_profile_2.svg" alt="...">
                                    <div class="status-indicator"></div>
                                </div>
                                <div>
                                    <div class="text-truncate">I have the photos that you ordered last month, how
                                        would you like them sent to you?</div>
                                    <div class="small text-gray-500">Jae Chun · 1d</div>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="dropdown-list-image mr-3">
                                    <img class="rounded-circle" src="img/undraw_profile_3.svg" alt="...">
                                    <div class="status-indicator bg-warning"></div>
                                </div>
                                <div>
                                    <div class="text-truncate">Last month's report looks great, I am very happy with
                                        the progress so far, keep up the good work!</div>
                                    <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="dropdown-list-image mr-3">
                                    <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60"
                                        alt="...">
                                    <div class="status-indicator bg-success"></div>
                                </div>
                                <div>
                                    <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                                        told me that people say this to all dogs, even if they aren't good...</div>
                                    <div class="small text-gray-500">Chicken the Dog · 2w</div>
                                </div>
                            </a>
                            <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                        </div>
                    </li>

                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">Douglas McGee</span>
                            <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                            aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profile
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                Settings
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                Activity Log
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>
                    </li>

                </ul>

            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        {{-- Bulk approve form (will be populated with selected ids on submit) --}}
                        <form id="bulk-approve-form" action="{{ route('admin.bulkApprove') }}" method="POST"
                            style="display:inline;">
                            @csrf
                            <div id="bulk-inputs"></div>
                            <label class="ml-2 mr-2 align-middle"> <input type="checkbox" id="global-select-all" /> Select all visible</label>
                            <button id="bulk-approve-button" type="submit" class="btn btn-sm btn-primary mb-3"
                                disabled>Approve Selected</button>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"
                                style="color: black">
                                <thead>
                                    <tr>
                                        <th>Type Document</th>
                                        <th>PIC</th>
                                        <th>Approval</th>
                                        <th>Creating Task Before</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($docs as $doc)
                                        <tr>
                                            <td>{{ $doc->type_document }}</td>
                                            <td>{{ $doc->pic }}</td>
                                            <td>{{ $doc->approval }}</td>
                                            <td>{{ $doc->creating_task }}</td>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-sm btn-secondary toggle-child float-right ml-2"
                                                    data-child="#child-row-{{ $loop->index }}" aria-expanded="false">+
                                                </button>
                                            </td>

                                        </tr>

                                        {{-- Child row (mockup) - design similar to main row but shown below as an expandable/detail area --}}
                                        <tr id="child-row-{{ $loop->index }}" class="child-row bg-light"
                                            style="display:none;">
                                            <td colspan="6">
                                                <div class="p-3">
                                                    <h6 class="font-weight-bold mb-2">Document Details</h6>

                                                    <table class="table table-sm table-bordered mb-0"
                                                        style="color: black; background: #fff;">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center" style="width:40px;">
                                                                    @if($doc->pendingTask->contains('status', 'waiting_approval'))
                                                                        <input type="checkbox" class="select-all-child" title="Select all in this document" />
                                                                    @endif
                                                                </th>
                                                                <th>Name Document</th>
                                                                <th>Period</th>
                                                                <th>Upload</th>
                                                                <th>Status</th>
                                                                <th>Approved By</th>
                                                                <th class="text-center">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($doc->pendingTask as $task)
                                                                <tr data-task-id="{{ $task->id_pending_task }}">
                                                                    <td class="text-center">
                                                                        @if($task->status == 'waiting_approval')
                                                                            <input type="checkbox" class="task-checkbox" value="{{ $task->id_pending_task }}" data-doc-id="{{ $doc->id_documents }}" />
                                                                        @endif
                                                                    </td>
                                                                    <td>{{ $doc->type_document }}</td>
                                                                    <td>{{ $task->periode_date }}</td>
                                                                    <td>
                                                                        @if ($task->upload)
                                                                            @php
                                                                                $ext = strtolower(
                                                                                    pathinfo(
                                                                                        $task->upload,
                                                                                        PATHINFO_EXTENSION,
                                                                                    ),
                                                                                );
                                                                                $fileUrl = asset($task->upload); // karena kamu simpan langsung di public/uploads
                                                                            @endphp

                                                                            @if ($ext === 'pdf')
                                                                                <a href="{{ $fileUrl }}"
                                                                                    target="_blank">Preview PDF</a>
                                                                            @elseif (in_array($ext, ['doc', 'docx', 'xls', 'xlsx']))
                                                                                <a href="{{ $fileUrl }}"
                                                                                    download>Download File</a>
                                                                            @else
                                                                                <a href="{{ $fileUrl }}" download>See
                                                                                    File</a>
                                                                            @endif
                                                                        @else
                                                                            -
                                                                        @endif
                                                                    </td>


                                                                    <td class="task-status">
                                                                        {{ $task->status }}
                                                                    </td>
                                                                    <td class="text-center task-approved-by">{{ $task->approved_by ?? '-' }}</td>
                                                                    @if ($task->status == 'waiting_approval')
                                                                        <td class="text-center position-relative">
                                                                            {{-- Approve Form --}}
                                                                            <form
                                                                                action="{{ route('admin.approveDocument', $task->id_pending_task) }}"
                                                                                method="POST" style="display:inline;">
                                                                                @csrf
                                                                                <button type="submit"
                                                                                    class="btn btn-sm btn-success mb-1 single-approve-btn"
                                                                                    data-task-id="{{ $task->id_pending_task }}"
                                                                                    onclick="return confirm('Are you sure you want to approve this document?')">
                                                                                    Approve
                                                                                </button>
                                                                            </form>

                                                                            {{-- Reject Form --}}
                                                                            <form
                                                                                action="{{ route('admin.rejectDocument', $task->id_pending_task) }}"
                                                                                method="POST" style="display:inline;">
                                                                                @csrf
                                                                                <button type="submit"
                                                                                    class="btn btn-sm btn-danger mb-1"
                                                                                    onclick="return confirm('Are you sure you want to reject this document?')">
                                                                                    Reject
                                                                                </button>
                                                                            </form>
                                                                        </td>
                                                                    @else
                                                                        <td class="text-center">
                                                                            <p class="text-muted d-inline-block mr-2">No
                                                                                actions available</p>
                                                                            {{-- Toggle child row button when no other actions --}}
                                                                            {{-- <button type="button"
                                                                                class="btn btn-sm btn-secondary toggle-child float-right ml-2"
                                                                                data-child="#child-row-{{ $loop->index }}"
                                                                                aria-expanded="false">+
                                                                            </button> --}}
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; TCEL-TASK-LIST {{ date('Y') }}</span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.toggle-child').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var selector = btn.getAttribute('data-child');
                    var child = document.querySelector(selector);
                    if (!child) return;
                    var isHidden = child.style.display === 'none' || getComputedStyle(child)
                        .display === 'none';
                    if (isHidden) {
                        child.style.display = '';
                        btn.textContent = '-';
                        btn.setAttribute('aria-expanded', 'true');
                    } else {
                        child.style.display = 'none';
                        btn.textContent = '+';
                        btn.setAttribute('aria-expanded', 'false');
                    }
                });
            });
        });
    </script>

    <script>
        // Enhanced bulk selection and AJAX submit
        document.addEventListener('DOMContentLoaded', function() {
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
                globalSelectAll.addEventListener('change', function() {
                    const all = document.querySelectorAll('.task-checkbox');
                    all.forEach(cb => cb.checked = globalSelectAll.checked);
                    // also toggle per-document headers
                    document.querySelectorAll('.select-all-child').forEach(h => h.checked = globalSelectAll.checked);
                    updateBulkInputs();
                });
            }

            // per-document select-all
            document.querySelectorAll('.select-all-child').forEach(function(selectAll) {
                selectAll.addEventListener('change', function() {
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
            document.addEventListener('change', function(e) {
                if (e.target && e.target.classList.contains('task-checkbox')) {
                    updateBulkInputs();
                }
            });

            // AJAX submit for bulk form (progressive enhancement)
            bulkForm.addEventListener('submit', function(ev) {
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
                    headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
                    body: formData,
                }).then(r => r.json())
                    .then(data => {
                        if (data.success) {
                            // Update UI for each approved task
                            ids.forEach(id => {
                                const row = document.querySelector('tr[data-task-id="' + id + '"]');
                                if (!row) return;
                                const statusCell = row.querySelector('.task-status');
                                const approvedByCell = row.querySelector('.task-approved-by');
                                if (statusCell) statusCell.textContent = 'approved';
                                if (approvedByCell) approvedByCell.textContent = data.approved_by || 'Admin';
                                // remove action buttons
                                const actionCell = row.querySelector('td.position-relative');
                                if (actionCell) actionCell.innerHTML = '<p class="text-muted d-inline-block mr-2">No actions available</p>';
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
            document.addEventListener('click', function(e) {
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
                    fetch(action, { method: 'POST', headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' }, body: fd })
                        .then(r => r.json())
                        .then(data => {
                            if (data.success) {
                                const row = document.querySelector('tr[data-task-id="' + taskId + '"]');
                                if (row) {
                                    const statusCell = row.querySelector('.task-status');
                                    const approvedByCell = row.querySelector('.task-approved-by');
                                    if (statusCell) statusCell.textContent = 'approved';
                                    if (approvedByCell) approvedByCell.textContent = data.approved_by || 'Admin';
                                    const actionCell = row.querySelector('td.position-relative');
                                    if (actionCell) actionCell.innerHTML = '<p class="text-muted d-inline-block mr-2">No actions available</p>';
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
    </script>
@endsection
