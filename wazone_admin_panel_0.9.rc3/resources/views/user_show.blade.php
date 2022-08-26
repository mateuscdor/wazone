@include('layouts.header')

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section class="app-user-view-security">
                    <div class="row">
                        <!-- User Sidebar -->
                        <div class="col-xl-8 col-lg-7 col-md-7 order-1 order-md-0">
                            <!-- User Card -->
                            <div class="card border-primary">
                            <div class="row">
                                <div class="card-body col-xl-3 col-lg-4 col-md-4">
                                    <div class="user-avatar-section">
                                        <div class="d-flex align-items-center flex-column">
                                            <img class="img-fluid rounded mt-3 mb-2" src="{{ 'users/' . $user->id . '/avatar.png' }}" height="110" width="110" alt="User avatar" />
                                            <div class="user-info text-center">
                                                <h4>{{ $user->name }}</h4>
                                                <span class="badge bg-light-secondary">{{ $upackage->name }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-around my-2 pt-75">
                                        <div class="d-flex align-items-start me-2">
                                            <span class="badge bg-light-primary p-75 rounded">
                                                <i data-feather="check" class="font-medium-2"></i>
                                            </span>
                                            <div class="ms-75">
                                                <h4 class="mb-0">{{ $user->current_sent }}</h4>
                                                <small>{{ __('Current sent') }}</small>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-start">
                                            <span class="badge bg-light-primary p-75 rounded">
                                                <i data-feather="briefcase" class="font-medium-2"></i>
                                            </span>
                                            <div class="ms-75">
                                                <h4 class="mb-0">{{ $user->total_sent }}</h4>
                                                <small>{{ __('Total sent') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body col-xl-3 col-lg-4 col-md-4">
                                    <h4 class="fw-bolder border-bottom pb-50 mb-1">{{ __('Details') }}</h4>
                                    <div class="info-container">
                                        <ul class="list-unstyled">
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">{{ __('Username') }}:</span>
                                                <span>{{ $user->name }}</span>
                                            </li>
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">{{ __('Email') }}:</span>
                                                <span>{{ $user->email }}</span>
                                            </li>
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">{{ __('Phone') }}:</span>
                                                <span>{{ $user->phone }}</span>
                                            </li>
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">{{ __('Status') }}:</span>
                                                <span class="badge bg-light-{{ ($status == 'ACTIVE') ? 'success' : 'danger' }}">{{ $status }}</span>
                                            </li>
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">{{ __('Role') }}:</span>
                                                <span>{{ $user->role }}</span>
                                            </li>
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">{{ __('Language') }}:</span>
                                                <span>{{ $user->lang }}</span>
                                            </li>
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">{{ __('Panel theme') }}:</span>
                                                <span>{{ $user->theme }}</span>
                                            </li>
{{--                                            @if (\Helper::isEx())--}}
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">{{ __('Package') }}:</span>
                                                <span>{{ $upackage->description }}</span>
                                            </li>
{{--                                            <li class="mb-75">--}}
{{--                                                <span class="fw-bolder me-25">{{ __('Wallet') }}:</span>--}}
{{--                                                @if ($walletBalance < 0)--}}
{{--                                                <span class="badge rounded-pill badge-light-danger me-1">--}}
{{--                                                @else--}}
{{--                                                <span class="badge rounded-pill badge-light-success me-1">--}}
{{--                                                @endif--}}
{{--                                                {{$walletBalance}}--}}
{{--                                                </span>--}}
{{--                                            </li>--}}
                                            <li class="mb-75">
                                                @if(auth()->user()->id == $user->id)
{{--                                                <a class="btn-sm btn-primary" href="{{ route('helper.transaction') }}">{{ __('Transactions') }}</a>--}}
                                                @if($user->role === 'admin')
                                                <a class="btn btn-sm btn-warning me-1" data-bs-target="#transferUser" data-bs-toggle="modal" href="javascript:;">{{ __('Transfer') }}</a>
                                                @else
{{--                                                <a class="btn btn-sm btn-success me-1" data-bs-target="#topupUser" data-bs-toggle="modal" href="javascript:;">{{ __('Top up') }}</a>--}}
                                                @endif
                                                @endif
                                            </li>
{{--                                            @endif--}}
                                        </ul>
                                        <div class="d-flex justify-content-center pt-2">
                                            <a href="javascript:;" class="btn btn-primary me-1" data-bs-target="#editUser" data-bs-toggle="modal">{{ __('Edit') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <!-- /User Card -->
                        </div>
                        <!--/ User Sidebar -->

                        <!-- User Content -->
{{--                        @if (\Helper::isEx())--}}
                        @if ($upackage->name !== 'super' && $user->role !== 'admin')
                        <div class="col-xl-4 col-lg-5 col-md-5 order-0 order-md-1">
                            <!-- Plan Card -->
                            <div class="card border-primary">
                                <div class="card-body">
                                    <span class="badge bg-light-primary">{{ $upackage->name }}</span>
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="d-flex justify-content-center">
                                            <sup class="h5 pricing-currency text-primary mt-1 mb-0">{{ $currencyCode }}</sup>
                                            <span class="fw-bolder display-6 mb-0 text-primary">{{ $upackage->rate_monthly }}</span>
                                            <sub class="pricing-duration font-small-4 ms-25 mt-auto mb-2">/{{ __('Month') }}</sub>
                                        </div>
                                    </div>
                                    <!-- <div class="d-flex justify-content-between align-items-start">
                                        <div class="d-flex justify-content-center">
                                            <sup class="h5 pricing-currency text-primary mt-1 mb-0">{{ $currencyCode }}</sup>
                                            <span class="fw-bolder display-6 mb-0 text-primary">{{ $upackage->rate_yearly }}</span>
                                            <sub class="pricing-duration font-small-4 ms-25 mt-auto mb-2">/{{ __('Year') }}</sub>
                                        </div>
                                    </div> -->
                                    <ul class="ps-1 mb-2">
                                        <li class="mb-50">{{ __('Outbox') }}: {{ $upackage->max_outbox }}</li>
                                        <li class="mb-50">{{ __('Device') }}: {{ $upackage->max_device }}</li>
                                        <li class="mb-50">{{ __('Template') }}: {{ $upackage->max_template }}</li>
                                        <li class="mb-50">{{ __('Phonebook') }}: {{ $upackage->max_phonebook }}</li>
                                        <li>{{ __('Basic support') }}</li>
                                    </ul>
                                    @if ($daysRemaining <=3 && $walletBalance < $upackage->rate_monthly)
                                    <p class="text-danger"><strong>{{ __('Please top up wallet!') }}</strong></p>
                                    @endif
                                    @if (round($daysUsed, 2) >= round($daysTotal, 2) || round($daysUsed, 2) < 0)
                                    <div class="d-flex justify-content-between align-items-center fw-bolder mb-50">
                                        <span>{{ __('Days') }}</span>
                                        <span>{{ round($daysTotal, 2) . ' of ' . round($daysTotal, 2) . ' ' . __('Days') }}</span>
                                    </div>
                                    @else
                                    <div class="d-flex justify-content-between align-items-center fw-bolder mb-50">
                                        <span>{{ __('Days') }}</span>
                                        <span>{{ round($daysUsed, 2) . ' of ' . round($daysTotal, 2) . ' ' . __('Days') }}</span>
                                    </div>
                                    @endif
                                    @if ($percentUsed < 0 || $percentUsed > 100)
                                    <div class="progress mb-50" style="height: 16px">
                                        <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="65" aria-valuemax="100" aria-valuemin="80">100%</div>
                                    </div>
                                    @else
                                    <div class="progress mb-50" style="height: 16px">
                                        <div class="progress-bar" role="progressbar" style="width: {{ $percentUsed }}%" aria-valuenow="65" aria-valuemax="100" aria-valuemin="80">{{ $percentUsed }}%</div>
                                    </div>
                                    @endif
                                    @if (round($daysRemaining, 2) < 0)
                                    <span>{{ '0 ' . __('days remaining') }}</span>
                                    @else
                                    <span>{{ round($daysRemaining, 2) . ' ' . __('days remaining') }}</span>
                                    @endif
                                    @if (auth()->user()->role !== 'admin')
                                    <div class="d-grid w-100 mt-2">
                                        <a href="javascript:;" class="btn btn-primary me-1" data-bs-target="#upgradeUser" data-bs-toggle="modal">
                                            {{ __('GET WAZONE') }}
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
{{--                        @endif--}}
                        <!--/ User Content -->
                    </div>
                </section>
                <!-- Edit User Modal -->
                <div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                        <div class="modal-content">
                            <div class="modal-header bg-transparent">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body pb-5 px-sm-5 pt-50">
                                <div class="text-center mb-2">
                                    <h1 class="mb-1">{{ __('Edit user form') }}</h1>
                                </div>
                                <form action="{{ route('user.update') }}" method="POST" id="editUserForm" class="row gy-1 pt-75">
                                    @csrf
                                    <div class="col-12 col-md-6">
                                        <input type="hidden"  name="user_id" value="{{ $user->id }}" />
                                        <label class="form-label" for="name">{{ __('Username') }}</label>
                                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" {{ ($user->name === 'admin' || $user->name === 'bank') ? 'readonly' : '' }} required />
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-label" for="password">{{ __('Password minimum 6 characters') }}</label>
                                        <input type="text" name="password" class="form-control" placeholder="{{ __('EMPTY = NO CHANGE') }}" />
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-label" for="email">{{ __('Email') }}</label>
                                        <input type="text" name="email" class="form-control" value="{{ $user->email }}" placeholder="example@domain.com" required />
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-label" for="phone">{{ __('Phone') }}</label>
                                        <input type="text" name="phone" class="form-control" value="{{ $user->phone }}" placeholder="6281212341234" required />
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-label" for="theme">{{ __('Panel theme') }}</label>
                                        <select id="theme" name="theme" class="form-select">
                                            <option value="light-layout" {{ ( $user->theme == 'light-layout' ) ? 'selected' : '' }}>Light theme</option>
                                            <option value="dark-layout" {{ ( $user->theme == 'dark-layout' ) ? 'selected' : '' }}>Dark theme</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-label" for="role" {{ ( auth()->user()->role !== 'admin' || $user->name === 'admin' || $user->name === 'bank') ? 'hidden' : '' }}>{{ __('User role') }}</label>
                                        <select id="role" name="role" class="form-select" {{ ( auth()->user()->role !== 'admin' || $user->name === 'admin' || $user->name === 'bank') ? 'hidden' : '' }}>
                                            <option value="admin" {{ ( $user->role === 'admin' ) ? 'selected' : '' }}>Admin</option>
                                            <option value="user" {{ ( $user->role === 'user' ) ? 'selected' : '' }}>User</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6" id="package">
                                        <label class="form-label" for="package_name" {{ ( auth()->user()->role !== 'admin' || $user->name === 'admin' || $user->name === 'bank' || !(\Helper::isEx())) ? 'hidden' : '' }}>{{ __('Package name') }}</label>
                                        <select name="package_id" class="form-select" {{ ( auth()->user()->role !== 'admin' || $user->name === 'admin' || $user->name === 'bank' || !(\Helper::isEx())) ? 'hidden' : '' }}>
                                            @foreach($packages as $package)
                                            <option value="{{ $package->id }}" {{ ( $package->id === $upackage->id ) ? 'selected' : '' }}>{{ $package->name . '-' . $package->rate_monthly . '/' . __('Month') }}</option>
                                            @endforeach
                                        </select>
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

                <!-- Transfer Modal -->
                <div class="modal fade" id="transferUser" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                        <div class="modal-content">
                            <div class="modal-header bg-transparent">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body pb-5 px-sm-5 pt-50">
                                <div class="text-center mb-2">
                                    <h1 class="mb-1">{{ __('Transfer form') }}</h1>
                                </div>
                                <form action="{{ route('helper.transfer') }}" method="POST" id="transferUserForm" class="row gy-1 pt-75">
                                    @csrf
                                    <div class="col-12 col-md-6">
                                        <input type="hidden"  name="user_id" value="{{ $user->id }}" />
                                        <label class="form-label" for="from_name">{{ __('From') }}</label>
                                        <input type="text" name="from_name" class="form-control" value="{{ $user->name }}" placeholder="{{ __('Username') }}" required readonly />
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-label" for="to_name">{{ __('To') }}</label>
                                        <input type="text" name="to_name" class="form-control" {{ ($user->name === 'bank') ? 'value=admin readonly' : '' }} required />
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-label" for="amount">{{ __('Amount') }}</label>
                                        <input type="number" name="amount" class="form-control" placeholder="{{ __('Enter Integer value. No decimal!') }}" required />
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-label" for="memo">{{ __('Memo') }} ({{ __('Optional') }})</label>
                                        <input type="text" name="memo" class="form-control" placeholder="Enter a memo for this transfer" />
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

                <!-- Top up Modal -->
                <div class="modal fade" id="topupUser" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-md modal-dialog-centered modal-topup-user">
                        <div class="modal-content">
                            <div class="modal-header bg-transparent">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body pb-5 px-sm-5 pt-50">
                                <div class="text-center mb-2">
                                    <h1 class="mb-1">{{ __('Top up form') }}</h1>
                                </div>
                                <section class="app-user-view-security">
                                    <div class="card-body">
                                        <div class="card border-primary">
                                            <div class="card-body">
                                                <span class="badge bg-light-primary">{{ __('Top up value') }}</span>
                                            </div>
                                            <form action="" method="POST">
                                            @csrf
                                                <input type="hidden" name="data" value="{{ $user }}" />
                                                <input type="hidden" name="user_id" value="{{ $user->id }}" />
                                                <input type="hidden" name="user_name" value="{{ $user->name }}" />
                                                <input type="hidden" name="currencyCode" value="{{ $currencyCode }}" />
                                                <div class="card-body">
                                                    <div class="mb-1">
                                                        <label class="form-label" for="topupValue">{{ __('Top up value') }}</label>
                                                        <div class="position-relative">
                                                            @if (\Helper::setting('topupValues'))
                                                            <select name="topupValue" class="form-select">
                                                                @foreach($topupValues as $topupValue)
                                                                <option value="{{ $topupValue }}">{{ $currencyCode }} {{ $topupValue }}</option>
                                                                @endforeach
                                                            </select>
                                                            @else
                                                            <input type="number" name="topupValue" class="form-control" min="5" placeholder="Minimum $5 {{ __('Enter Integer value. No decimal!') }}" />
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="mb-1">
                                                        <button class="btn btn-primary btn-page-block-custom waves-effect" type="submit">
                                                            {{ __('Top up') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- upgrade your plan Modal -->
                <div class="modal fade" id="upgradeUser" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-upgrade-user">
                        <div class="modal-content">
                            <div class="modal-header bg-transparent">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body pb-5 px-sm-5 pt-50">
                                <div class="text-center mb-2">
                                    <h1 class="mb-1">{{ __('Upgrade form') }}</h1>
                                </div>
                                <section class="app-user-view-security">
                                    <div class="card-body">
                                        <div class="card border-primary">
                                            <div class="card-body">
                                                <div class="row">
                                                @foreach($packages as $package)
                                                @if ($package->name == 'super' || $package->name == 'trial' || $package->id == $upackage->id) @continue @endif
                                                <div class="col-4">
                                                    <span class="badge bg-light-primary"><strong>{{$package->name}}</strong></span>
                                                    <ul class="ps-1 mb-2">
                                                        <li class="mb-50">{{ __('Outbox') }}: {{ $package->max_outbox }}</li>
                                                        <li class="mb-50">{{ __('Device') }}: {{ $package->max_device }}</li>
                                                        <li class="mb-50">{{ __('Template') }}: {{ $package->max_template }}</li>
                                                        <li class="mb-50">{{ __('Phonebook') }}: {{ $package->max_phonebook }}</li>
                                                        <li class="mb-50">{{ __('Monthly') }}: {{ $package->rate_monthly }}</li>
                                                        <!-- <li class="mb-50">{{ __('Yearly') }}: {{ $currencyCode }} {{ $package->rate_yearly }}</li> -->
                                                    </ul>
                                                </div>
                                                @endforeach
                                                </div>
                                            </div>
                                            <form action="{{ route('payLink') }}" method="POST">
                                            @csrf
                                                <input type="hidden" name="data" value="{{ $user }}" />
{{--                                                <input type="hidden" name="user_id" value="{{ $user->id }}" />--}}
{{--                                                <input type="hidden" name="user_name" value="{{ $user->name }}" />--}}
{{--                                                <input type="hidden" name="currencyCode" value="{{ $currencyCode }}" />--}}
{{--                                                <input type="hidden" name="walletBalance" value="{{ $walletBalance }}" />--}}
                                                <div class="card-body">
                                                    <div class="mb-1">
                                                        <label class="form-label" for="choosePackage">{{ __('Choose package') }}</label>
                                                        <div class="position-relative">
                                                            <select name="package_id" class="form-select">
                                                                @foreach($packages as $package)
                                                                @if ($package->name == 'super' || $package->name == 'trial') @continue @endif
                                                                <option value="{{ $package->id }}">{{ $package->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="mb-1">
                                                        <label class="form-label" for="chooseInterval">{{ __('Choose interval') }}</label>
                                                        <div class="position-relative">
                                                            <select name="billing_interval" class="form-select">>
                                                                @foreach($intervals as $interval)
                                                                <option value="{{ $interval }}">{{ $interval }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
{{--                                                    <div class="mb-1">--}}
{{--                                                        <label class="form-label" for="balance">{{ __('Wallet balance') }}: </label>--}}
{{--                                                        @if ($walletBalance < 0)--}}
{{--                                                        <span class="badge rounded-pill badge-light-danger me-1">--}}
{{--                                                        @else--}}
{{--                                                        <span class="badge rounded-pill badge-light-success me-1">--}}
{{--                                                        @endif--}}
{{--                                                        {{$walletBalance}}--}}
{{--                                                        </span>--}}
{{--                                                    </div>--}}
                                                    <div class="mb-1">
                                                        <span class="badge bg-light-warning"><strong>{{ __('Upgrade will be charged at a pro-rated amount from today until month') }}</strong></span>
{{--                                                        <span class="badge bg-light-warning"><strong>{{ __('Downgrade will be free. New rate will affect at the beginning of next month') }}</strong></span>--}}
                                                        <button class="btn btn-primary btn-page-block-custom waves-effect" type="submit">
                                                            {{ __('GET WAZONE') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
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
    <!-- <script src="app-assets/js/scripts/pages/app-user-view.js"></script> -->
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
    $(document).ready(function(){
        if ($('#role').val() == 'admin') $("#package").hide();
        $('#role').on('change', function() {
            $("#package").toggle(this.value !== 'admin');
        });
    });
    </script>

@include('layouts.footer')
