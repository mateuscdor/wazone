@include('layouts.header')

<!-- BEGIN: Content-->
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
        <h4>{{ $device->sender }} -> {{ __('Group contacts') }}</h4>
        </div>
        <div class="content-body">
            <!-- table show start -->
            <section class="app-device-show">
                <div class="card">
                    <div class="card-body border-bottom">
                        <a class="btn btn-primary float-end" href="{{ route('phonebook.storegroups') }}">{{ __('Save groups') }}</a>
                        <!-- <form action="{{ route('device.search') }}" method="GET">
                        @csrf
                            <div class="form-group form-group-feedback form-group-feedback-right search-box">
                                <input type="text" name="filter" class="form-control-sm search-input" placeholder="{{ __('Name, Phone') }}">
                                <i data-feather="search" class="font-medium-4"></i>
                            </div>
                            <button type="submit" class="hidden">Search</button>
                        </form> -->
                    </div>
                    <div class="table-responsive pt-0">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ __('Group ID') }}</th>
                                    <th>{{ __('Group name') }}</th>
                                    <th>{{ __('Group owner') }}</th>
                                    <th>{{ __('Participants') }}</th>
                                    <!-- <th>{{ __('Actions') }}</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($contactGroups as $group)
                                <tr>
                                    <td>
                                    {{ $group->groupId }}
                                    </td>
                                    <td>
                                    {{ $group->subject }}
                                    </td>
                                    <td>
                                    {{ $group->owner }}
                                    </td>
                                    <td><a class="btn btn-success"  href="{{ route('phonebook.storeparticipants', ['id' => $group->id]) }}">
                                    {{ __('Save participants') }}</a>
                                    </td>
                                    <!-- <td>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#destroy{{$device->id}}">
                                            <i data-feather="trash" class="me-0"></i>
                                        </button>
                                    </td> -->
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
            <!-- table show ends -->
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
