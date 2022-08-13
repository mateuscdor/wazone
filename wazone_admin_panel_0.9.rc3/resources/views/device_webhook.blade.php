@include('layouts.header')

<!-- BEGIN: Content-->
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
        <h4>{{ ($device->webhook === url('/users/' . $device->user_id . '/webhook/wh_' . $device->sender . '_' . \Config::get('app.enc_key') . '.php')) ? $device->sender : '(Custom url) ' . $device->webhook }}</h4>
        </div>
        <div class="content-body">
            <!-- devices show start -->
            <section class="app-device-show">
                <!-- show and filter start -->
                <!-- <div class="card"> -->
                    <div class="row">
                        <div class="col-md-12">
                        <form action="{{ route('device.webhookupdate', ['device_id' => $device->id]) }}" method="POST" class="add-new-device modal-content pt-0">
                        @csrf
                            <div class="card border-primary">
                                <textarea name="content" class="form-control" rows="30" style="background-color: #000;color: #00ff00;border: 1px solid #000;padding: 8px;font-family: courier new; white-space: nowrap;">{{$content}}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary me-1 data-submit" {{ ($device->webhook === url('/users/' . $device->user_id . '/webhook/wh_' . $device->sender . '_' . \Config::get('app.enc_key') . '.php')) ? '' : 'hidden' }}>{{ __('Save') }}</button>
                        </form>
                        </div>
                    </div>
                <!-- </div> -->
                <!-- show and filter end -->
            </section>
            <!-- devices show ends -->
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
