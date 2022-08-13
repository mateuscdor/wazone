@include('layouts.header')

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            <h4>{{ __('Templates list') }}</h4>
            </div>
            <div class="content-body">
                <!-- templates list start -->
                <section class="app-template-list">
                    <!-- list and filter start -->
                    <div class="card">
                        <div class="card-body border-bottom">
                            <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addNewTemplate">{{ __('Add new template') }}</button>
                            <form action="{{ route('template.search') }}" method="GET">
                            @csrf
                                <div class="form-group form-group-feedback form-group-feedback-right search-box">
                                    <input type="text" name="filter" class="form-control-sm search-input" placeholder="{{ __('Name, Message') }}">
                                    <i data-feather="search" class="font-medium-4"></i>
                                </div>
                                <button type="submit" class="hidden">Search</button>
                            </form>
                        </div>
                        <div class="table-responsive pt-0">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>{{ __('Template name') }}</th>
                                        <th>{{ __('Message text') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($templates as $template)
                                    <tr>
                                        <td><a href="javascript:;" data-bs-target="#editTemplate-{{$template->id}}" data-bs-toggle="modal">
                                        {{ $template->name }}</a>
                                        </td>
                                        <td><a href="javascript:;" data-bs-target="#editTemplate-{{$template->id}}" data-bs-toggle="modal">
                                        {{ $template->msgtext }}</a>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#destroy{{$template->id}}">
                                                <i data-feather="trash" class="me-0"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Delete Modal -->
                                    <div class="modal fade modal-danger text-start" id="destroy{{$template->id}}" tabindex="-1" aria-labelledby="myModalLabel120" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="myModalLabel120">{{ __('Delete confirmation') }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    {{ __('Are you sure you want to delete?') }} <br><br>
                                                    <span class="text text-danger"> <b>{{ $template->name }}</b> </span><br><br>
                                                    {{ __('This process is irreversible.') }} <br>
                                                    {{ __('The record(s) will be deleted from the database permanently.') }}
                                                </div>
                                                <div class="modal-footer">
                                                <a class="btn btn-sm btn-danger" href="{{ route('template.destroy', ['template_id' => $template->id]) }}">{{ __('Delete') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Edit Template Modal -->
                                    <div class="modal fade" id="editTemplate-{{$template->id}}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-template">
                                            <div class="modal-content">
                                                <div class="modal-header bg-transparent">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                                    <div class="text-center mb-2">
                                                        <h1 class="mb-1">{{ __('Edit Template') }}</h1>
                                                    </div>
                                                    <form action="{{ route('template.update') }}" method="POST" id="editTemplateForm" class="row gy-1 pt-75">
                                                        @csrf
                                                        <div class="row">
                                                        <div class="col-12 col-md-6">
                                                            <input type="hidden"  name="template_id" value="{{ $template->id }}" />
                                                            <label class="form-label" for="name">{{ __('Template name') }}</label>
                                                            <input type="text" name="name" class="form-control" value="{{ $template->name }}" placeholder="{{ __('Template name') }}" required />
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <label class="form-label" for="msgtext">{{ __('Message text') }}</label>
                                                            <textarea id="msgtext" name="msgtext" class="form-control" rows="6" placeholder="Message text" required>{{ $template->msgtext }}</textarea>
                                                        </div>
                                                        <div class="col-12 text-center mt-2 pt-50">
                                                            <button type="submit" class="btn btn-primary me-1">{{ __('Submit') }}</button>
                                                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                                                {{ __('Cancel') }}
                                                            </button>
                                                        </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/ Edit Template Modal -->
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Modal to add new template starts-->
                        <div class="modal modal-slide-in new-template-modal fade" id="addNewTemplate">
                            <div class="modal-dialog">
                                <form action="{{ route('template.store') }}" method="POST" class="add-new-template modal-content pt-0">
                                @csrf
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                    <div class="modal-header mb-1">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ __('Add new template') }}</h5>
                                    </div>
                                    <div class="modal-body flex-grow-1">
                                        <div class="mb-1">
                                            <label class="form-label" for="name">{{ __('Template name') }}</label>
                                            <input type="text" name="name" class="form-control" placeholder="{{ __('Template name') }}" required />
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label" for="msgtext">{{ __('Message text') }}</label>
                                            <textarea id="msgtext" name="msgtext" class="form-control" rows="6" placeholder="{{ __('Message text') }}" required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary me-1 data-submit">{{ __('Submit') }}</button>
                                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Modal to add new template Ends-->
                    </div>
                    <!-- list and filter end -->
                </section>
                <!-- templates list ends -->
                <div class="row">
                    <div class="col-md-12">
                        {{ $templates->links() }}
                    </div>
                </div>
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
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="app-assets/js/core/app-menu.js"></script>
    <script src="app-assets/js/core/app.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="app-assets/js/scripts/components/components-alerts.js"></script>
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
