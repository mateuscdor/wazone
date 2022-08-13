@include('layouts.header_min')

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- Coming soon page-->
                <div class="misc-wrapper">
                    <a class="brand-logo" href="#">
                    <img src="{{ \Helper::setting('logoUrl') }}" alt="wazone-logo"   height="36">
                        <h2 class="brand-text text-primary ms-1">{{env('APP_NAME')}}</h2>
                    </a>
                    <div class="misc-inner p-2 p-sm-3">
                        <div class="w-100 text-center">
                            <h2 class="mb-1">We are launching soon 🚀</h2>
                            <p class="mb-3">We're creating something awesome. Please register and test it out yourself!</p>
                            <img class="img-fluid" src="app-assets/images/pages/coming-soon.svg" alt="Coming soon page" />
                        </div>
                    </div>
                </div>
                <!-- / Coming soon page-->
                <!-- START DELETE THIS PART -->
                <div class="misc-wrapper">
                    <div class="misc-inner p-2 p-sm-3">
                        <div class="w-100 text-center">
                            <h2 class="mb-1">v0.9.release canditate 🤖</h2>
                            <span class="mb-2 pb-75">=> login as admin: admin</span><br>
                        <span class="mb-2 pb-75">=> pass as admin : password</span><br>
                        <span class="mb-2 pb-75">=> login as bank: bank</span><br>
                        <span class="mb-2 pb-75">=> pass as bank : password</span><br>
                        <span class="mb-2 pb-75">=> login as user: demo</span><br>
                        <span class="mb-2 pb-75">=> pass as user : password</span><br><br>
                        <span class="mb-2 pb-75 text-warning">***************************************************************************************</span><br><br>
                        <span class="mb-2 pb-75 text-warning">This welcome page location: /resources/views/welcome.blade.php</span><br><br>
                        <span class="mb-2 pb-75 text-warning">By default I already pass the "Packages" to this page, to pull the data out is very simple!</span><br><br>
                        <span class="mb-2 pb-75 text-warning">***************************************************************************************</span><br><br>
                        <div class="card">
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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($packages as $package)
                                        @if ($package->name == 'super' || $package->name == 'trial') @continue @endif
                                        <tr>
                                            <td>
                                            <span class="badge rounded-pill badge-light-primary me-1">{{ $package->name }}</span>
                                            </td>
                                            <td>
                                            {{ $package->description }}
                                            </td>
                                            <td>
                                            {{ $package->rate_monthly }}
                                            </td>
                                            <td>
                                            {{ $package->max_outbox }}
                                            </td>
                                            <td>
                                            {{ $package->max_device }}
                                            </td>
                                            <td>
                                            {{ $package->max_template }}
                                            </td>
                                            <td>
                                            {{ $package->max_phonebook }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <span class="mb-2 pb-75 text-warning">***************************************************************************************</span><br><br>
                        <span class="mb-2 pb-75 text-warning">to enable Whatsapp notification for registration and password reset</span><br><br>
                        <span class="mb-2 pb-75 text-warning"><a href="https://visimisi.net/docs/wazone-whatsapp-verification-and-reset-password/">https://visimisi.net/docs/wazone-whatsapp-verification-and-reset-password/</a></span><br><br>
                        <span class="mb-2 pb-75 text-warning">***************************************************************************************</span><br><br>
                        <span class="mb-2 pb-75">=> Menu Device: add sender phone number</span><br>
                        <span class="mb-2 pb-75">click your number in the list and scan with Whatsapp Multi-Device app from your phone</span><br>
                        <span class="mb-2 pb-75">you can use other phone to test for autoreply</span><br>
                        <span class="mb-2 pb-75">keywords: "test"</span><br><br>
                        <span class="mb-2 pb-75">=> Menu Send message: Please choose your phone number in the sender dropdown menu</span><br>
                        <span class="mb-2 pb-75">input the receiver phone number, you can input it in single or multi receiver or both of them (you must add phonebook to send multi receiver)</span><br>
                        <span class="mb-2 pb-75">pick a media file from your local pc (if you want to send media message)</span><br>
                        <span class="mb-2 pb-75">input your text message or you can choose template from droopdown menu (you must add template from Template menu)</span><br><br>
                        <span class="mb-2 pb-75">=> Menu Outbox: this is where all your outgoing messages history will be with it status SENT/FAILED</span><br>
                        <span class="mb-2 pb-75">you can click on each job to get detail messages report</span><br><br>
                        <span class="mb-2 pb-75">=> ATTENTION!!!! This is beta version, you might find error pages here and there because I turn on the developer mode ON</span><br>
                        <span class="mb-2 pb-75">and if you are kind enough and want to spend a minute or two to capture the error pages and email it to me to fixcomputerforless@gmail.com, I will appreciate it!</span><br><br>
                        <span class="mb-2 pb-75">=> I am so sorry, but I don't accept any feature request right now.</span><br>
                        <span class="mb-2 pb-75">=> If you request it now, I might get tempted and it will delay the release even more!</span><br>
                        <span class="mb-2 pb-75">=> I will try to build a forum or discussion board for this wazone gateway, so all of you guys can contribute.</span><br>
                        <span class="mb-2 pb-75">=> I love getting interesting ideas and add it in future update, but PLEASE.. PLEASE.. not now!</span><br>
                        </div>
                    </div>
                </div>
                <!-- / END DELETE THIS PART -->
            </div>
        </div>
    </div>
    <!-- END: Content-->


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
