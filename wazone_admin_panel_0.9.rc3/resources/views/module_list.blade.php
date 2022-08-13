@include('layouts.header')
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/vendors/css/dropzone/dropzone.min.css">

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div id="jGrowl" class="jGrowl alert alert-success alert-dismissible fade show" role="alert">
            <div class="jGrowl-notification"></div>
        </div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <h4>{{ __('Modules manager') }}</h4>
            </div>
            <div class="content-body">
                <!-- modules list start -->
                <section class="app-module-list">
                    <!-- list and filter start -->
                    <div class="card">
                        @if (!$checkZipExtension)
                            <div class="card-body">
                              <p class="text-danger font-weight-bold"><b>Zip PHP Extension</b> is not enabled.
                                <br>
                                Therefore, you will not be able to upload any Premium Modules.
                                <br>
                                <span class="font-weight-normal">Kindly contact your hosting provider to enable the <b>Zip PHP Extension</b> for your server.</span>
                              </p>
                            </div>
                        @else
                        <div class="card-body border-bottom">
                            <div class="card-body">
                                <div class="col-md-12" id="moduleUploadBlock" style="display: block;">
                                    <div class="card-body">
                                        <form method="POST" action="{{ route('module.store') }}" enctype="multipart/form-data"
                                            class="dropzone" id="module_uploader">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="table-responsive pt-0">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Description') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Version') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($modules as $module)
                                    <?php $lower_name = $module->getLowerName(); ?>
                                    <tr>
                                        <td>
                                            {{ $module->getName() }}
                                        </td>
                                        <td>
                                            {!! $module->getDescription() !!}
                                        </td>
                                        <td>
                                            @if ($module->isEnabled())
                                            <span class="badge rounded-pill badge-light-success me-1">Enabled</span>
                                            @else
                                            <span class="badge rounded-pill badge-light-danger me-1">Disabled</span>
                                            @endif
                                        </td>
                                        <td>
                                            {!! config("$lower_name.version") !!}
                                        </td>
                                        <td>
                                            @if ($module->isEnabled())
                                            <a class="btn btn-sm btn-danger" href="{{ route('module.disable', ['module_name' => $module->getName()]) }}">Disable</a>
                                            @else
                                            <a class="btn btn-sm btn-success" href="{{ route('module.enable', ['module_name' => $module->getName()]) }}">Enable</a>
                                            @endif
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#destroy{{$module->getName()}}">
                                                <i data-feather="trash" class="me-0"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Delete Modal -->
                                    <div class="modal fade modal-danger text-start" id="destroy{{$module->getName()}}" tabindex="-1" aria-labelledby="myModalLabel120" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="myModalLabel120">{{ __('Delete confirmation') }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    {{ __('Are you sure you want to delete?') }} <br><br>
                                                    <span class="text text-danger"> <b>{{ $module->getName() }}</b> </span><br><br>
                                                    {{ __('This process is irreversible.') }} <br>
                                                    {{ __('The record(s) will be deleted from the database permanently.') }}
                                                </div>
                                                <div class="modal-footer">
                                                    <a class="btn btn-sm btn-danger" href="{{ route('module.destroy', ['module_name' => $module->getName()]) }}">{{ __('Delete') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="modal fade" id="AddNewModule" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                                <div class="modal-content">
                                    <div class="modal-header bg-transparent">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body pb-5 px-sm-5 pt-50">
                                        <div class="text-center mb-2">
                                            <h1 class="mb-1">{{ __('Upload new module') }}</h1>
                                            <div class="col-md-12" id="moduleUploadBlock" style="display: block;">
                                    
                                                <div class="card-body">
                                                    <form method="POST" action="{{ route('module.store') }}" enctype="multipart/form-data"
                                                        class="dropzone" id="module_uploader">
                                                        @csrf
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal to add new module starts-->
                        <div class="modal modal-slide-in new-module-modal fade" id="addNewModule">
                            <div class="modal-dialog">
                                <form action="{{ route('module.store') }}" method="POST"  enctype="multipart/form-data" id="module_uploader" class="dropzone add-new-module modal-content pt-0">
                                    @csrf
                                    <div>
                                        <h3>drag-and-drop WZ-ModuleName.zip file in this Box</h3>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Modal to add new module Ends-->
                    </div>
                    <!-- list and filter end -->
                </section>
                <!-- modules list ends -->
            </div>
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Vendor JS-->
    <script src="app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="app-assets/vendors/js/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="app-assets/vendors/js/jquery/jquery.min.js"></script>
    <script src="app-assets/vendors/js/dropzone/dropzone.min.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="app-assets/js/core/app-menu.js"></script>
    <script src="app-assets/js/core/app.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="app-assets/js/scripts/components/components-alerts.js"></script>
    <script src="app-assets/js/scripts/components/components-uploader.js"></script>
    <!-- END: Page JS-->

<script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })
</script>

@include('layouts.footer')
