@include('layouts.header')

<!-- BEGIN: Content-->
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <h4>Blocked Numbers</h4>
        </div>
        <div class="content-body">
            <!-- blocekd list start -->
            <section class="app-blocked-list">
                <!-- list and filter start -->
                <div class="card">
                    <div class="card-body border-bottom">
                        <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#blockNumber">Block a Number</button>
                        <form action="{{ route('blocked.search') }}" method="GET">
                            @csrf
                            <div class="form-group form-group-feedback form-group-feedback-right search-box">
                                <input type="text" name="filter" class="form-control-sm search-input" placeholder="{{ __('Phone') }}">
                                <i data-feather="search" class="font-medium-4"></i>
                            </div>
                            <button type="submit" class="hidden">Search</button>
                        </form>
                    </div>
                    <div class="table-responsive pt-0">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ __('Phone') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($blocked as $number)
                                <tr>
                                    <td>{{ $number->mobile }}</td>
                                    <td>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#destroy{{$number->id}}">
                                            <i data-feather="trash" class="me-0"></i>
                                        </button>
                                    </td>
                                </tr>
                                <!-- Start Delete Modal -->
                                <div class="modal fade modal-danger text-start" id="destroy{{$number->id}}" tabindex="-1" aria-labelledby="myModalLabel120" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="myModalLabel120">{{ __('Delete confirmation') }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                {{ __('Are you sure you want to delete?') }} <br><br>
                                                <span class="text text-danger"> <b>{{ $number->mobile }}</b> </span><br><br>
                                                {{ __('This process is irreversible.') }} <br>
                                                {{ __('The record(s) will be deleted from the database permanently.') }}
                                            </div>
                                            <div class="modal-footer">
                                                <a class="btn btn-sm btn-danger" href="{{ route('blocked.destroy', ['blocked_id' => $number->id]) }}">{{ __('Delete') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Delete Modal -->
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Modal to add new phonebook starts-->
                    <div class="modal modal-slide-in new-phonebook-modal fade" id="blockNumber">
                        <div class="modal-dialog">
                            <form action="{{ route('blocked.store') }}" method="POST" class="add-new-phonebook modal-content pt-0" enctype="multipart/form-data">
                                @csrf
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                <div class="modal-header mb-1">
                                    <h5 class="modal-title" id="exampleModalLabel">Block a Number</h5>
                                </div>
                                <div class="modal-body flex-grow-1">
                                    <div class="mb-1">
                                        <label class="form-label" for="mobile">{{ __('Phone') }}</label>
                                        <input type="text" name="mobile" id="mobile" class="form-control" oninput="this.value = this.value.replace(/[^0-9.\+]/g, '').replace(/(\..*?)\..*/g, '$1');" placeholder="{{ __('Phone') }}" required />
                                    </div>
                                    <button type="submit" class="btn btn-primary me-1 data-submit">{{ __('Submit') }}</button>
                                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Modal to add new phonebook Ends-->
                </div>
                <!-- list and filter end -->
            </section>
            <!-- blocekd list end -->
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
