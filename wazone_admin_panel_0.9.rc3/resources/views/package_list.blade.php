@include('layouts.header')

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <h4>{{ __('Packages list') }}</h4>
            </div>
            <div class="content-body">
                <!-- packages list start -->
                <section class="app-package-list">
                    <!-- list and filter start -->
                    <div class="card">
                        <div class="card-body border-bottom">
                            <label> 0 = {{ __('Unlimited') }} </label>
                            <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addNewPackage">{{ __('Add new package') }}</button>
                        </div>
                        <div class="table-responsive pt-0">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Description') }}</th>
                                        <th>{{ __('Monthly') }}</th>
                                        <!-- <th>{{ __('Yearly') }}</th> -->
                                        <th>{{ __('Outbox') }}</th>
                                        <th>{{ __('Devices') }}</th>
                                        <th>{{ __('Templates') }}</th>
                                        <th>{{ __('Phonebooks') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($packages as $package)
                                    <tr>
                                        <td><a href="javascript:;" data-bs-target="#editPackage-{{$package->id}}" data-bs-toggle="modal">
                                        <span class="badge rounded-pill badge-light-primary me-1">{{ $package->name }}</span></a>
                                        </td>
                                        <td><a href="javascript:;" data-bs-target="#editPackage-{{$package->id}}" data-bs-toggle="modal">
                                        {{ $package->description }}</a>
                                        </td>
                                        <td><a href="javascript:;" data-bs-target="#editPackage-{{$package->id}}" data-bs-toggle="modal">
                                        {{ $package->rate_monthly }}</a>
                                        </td>
                                        <!-- <td><a href="javascript:;" data-bs-target="#editPackage-{{$package->id}}" data-bs-toggle="modal">
                                        {{ $package->rate_yearly }}</a>
                                        </td> -->
                                        <td><a href="javascript:;" data-bs-target="#editPackage-{{$package->id}}" data-bs-toggle="modal">
                                        {{ $package->max_outbox }}</a>
                                        </td>
                                        <td><a href="javascript:;" data-bs-target="#editPackage-{{$package->id}}" data-bs-toggle="modal">
                                        {{ $package->max_device }}</a>
                                        </td>
                                        <td><a href="javascript:;" data-bs-target="#editPackage-{{$package->id}}" data-bs-toggle="modal">
                                        {{ $package->max_template }}</a>
                                        </td>
                                        <td><a href="javascript:;" data-bs-target="#editPackage-{{$package->id}}" data-bs-toggle="modal">
                                        {{ $package->max_phonebook }}</a>
                                        </td>
                                        @if($package->id > 2)
                                        <td>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#destroy{{$package->id}}">
                                                <i data-feather="trash" class="me-0"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Delete Modal -->
                                    <div class="modal fade modal-danger text-start" id="destroy{{$package->id}}" tabindex="-1" aria-labelledby="myModalLabel120" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="myModalLabel120">{{ __('Delete confirmation') }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    {{ __('Are you sure you want to delete?') }} <br><br>
                                                    <span class="text text-danger"> <b>{{ $package->name }}</b> </span><br><br>
                                                    {{ __('This process is irreversible.') }} <br>
                                                    {{ __('The record(s) will be deleted from the database permanently.') }}
                                                </div>
                                                <div class="modal-footer">
                                                <a class="btn btn-sm btn-danger" href="{{ route('package.destroy', ['package_id' => $package->id]) }}">{{ __('Delete') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <!-- Edit Package Modal -->
                                    <div class="modal fade" id="editPackage-{{$package->id}}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-package">
                                            <div class="modal-content">
                                                <div class="modal-header bg-transparent">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                                    <div class="text-center mb-2">
                                                        <h1 class="mb-1">{{ __('Edit package form') }}</h1>
                                                    </div>
                                                    <form action="{{ route('package.update') }}" method="POST" id="editPackageForm" class="row gy-1 pt-75">
                                                        @csrf
                                                        <div class="row">
                                                        <div class="col-12 col-md-6">
                                                            <input type="hidden"  name="package_id" value="{{ $package->id }}" />
                                                            <label class="form-label" for="name">{{ __('Package name') }}</label>
                                                            <input type="text" name="name" class="form-control" value="{{ $package->name }}" placeholder="{{ __('Package name') }}" {{ ($package->name === 'super' || $package->name === 'trial' ? 'readonly' : '') }} required />
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <label class="form-label" for="description">{{ __('Description') }}</label>
                                                            <input type="text" name="description" class="form-control" value="{{ $package->description }}" placeholder="{{ __('Description') }}" {{ ($package->name === 'super' || $package->name === 'trial' ? 'readonly' : '') }} required />
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <label class="form-label" for="rate_monthly">{{ __('Price monthly') }}</label>
                                                            <input type="number" name="rate_monthly" class="form-control" value="{{ $package->rate_monthly }}" placeholder="{{ __('Price monthly') }}" {{ ($package->name === 'super' ? 'readonly' : '') }} required />
                                                        </div>
                                                        <!-- <div class="col-12 col-md-6">
                                                            <label class="form-label" for="rate_yearly">{{ __('Price yearly') }}</label>
                                                            <input type="number" name="rate_yearly" class="form-control" value="{{ $package->rate_yearly }}" placeholder="{{ __('Price yearly') }}" {{ ($package->name === 'super' ? 'readonly' : '') }} required />
                                                        </div> -->
                                                        <div class="col-12 col-md-6">
                                                            <label class="form-label" for="max_outbox">{{ __('Max outbox') }}</label>
                                                            <input type="number" name="max_outbox" class="form-control" value="{{ $package->max_outbox }}" placeholder="{{ __('Max outbox') }}" {{ ($package->name === 'super' ? 'readonly' : '') }} required />
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <label class="form-label" for="max_device">{{ __('Max device') }}</label>
                                                            <input type="number" name="max_device" class="form-control" value="{{ $package->max_device }}" placeholder="{{ __('Max device') }}" {{ ($package->name === 'super' ? 'readonly' : '') }} required />
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <label class="form-label" for="max_template">{{ __('Max template') }}</label>
                                                            <input type="number" name="max_template" class="form-control" value="{{ $package->max_template }}" placeholder="{{ __('Max template') }}" {{ ($package->name === 'super' ? 'readonly' : '') }} required />
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <label class="form-label" for="max_phonebook">{{ __('Max phonebook') }}</label>
                                                            <input type="number" name="max_phonebook" class="form-control" value="{{ $package->max_phonebook }}" placeholder="{{ __('Max phonebook') }}" {{ ($package->name === 'super' ? 'readonly' : '') }} required />
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
                                    <!--/ Edit Package Modal -->
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Modal to add new package starts-->
                        <div class="modal modal-slide-in new-package-modal fade" id="addNewPackage">
                            <div class="modal-dialog">
                                <form action="{{ route('package.store') }}" method="POST"  class="add-new-package modal-content pt-0">
                                @csrf
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                    <div class="modal-header mb-1">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ __('Add new package') }}</h5>
                                    </div>
                                    <div class="modal-body flex-grow-1">
                                        <div class="mb-1">
                                            <label class="form-label" for="name">{{ __('Package name') }}</label>
                                            <input type="text" name="name" class="form-control" placeholder="{{ __('Package name') }}" required />
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label" for="description">{{ __('Description') }}</label>
                                            <input type="text" name="description" class="form-control" placeholder="{{ __('Description') }}" required />
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label" for="rate_monthly">{{ __('Price monthly') }}</label>
                                            <input type="number" name="rate_monthly" class="form-control" placeholder="{{ __('Price monthly') }}" required />
                                        </div>
                                        <!-- <div class="mb-1">
                                            <label class="form-label" for="rate_yearly">{{ __('Price yearly') }}</label>
                                            <input type="number" name="rate_yearly" class="form-control" placeholder="{{ __('Price yearly') }}" required />
                                        </div> -->
                                        <div class="mb-1">
                                            <label class="form-label" for="max_outbox">{{ __('Max outbox') }}</label>
                                            <input type="number" name="max_outbox"class="form-control" placeholder="{{ __('Max outbox') }}" required />
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label" for="max_device">{{ __('Max device') }}</label>
                                            <input type="number" name="max_device" class="form-control" placeholder="{{ __('Max device') }}" required />
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label" for="max_template">{{ __('Max template') }}</label>
                                            <input type="number" name="max_template" class="form-control" placeholder="{{ __('Max template') }}" required />
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label" for="max_phonebook">{{ __('Max phonebook') }}</label>
                                            <input type="number" name="max_phonebook" class="form-control" placeholder="{{ __('Max phonebook') }}" required />
                                        </div>
                                        <button type="submit" class="btn btn-primary me-1 data-submit">{{ __('Submit') }}</button>
                                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Modal to add new package Ends-->
                    </div>
                    <!-- list and filter end -->
                </section>
                <!-- packages list ends -->
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
