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
                    <a href="{{ config('app.url') . 'user' }}">
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

                    {{-- <!-- Nav Item - Alerts -->
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
                                class="mr-2 d-none d-lg-inline text-gray-600 small">{{ session('sso_user')['fullname'] }}</span>
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
                        <div class="d-flex align-items-center mb-3">
                            <label for="statusFilter" class="mr-2 mb-0">Filter by status:</label>
                            <select id="statusFilter" class="form-control form-control-sm mr-2" style="width:auto;">
                                <option value="all">All</option>
                                @foreach ($status as $st)
                                    <option value="{{ strtolower($st) }}">{{ ucwords(str_replace('_', ' ', $st)) }}</option>
                                @endforeach
                            </select>
                            <button id="clearFilterBtn" class="btn btn-sm btn-secondary mr-3">Clear</button>

                            {{-- Search input pushed to the right --}}
                            <input id="tableSearch" type="search" class="form-control form-control-sm ml-auto"
                                placeholder="Search documents, period or approver..." style="width:280px;">
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"
                                style="color: black">
                                <thead>
                                    <tr>
                                        <th>Name Document</th>
                                        <th>Period</th>
                                        <th>Upload</th>
                                        <th>Status</th>
                                        <th>Approved By</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($docs as $doc)
                                        @php $s = strtolower($doc->status ?? ''); @endphp
                                        <tr data-status="{{ $s }}">
                                            <td>{{ $doc->document->type_document }}</td>
                                            <td>{{ $doc->periode_date }}</td>
                                            <td>
                                                @if ($doc->upload)
                                                    @php
                                                        $ext = strtolower(pathinfo($doc->upload, PATHINFO_EXTENSION));
                                                        $fileUrl = secure_asset($doc->upload); // karena kamu simpan langsung di public/uploads
                                                    @endphp

                                                    @if ($ext === 'pdf')
                                                        <a href="{{ $fileUrl }}" target="_blank">Preview PDF</a>
                                                    @elseif (in_array($ext, ['doc', 'docx', 'xls', 'xlsx']))
                                                        <a href="{{ $fileUrl }}" download>Download File</a>
                                                    @else
                                                        <a href="{{ $fileUrl }}" download>See File</a>
                                                    @endif
                                                @else
                                                    -
                                                @endif
                                            </td>


                                            <td class="task-status @if ($doc->status == 'rejected') clickable-rejection @endif"
                                                data-rejection="{{ $doc->rejected_reason ?? '' }}">
                                                @if ($s == 'rejected')
                                                    <a href="#" class="show-rejection"
                                                        data-rejection="{{ $doc->rejected_reason ?? '' }}">
                                                        <span class="badge badge-danger">Rejected</span>
                                                    </a>
                                                @elseif(in_array($s, ['waiting_document', 'waiting', 'pending', 'waiting_approval']))
                                                    <span class="badge badge-warning">Waiting</span>
                                                @elseif($s == 'approved')
                                                    <span class="badge badge-success">Approved</span>
                                                @else
                                                    <span class="badge badge-secondary">{{ $doc->status }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $doc->approved_by ?? '-' }}</td>
                                            @if ($doc->status == 'waiting_document')
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-sm btn-success upload-btn"
                                                        data-id="{{ $doc->id_pending_task }}"
                                                        data-file="{{ $doc->upload ? secure_asset('storage/' . $doc->upload) : '' }}">
                                                        Upload / Preview
                                                    </button>
                                                </td>
                                            @elseif ($doc->status == 'rejected')
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-sm btn-success upload-btn"
                                                        data-id="{{ $doc->id_pending_task }}"
                                                        data-file="{{ $doc->upload ? secure_asset('storage/' . $doc->upload) : '' }}">
                                                        Revise & Upload again
                                                    </button>
                                                </td>
                                            @else
                                                <td class="text-center">
                                                    <p class="text-muted">No actions available</p>
                                                </td>
                                            @endif

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

        <!-- Upload / Preview Modal -->
        <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form id="uploadForm" method="POST" action="{{ config('app.url') . "user/0/upload" }}"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="doc_id" id="modal_doc_id">

                        <div class="modal-header">
                            <h5 class="modal-title" id="uploadModalLabel">Upload / Preview Document</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="document_file" class="d-block">Select file (accepted: PDF, DOCX,
                                    Excel)</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="document_file"
                                        name="document_file"
                                        accept=".pdf,.docx,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                        aria-describedby="documentHelp">
                                    <label class="custom-file-label" for="document_file">Choose file</label>
                                </div>
                                <small id="documentHelp" class="form-text text-muted">
                                    PDF files will be previewed in the modal. DOCX/Excel will be available to download after
                                    upload.
                                </small>
                            </div>

                            <div id="previewArea" style="min-height:200px;">
                                <div id="noPreview" class="text-muted">No preview available.</div>
                                <div id="pdfPreview" class="d-none">
                                    <iframe id="pdfIframe" style="width:100%;height:480px;border:0;"></iframe>
                                </div>
                                <div id="otherPreview" class="d-none">
                                    <p id="otherMsg"></p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Upload</button>
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


        <!-- View-only Rejection Reason Modal for users -->
    <div class="modal fade" id="viewRejectionModal" tabindex="-1" role="dialog" aria-labelledby="viewRejectionLabel" aria-hidden="true">
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

@endsection

@push('scripts')
    <script src="{{ secure_asset('js/form-upload-file.js') }}"></script>
    <script src="{{ secure_asset('js/user-task.js') }}"></script>
@endpush
