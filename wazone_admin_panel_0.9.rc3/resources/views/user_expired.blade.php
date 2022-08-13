@include('layouts.header')

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- Not authorized-->
                <div class="misc-wrapper">
                    <div class="misc-inner p-2 p-sm-3">
                        <div class="w-100 text-center">
                            <h2 class="mb-1">You are not authorized! 🔐</h2>
                            <p class="mb-2">Oops your plan seems to be expired. Kindly renew or upgrade to continue using our platform</p>
                            <a class="btn btn-primary mb-1 btn-sm-block" href="{{ route('user.show', ['user_id' => $user->id]) }}">Continue</a><br>
                            <img class="img-fluid" src="app-assets/images/pages/not-authorized.svg" alt="Not authorized page" />
                        </div>
                    </div>
                </div>
                <!-- / Not authorized-->
            </div>
        </div>
    </div>



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
<script src="app-assets/js/scripts/pages/app-user-view.js"></script>
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