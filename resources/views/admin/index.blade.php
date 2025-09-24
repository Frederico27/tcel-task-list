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
                    <h5 class="text-primary font-weight-bold m-0">
                        TASK LIST TCEL
                    </h5>
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
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Data Task</h6>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#addTaskModal">
                            <i class="fas fa-plus"></i> Add Task
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"
                                style="color: black">
                                <thead>
                                    <tr>
                                        <th>Type Documents</th>
                                        <th>PIC</th>
                                        <th>Approval</th>
                                        <th>Type Periods</th>
                                        <th>By Periods</th>
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
                                            <td>{{ $doc->periods['0']['period_type'] }}</td>
                                            <td>{{ $doc->periods['0']['period_value'] }}</td>
                                            <td>
                                                {{ $doc->creating_task <= 1 ? $doc->creating_task . ' day' : $doc->creating_task . ' days' }}
                                            </td>
                                            <td class="text-center">
                                                <a href="#" class="btn btn-sm btn-warning" data-toggle="modal"
                                                    data-target="#editTaskModal" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.deleteDocument', $doc->id_documents) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete"
                                                        onclick="return confirm('Are you sure?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
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

        <!-- Add Task Modal -->
        <div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog" aria-labelledby="addTaskModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTaskModalLabel">Add New Task</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Add Task Form -->
                    <form action="{{ route('admin.addDocument') }}" method="POST" autocomplete="off">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="type_document">Type Documents</label>
                                <input type="text" class="form-control" id="type_document" name="type_document"
                                    required autofocus placeholder="Enter document type">
                            </div>

                            <div class="form-group">
                                <label for="multiple-select-field-pic" class="form-label">PIC</label>
                                <select class="form-select select2" id="multiple-select-field-pic"
                                    data-placeholder="Select PIC" name="pic[]" multiple required style="width: 100%;">
                                    <option value="4444">Riko - 4444</option>
                                    <option value="5555">Enio - 5555</option>
                                    <option value="6666">Crescencio - 6666</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="multiple-select-field-approval" class="form-label">Approval</label>
                                <select class="form-select select2" id="multiple-select-field-approval"
                                    data-placeholder="Select Approvals" name="approval[]" multiple required
                                    style="width: 100%;">
                                    <option value="1111">Joao - 1111</option>
                                    <option value="2222">Markus - 2222</option>
                                    <option value="3333">Joana - 3333</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="type_periods" class="form-label">Type Periods</label>
                                <select class="form-control" id="type_periods" name="type_periods" required>
                                    <option value="default" disabled selected>Select period type</option>
                                    <option value="Daily">Daily</option>
                                    <option value="Weekly">Weekly</option>
                                    <option value="Yearly">Yearly</option>
                                </select>
                            </div>

                            <!-- MULTI DATE (day + month, no year) -->
                            <div class="form-group">
                                <label for="multi-datepicker" class="form-label">Select Dates</label>
                                <input type="text" id="multi-datepicker" class="form-control"
                                    placeholder="Select the dates and months" readonly
                                    style="background: #fff; cursor: pointer;">
                                <!-- hidden inputs will be appended here by JS before submit -->
                                <div id="selected-dates-container"></div>
                            </div>

                            <div class="form-group">
                                <label for="multiple-select-field-weekly" class="form-label">Select Days</label>
                                <select class="form-select select2" id="multiple-select-field-weekly"
                                    data-placeholder="Select Days" name="periods[]" multiple required
                                    style="width: 100%;">
                                    <option value="Monday">Monday</option>
                                    <option value="Tuesday">Tuesday</option>
                                    <option value="Wednesday">Wednesday</option>
                                    <option value="Thursday">Thursday</option>
                                    <option value="Friday">Friday</option>
                                    <option value="Saturday">Saturday</option>
                                    <option value="Sunday">Sunday</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="creating_task">Creating Task Before</label>
                                <input type="text" class="form-control" id="creating_task" name="creating_task"
                                    required placeholder="Enter Number of Days">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Task</button>
                        </div>
                    </form>

                    @push('scripts')
                        <!-- Select2 for better select UX -->
                        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
                            rel="stylesheet" />
                        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
                        <script>
                            $(document).ready(function() {
                                $('.select2').select2({
                                    dropdownParent: $('#addTaskModal'),
                                    width: 'resolve',
                                    theme: 'bootstrap4',
                                    placeholder: function() {
                                        $(this).data('placeholder');
                                    }
                                });

                                // Focus first input when modal opens
                                $('#addTaskModal').on('shown.bs.modal', function() {
                                    $('#type_document').trigger('focus');
                                });

                                // Add focus style to inputs
                                $('.form-control, .form-select').on('focus', function() {
                                    $(this).addClass('border-primary shadow');
                                }).on('blur', function() {
                                    $(this).removeClass('border-primary shadow');
                                });
                            });
                        </script>
                    @endpush
                </div>
            </div>
        </div>

        <!-- Edit Task Modal -->
        <div class="modal fade" id="editTaskModal" tabindex="-1" role="dialog" aria-labelledby="editTaskModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTaskModalLabel">Edit Task</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="editTaskForm" action="#" method="POST" autocomplete="off">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="edit_type_document">Type Documents</label>
                                <input type="text" class="form-control" id="edit_type_document" name="type_document"
                                    required autofocus placeholder="Enter document type">
                            </div>

                            <div class="form-group">
                                <label for="edit-multiple-select-field-pic" class="form-label">PIC</label>
                                <select class="form-select select2" id="edit-multiple-select-field-pic"
                                    data-placeholder="Select PIC" name="pic[]" multiple required style="width: 100%;">
                                    <option value="4444">Riko - 4444</option>
                                    <option value="5555">Enio - 5555</option>
                                    <option value="6666">Crescencio - 6666</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="edit-multiple-select-field-approval" class="form-label">Approval</label>
                                <select class="form-select select2" id="edit-multiple-select-field-approval"
                                    data-placeholder="Select Approvals" name="approval[]" multiple required
                                    style="width: 100%;">
                                    <option value="1111">Joao - 1111</option>
                                    <option value="2222">Markus - 2222</option>
                                    <option value="3333">Joana - 3333</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="edit_type_periods" class="form-label">Type Periods</label>
                                <select class="form-control" id="edit_type_periods" name="type_periods" required>
                                    <option value="default" disabled selected>Select period type</option>
                                    <option value="Daily">Daily</option>
                                    <option value="Weekly">Weekly</option>
                                    <option value="Yearly">Yearly</option>
                                </select>
                            </div>

                            <!-- MULTI DATE (day + month, no year) -->
                            <div class="form-group">
                                <label for="edit-multi-datepicker" class="form-label">Select Dates</label>
                                <input type="text" id="edit-multi-datepicker" class="form-control"
                                    placeholder="Select the dates and months" readonly
                                    style="background: #fff; cursor: pointer;">
                                <div id="edit-selected-dates-container"></div>
                            </div>

                            <div class="form-group">
                                <label for="edit-multiple-select-field-weekly" class="form-label">Select Days</label>
                                <select class="form-select select2" id="edit-multiple-select-field-weekly"
                                    data-placeholder="Select Days" name="periods[]" multiple required
                                    style="width: 100%;">
                                    <option value="Monday">Monday</option>
                                    <option value="Tuesday">Tuesday</option>
                                    <option value="Wednesday">Wednesday</option>
                                    <option value="Thursday">Thursday</option>
                                    <option value="Friday">Friday</option>
                                    <option value="Saturday">Saturday</option>
                                    <option value="Sunday">Sunday</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="edit_creating_task">Creating Task Before</label>
                                <input type="text" class="form-control" id="edit_creating_task" name="creating_task"
                                    required placeholder="Enter Number of Days">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update Task</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

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
@endsection

@push('scripts')
    <!-- include bootstrap-datepicker CSS/JS (CDN) and initialize the multi pickers -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="{{ asset('js/select2code.js') }}"></script>
@endpush
