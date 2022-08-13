@include('layouts.header')

<!-- BEGIN: Content-->
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <h4>{{ __('Devices list') }}</h4>
        </div>
        <div class="content-body">
            <!-- devices list start -->
            <section class="app-device-list">
                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <h3 class="fw-bolder mb-75">{{ $totalDevices }}</h3>
                                    <span>{{ __('Total devices') }}</span>
                                </div>
                                <div class="avatar bg-light-primary p-50">
                                    <span class="avatar-content">
                                        <i data-feather="user" class="font-medium-4"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <h3 class="fw-bolder mb-75">{{ $user->current_sent }}</h3>
                                    <span>{{ __('Total sent this month') }}</span>
                                </div>
                                <div class="avatar bg-light-danger p-50">
                                    <span class="avatar-content">
                                        <i data-feather="user-plus" class="font-medium-4"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <h3 class="fw-bolder mb-75">{{ $totalPhonebooks }}</h3>
                                    <span>{{ __('Phonebooks') }}</span>
                                </div>
                                <div class="avatar bg-light-success p-50">
                                    <span class="avatar-content">
                                        <i data-feather="user-check" class="font-medium-4"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <h3 class="fw-bolder mb-75">{{ $totalTemplates }}</h3>
                                    <span>{{ __('Message templates') }}</span>
                                </div>
                                <div class="avatar bg-light-warning p-50">
                                    <span class="avatar-content">
                                        <i data-feather="user-x" class="font-medium-4"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- list and filter start -->
                <div class="card">
                    <div class="card-body border-bottom">
                        <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addNewDevice">{{ __('Add new device') }}</button>
                        <form action="{{ route('device.search') }}" method="GET">
                        @csrf
                            <div class="form-group form-group-feedback form-group-feedback-right search-box">
                                <input type="text" name="filter" class="form-control-sm search-input" placeholder="{{ __('Name, Phone') }}">
                                <i data-feather="search" class="font-medium-4"></i>
                            </div>
                            <button type="submit" class="hidden">Search</button>
                        </form>
                    </div>
                    <div class="table-responsive pt-0">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ __('Device name') }}</th>
                                    <th>{{ __('Sender phone') }}</th>
                                    <th>{{ __('Api token') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Webhook') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($devices as $device)
                                <tr>
                                    <td><a href="{{ route('device.show', ['device_id' => $device->id]) }}" target="_blank">
                                    {{ $device->name }}</a>
                                    </td>
                                    <td><a class="btn btn-default" data-toggle="tooltip" title="{{__('View device connection')}}" href="{{ route('device.show', ['device_id' => $device->id]) }}" target="_blank">
                                    {{ $device->sender }}</a>
                                    </td>
                                    <td><button class="btn btn-sm btn-default" data-toggle="tooltip" title="{{__('Click to copy')}}" data-clipboard-text="{{ $device->token }}">
                                    {{ $device->token }}</button>
                                    </td>
                                    <td><a href="{{ route('device.show', ['device_id' => $device->id]) }}" target="_blank">
                                        <span class="badge rounded-pill badge-light-primary me-1">{{ $device->status }}</span></a>
                                    </td>
                                    <td>
                                    <?php
                                        if (!file_exists(public_path("users/{$device->user_id}/webhook/wh_{$device->sender}"))) {
                                            \File::ensureDirectoryExists(public_path("users/{$device->user_id}/webhook"), 0755, true);
                                            if (file_exists(public_path("users/{$device->user_id}/webhook/wh_{$device->sender}.php"))) {
                                                \File::copy(public_path("users/{$device->user_id}/webhook/wh_{$device->sender}.php"), public_path("users/{$device->user_id}/webhook/wh_{$device->sender}"));
                                                \File::copy(public_path("users/{$device->user_id}/webhook/wh_{$device->sender}.php"), public_path("users/{$device->user_id}/webhook/wh_{$device->sender}_" . \Config::get('app.enc_key') . ".php"));
                                                \File::delete(public_path("users/{$device->user_id}/webhook/wh_{$device->sender}.php"));
                                                \DB::table('devices')->where('id', '=', $device->id)->update(['webhook' => url("/users/{$device->user_id}/webhook/wh_{$device->sender}_" . \Config::get('app.enc_key') . ".php")]);
                                            } else {
                                                \File::copy(base_path("webhook.php"), public_path("users/{$device->user_id}/webhook/wh_{$device->sender}"));
                                                \File::copy(base_path("webhook.php"), public_path("users/{$device->user_id}/webhook/wh_{$device->sender}_" . \Config::get('app.enc_key') . ".php"));
                                                \DB::table('devices')->where('id', '=', $device->id)->update(['webhook' => url("/users/{$device->user_id}/webhook/wh_{$device->sender}_" . \Config::get('app.enc_key') . ".php")]);
                                            }
                                        }
                                    ?>
                                        <a class="btn btn-sm btn-success" data-toggle="tooltip" title="{{__('View webhook contents')}}" href="{{ route('device.webhook', ['device_id' => $device->id]) }}"><i data-feather="eye" class="me-0"></i></i></a>
                                        <button type="button" class="btn btn-sm btn-warning" data-toggle="tooltip" title="{{__('Edit webhook url')}}" data-bs-toggle="modal" data-bs-target="#editwebhook{{$device->id}}">
                                            <i data-feather="edit" class="me-0"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#destroy{{$device->id}}">
                                            <i data-feather="trash" class="me-0"></i>
                                        </button>
                                    </td>
                                </tr>
                                <!-- Delete Modal -->
                                <div class="modal fade modal-danger text-start" id="destroy{{$device->id}}" tabindex="-1" aria-labelledby="myModalLabel120" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="myModalLabel120">{{ __('Delete confirmation') }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                {{ __('Are you sure you want to delete?') }} <br><br>
                                                <span class="text text-danger"> <b>{{ $device->name }}</b> </span><br><br>
                                                {{ __('This process is irreversible.') }} <br>
                                                {{ __('The record(s) will be deleted from the database permanently.') }}
                                            </div>
                                            <div class="modal-footer">
                                                <a class="btn btn-sm btn-danger" href="{{ route('device.destroy', ['device_id' => $device->id]) }}">{{ __('Delete') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Edit webhook Modal -->
                                <div class="modal fade" id="editwebhook{{$device->id}}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-webhook">
                                        <div class="modal-content">
                                            <div class="modal-header bg-transparent">
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body pb-5 px-sm-5 pt-50">
                                                <div class="text-center mb-2">
                                                    <h1 class="mb-1">{{ __('Edit') }}  {{ __('Webhook url') }}</h1>
                                                </div>
                                                <form action="{{ route('device.webhookedit') }}" method="POST" id="editWebhookForm" class="row gy-1 pt-75">
                                                    @csrf
                                                    <div class="col-12">
                                                        <input type="hidden"  name="device_id" value="{{ $device->id }}" />
                                                        <label class="form-label" for="sender">{{ __('Sender') }}</label>
                                                        <input type="text" name="sender" class="form-control" value="{{ $device->sender }}" readonly />
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="form-label" for="name">{{ __('Webhook url') }}</label>
                                                        <input type="text" name="webhook" class="form-control" value="{{ ($device->webhook === url('/users/' . $device->user_id . '/webhook/wh_' . $device->sender . '_' . \Config::get('app.enc_key') . '.php')) ? '' : $device->webhook }}" placeholder="{{ __('EMPTY = DEFAULT URL') }}" />
                                                    </div>
                                                    <div class="col-12 text-center mt-2 pt-50">
                                                        <button type="submit" class="btn btn-primary me-1">{{ __('Submit') }}</button>
                                                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                                            {{ __('Cancel') }}
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--/ Edit webhook Modal -->
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Modal to add new device starts-->
                    <div class="modal modal-slide-in new-device-modal fade" id="addNewDevice">
                        <div class="modal-dialog">
                            <form action="{{ route('device.store') }}" method="POST" class="add-new-device modal-content pt-0">
                            @csrf
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                <div class="modal-header mb-1">
                                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Add new device') }}</h5>
                                </div>
                                <div class="modal-body flex-grow-1">
                                    <div class="mb-1">
                                        <label class="form-label" for="name">{{ __('Device name') }}</label>
                                        <input type="text" name="name" class="form-control" placeholder="My Samsung Phone" required />
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label" for="sender">{{ __('Sender phone') }}</label>
                                        <input type="text" name="sender" class="form-control" placeholder="6281282821929" required />
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label" for="webhook">{{ __('Webhook url') }}</label>
                                        <input type="text" name="webhook" class="form-control" placeholder="{{ __('EMPTY = DEFAULT URL') }}" />
                                    </div>
                                    <button type="submit" class="btn btn-primary me-1 data-submit">{{ __('Submit') }}</button>
                                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Modal to add new device Ends-->
                </div>
                <!-- list and filter end -->
            </section>
            <!-- devices list ends -->
            <div class="row">
                <div class="col-md-12">
                    {{ $devices->links() }}
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
<script src="app-assets/vendors/js/jquery/jquery.min.js"></script>
<script src="app-assets/vendors/js/clipboard/clipboard.min.js"></script>
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

<script>
    var btns = document.querySelectorAll('button')
    var clipboard = new ClipboardJS(btns)
</script>

<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

@include('layouts.footer')
