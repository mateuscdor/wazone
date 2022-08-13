@include('layouts.header')

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            <h4>{{ __('Settings list') }}</h4>
            </div>
            <div class="content-body">
                <!-- settings list start -->
                <section class="app-setting-list">
                    <!-- list and filter start -->
                    <div class="card">
                        <div class="card-body border-bottom">
                            <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addNewSetting">{{ __('Add new setting') }}</button>
                            <a href="{{ route('setting.clearcache') }}" class="btn btn-danger float-end" >{{ __('Clear app cache') }}</a>
                            <form action="{{ route('setting.search') }}" method="GET">
                            @csrf
                                <div class="form-group form-group-feedback form-group-feedback-right search-box">
                                    <input type="text" name="filter" class="form-control-sm search-input" placeholder="Search key / value">
                                    <i data-feather="search" class="font-medium-4"></i>
                                </div>
                                <button type="submit" class="hidden">Search</button>
                            </form>
                        </div>
                        <div class="table-responsive pt-0">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>{{ __('Setting key') }}</th>
                                        <th>{{ __('Setting value') }}</th>
                                        <!-- <th>{{ __('Actions') }}</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($settings as $setting)
                                    @if($setting->key === 'encType' || $setting->key === 'orderID' || $setting->key === 'restApi') @continue @endif
                                    <tr>
                                        <td><a href="javascript:;" data-bs-target="#editSetting-{{$setting->id}}" data-bs-toggle="modal">
                                        {{ $setting->key }}</a>
                                        </td>
                                        <td><a href="javascript:;" data-bs-target="#editSetting-{{$setting->id}}" data-bs-toggle="modal">
                                        {{ $setting->value }}</a>
                                        </td>
                                        <!-- <td>
                                            <a class="btn btn-sm btn-danger" href="{{ route('setting.destroy', ['setting_id' => $setting->id]) }}">
                                                <i data-feather="trash" class="me-0"></i>
                                            </a>
                                        </td> -->
                                    </tr>
                                    <!-- Edit Setting Modal -->
                                    <div class="modal fade" id="editSetting-{{$setting->id}}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-setting">
                                            <div class="modal-content">
                                                <div class="modal-header bg-transparent">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                                    <div class="text-center mb-2">
                                                        <h1 class="mb-1">{{ __('Edit setting') }}</h1>
                                                    </div>
                                                    <form action="{{ route('setting.update') }}" method="POST" id="editSettingForm" class="row gy-1 pt-75">
                                                        @csrf
                                                        <div class="row">
                                                        <div class="col-12 col-md-6">
                                                            <input type="hidden"  name="setting_id" value="{{ $setting->id }}" />
                                                            <label class="form-label" for="key">{{ __('Setting key') }}</label>
                                                            <input type="text" name="key" class="form-control" value="{{ $setting->key }}" readonly />
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <label class="form-label" for="value">{{ __('Setting value') }}</label>
                                                            <input type="text" name="value" class="form-control" value="{{ $setting->value }}" />
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
                                    <!--/ Edit Setting Modal -->
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Modal to add new setting starts-->
                        <div class="modal modal-slide-in new-setting-modal fade" id="addNewSetting">
                            <div class="modal-dialog">
                                <form action="{{ route('setting.store') }}" method="POST" class="add-new-setting modal-content pt-0">
                                @csrf
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                    <div class="modal-header mb-1">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ __('Add new setting') }}</h5>
                                    </div>
                                    <div class="modal-body flex-grow-1">
                                        <div class="mb-1">
                                            <label class="form-label" for="key">{{ __('Setting key') }}</label>
                                            <input type="text" name="key" class="form-control" required />
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label" for="value">{{ __('Setting value') }}</label>
                                            <input type="text" name="value" class="form-control" required />
                                        </div>
                                        <button type="submit" class="btn btn-primary me-1 data-submit">{{ __('Submit') }}</button>
                                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Modal to add new setting Ends-->
                    </div>
                    <!-- list and filter end -->
                </section>
                <!-- settings list ends -->
                <div class="row">
                    <div class="col-md-12">
                        {{ $settings->links() }}
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
