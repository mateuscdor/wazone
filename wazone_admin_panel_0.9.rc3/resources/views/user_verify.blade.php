@include('layouts.header_min')

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
                            <h2 class="mb-1">You are almost there! 🔐</h2>
                            <p class="mb-2">Please follow the link that was sent to your whatsapp number!</p>
                            <p class="mb-2">Click Continue below after verification completed!</p>
                            <a class="btn btn-primary mb-1 btn-sm-block" href="{{ route('user.show', ['user_id' => $user->id]) }}">Continue</a><br>
                            <img class="img-fluid" src="{{env('APP_URL')}}/public/app-assets/images/pages/not-authorized.svg" alt="Click continue if already verified" />
                        </div>
                    </div>
                </div>
                <!-- / Not authorized-->
                <!-- Change phone number-->
                <div class="misc-wrapper">
                    <div class="misc-inner p-2 p-sm-3">
                        <div class="w-100 text-center">
                            <h2 class="mb-1">Change phone number!<i data-feather="phone" class="font-medium-4"></i></h2>
                            <p class="mb-2">If you believe you put the wrong phone number when register,</p>
                            <p class="mb-2">Please enter it again below! Make sure you put the country code. Example: 5511912341234</p>
                            <p class="mb-2">If you receive "Waiting for this message......", please reply with "Hi",</p>
                            <p class="mb-2">wait 1 minute, then click "Re-send verification link" again.</p>
                            <form action="{{ route('user.changephone') }}" method="POST">
                            @csrf
                                <div class="form-group">
                                    <input type="hidden" name="user_id" value="{{$user->id}}">
                                    <input type="hidden" name="email_verified_at" value="{{$user->email_verified_at}}">
                                    <input type="tel" name="phone" class="form-control text-center" value="{{$user->phone}}">
                                    <!-- <i data-feather="phone" class="font-medium-4"></i> -->
                                </div>
                                <br>
                                <button type="submit" onclick="this.disabled=true;this.form.submit();" class="btn btn-primary mb-1 btn-sm-block">Re-send verification link</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- / Change phone number-->
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