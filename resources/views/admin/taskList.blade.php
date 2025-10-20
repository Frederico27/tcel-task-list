@extends('layouts.app')
@section('title', 'Admin Task Dashboard')

@section('content')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">


                <!-- Topbar Application Name -->
                <div class="d-none d-sm-inline-block ml-md-3 my-2 my-md-0">
                    <a href="{{ config('app.url') . 'admin/task' }}">
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
                    {{-- 
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
                    </li> --}}

                    {{-- <!-- Nav Item - Messages -->
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
                    </li> --}}

                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span
                                class="mr-2 d-none d-lg-inline text-gray-600 small">{{ session('sso_user.fullname') ?? '' }}</span>
                            <img class="img-profile rounded-circle"
                                src="https://cdn-icons-png.flaticon.com/512/4792/4792929.png">
                        </a>
                        <!-- Dropdown - User Information -->
                        {{-- <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
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
                        </div> --}}
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
                        {{-- Search form --}}
                        <form method="GET" action="{{ config('app.url') . 'admin/task' }}" class="form-inline mb-3">
                            <div class="input-group">
                                <input name="q" type="text" class="form-control" placeholder="Search documents..."
                                    value="{{ request('q') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                                </div>
                            </div>
                        </form>
                        <form id="bulk-approve-form" action="{{ config('app.url') . 'admin/approve-bulk' }}" method="POST"
                            style="display:inline;">
                            @csrf
                            <div id="bulk-inputs"></div>
                            <label class="ml-2 mr-2 align-middle"> <input type="checkbox" id="global-select-all" />
                                Select all visible</label>
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
                                            <td>
                                                @if (strtolower($doc->approval) == 'approved')
                                                    <span class="badge badge-success">Approved</span>
                                                @elseif(strtolower($doc->approval) == 'rejected')
                                                    <span class="badge badge-danger">Rejected</span>
                                                @elseif(in_array(strtolower($doc->approval), ['waiting_approval', 'waiting', 'pending']))
                                                    <span class="badge badge-warning">Waiting</span>
                                                @else
                                                    <span class="badge badge-secondary">{{ $doc->approval }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $doc->creating_task }}</td>
                                            <td class="text-center align-middle">
                                                <button type="button" class="btn btn-sm btn-info toggle-child"
                                                    data-child="#child-row-{{ $loop->index }}" aria-expanded="false">
                                                    Details (+)
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
                                                                    @if ($doc->pendingTask->contains('status', 'waiting_approval'))
                                                                        <input type="checkbox" class="select-all-child"
                                                                            title="Select all in this document" />
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
                                                                        @if ($task->status == 'waiting_approval')
                                                                            <input type="checkbox" class="task-checkbox"
                                                                                value="{{ $task->id_pending_task }}"
                                                                                data-doc-id="{{ $doc->id_documents }}" />
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
                                                                                $id = Hashids::encode($task->id_pending_task);
                                                                                $fileRoute = config('app.url') . "documents/$id/view";
                                                                            @endphp

                                                                            @if ($ext === 'pdf')
                                                                                <a href="{{ $fileRoute }}"
                                                                                    target="_blank">Preview PDF</a>
                                                                            @elseif (in_array($ext, ['doc', 'docx', 'xls', 'xlsx']))
                                                                                <a href="{{ $fileRoute }}"
                                                                                    download>Download File</a>
                                                                            @else
                                                                                <a href="{{ $fileRoute }}" download>See
                                                                                    File</a>
                                                                            @endif
                                                                        @else
                                                                            -
                                                                        @endif

                                                                    </td>


                                                                    <td class="task-status @if ($task->status == 'rejected') clickable-rejection @endif"
                                                                        data-rejection="{{ $task->rejected_reason ?? '' }}">
                                                                        @php $s = strtolower($task->status ?? ''); @endphp
                                                                        @if ($s == 'rejected')
                                                                            <a href="#" class="show-rejection"
                                                                                data-rejection="{{ $task->rejected_reason ?? '' }}">
                                                                                <span
                                                                                    class="badge badge-danger">Rejected</span>
                                                                            </a>
                                                                        @elseif(in_array($s, ['waiting_approval', 'waiting', 'pending']))
                                                                            <span class="badge badge-warning">Waiting
                                                                                Approval</span>
                                                                        @elseif($s == 'approved')
                                                                            <span
                                                                                class="badge badge-success">Approved</span>
                                                                        @else
                                                                            <span
                                                                                class="badge badge-secondary">{{ $task->status }}</span>
                                                                        @endif
                                                                    </td>
                                                                    <td class="text-center task-approved-by">
                                                                        {{ $task->approved_by ?? '-' }}</td>
                                                                    @if ($task->status == 'waiting_approval')
                                                                        <td class="text-center position-relative">
                                                                            {{-- Reject button - opens modal to input rejection reason --}}
                                                                            <button type="button"
                                                                                class="btn btn-sm btn-danger mb-1 reject-btn"
                                                                                data-action="{{ config('app.url') . "admin/reject/$task->id_pending_task" }}"
                                                                                data-task-id="{{ $task->id_pending_task }}">
                                                                                Reject
                                                                            </button>
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

    @push('scripts')
        <!-- DataTables JavaScript -->
        <script src="{{ config('app.url') . 'sb-admin/vendor/datatables/jquery.dataTables.min.js' }}"></script>
        <script src="{{ config('app.url') . 'sb-admin/vendor/datatables/dataTables.bootstrap4.min.js' }}"></script>
        
        <script>
            // Initialize DataTable for admin task list with child row support
            $(document).ready(function() {
                var table = $('#dataTable').DataTable({
                    pageLength: 10,
                    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    order: [[0, 'asc']], // Sort by Type Document column
                    language: {
                        search: "Search:",
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
                    // Custom sorting to handle child rows properly
                    createdRow: function(row, data, dataIndex) {
                        // Mark child rows so they stay with their parent
                        if ($(row).hasClass('child-row')) {
                            $(row).attr('data-child-row', 'true');
                        }
                    },
                    drawCallback: function(settings) {
                        // After each draw, ensure child rows are hidden by default
                        $('.child-row').hide();
                        $('.toggle-child').each(function() {
                            $(this).text('Details (+)');
                            $(this).attr('aria-expanded', 'false');
                        });
                    }
                });
                
                // Handle child row visibility when page changes
                table.on('page.dt', function() {
                    $('.child-row').hide();
                });
            });
        </script>
        
        <script src="{{ config('app.url') . 'js/admin-task.js' }}"></script>
    @endpush
@endsection

{{-- Rejection modal placed outside section so it's always present on page --}}
@push('scripts')
    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="reject-form" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="rejectModalLabel">Reject Document</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="rejection_reason">Rejection Reason</label>
                            <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="4" required></textarea>
                        </div>
                        <div class="alert alert-danger d-none" id="reject-error"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger" id="reject-submit">Submit Rejection</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endpush

@push('scripts')
    <!-- View-only Rejection Reason Modal -->
    <div class="modal fade" id="viewRejectionModal" tabindex="-1" role="dialog" aria-labelledby="viewRejectionLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Rejection Reason</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="viewRejectionText"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endpush
