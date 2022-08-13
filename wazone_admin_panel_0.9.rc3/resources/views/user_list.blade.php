@include('layouts.header')

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <h4>{{ __('Users list') }}</h4>
            </div>
            <div class="content-body">
                <!-- users list start -->
                <section class="app-user-list">
                    <div class="row">
                        <div class="col-lg-3 col-sm-6">
                            <div class="card">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <h3 class="fw-bolder mb-75">{{ $totalUsers }}</h3>
                                        <span>{{ __('Total users') }}</span>
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
                                        <h3 class="fw-bolder mb-75">{{ $currentSent }}</h3>
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
                            <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addNewUser">{{ __('Add new user') }}</button>
                            <form action="{{ route('user.search') }}" method="GET">
                            @csrf
                                <div class="form-group form-group-feedback form-group-feedback-right search-box">
                                    <input type="text" name="filter" class="form-control-sm search-input" placeholder="Search username / role">
                                    <i data-feather="search" class="font-medium-4"></i>
                                </div>
                                <button type="submit" class="hidden">Search</button>
                            </form>
                        </div>
                        <div class="table-responsive pt-0">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>{{ __('Username') }}</th>
                                        <th>{{ __('Role') }}</th>
                                        <th>{{ __('Current sent') }}</th>
                                        <th>{{ __('Total sent') }}</th>
                                        @if (\Helper::isEx())
                                        <th>{{ __('Package name') }}</th>
                                        <th>{{ __('Wallet') }}
                                        <th>{{ __('Expiry date') }}</th>
                                        @endif
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td><a href="{{ route('user.show', ['user_id' => $user->id]) }}">
                                        {{ $user->name }}</a>
                                        </td>
                                        <td><a href="{{ route('user.show', ['user_id' => $user->id]) }}">
                                        <span class="badge rounded-pill badge-light-warning me-1">{{ $user->role }}</span></a>
                                        </td>
                                        <td><a href="{{ route('user.show', ['user_id' => $user->id]) }}">
                                        {{ $user->current_sent }}</a>
                                        </td>
                                        <td><a href="{{ route('user.show', ['user_id' => $user->id]) }}">
                                        {{ $user->total_sent }}</a>
                                        </td>
                                        @if (\Helper::isEx())
                                        <td><a href="{{ route('user.show', ['user_id' => $user->id]) }}">
                                        <span class="badge rounded-pill badge-light-primary me-1">{{ $user->package->name }}</span></a>
                                        </td>
                                        <td><a href="{{ route('user.show', ['user_id' => $user->id]) }}">
                                        @php $walletBalance = $user->transactions()->sum('amount') @endphp
                                        <span class="badge rounded-pill {{$walletBalance < 0 ? 'badge-light-danger' : 'badge-light-success'}} me-1">{{ $walletBalance }}</span></a>
                                        </td>
                                        <td><a href="{{ route('user.show', ['user_id' => $user->id]) }}">
                                        <span class="badge rounded-pill {{$user->billing_end < date('Y-m-d H:i:s') ? 'badge-light-danger' : 'badge-light-success'}} me-1">{{ $user->billing_end }}</span></a>
                                        </td>
                                        @endif
                                        <td>
                                            @canBeImpersonated($user, $guard = null)
                                            <a class="btn btn-warning" href="{{ route('user.impersonate', $user->id) }}" {{ (auth()->user()->name !== 'admin' &&  ($user->name === 'admin' || $user->name === 'bank')) ? 'hidden' : '' }}>{{ __('Login') }}</a>
                                            @endCanBeImpersonated
                                            @if ($user->name !== auth()->user()->name && $user->name !== 'admin' && $user->name !== 'bank')
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#destroy{{$user->id}}">
                                                <i data-feather="trash" class="me-0"></i>
                                            </button>
                                            @endif
                                        </td>
                                    </tr>
                                    <!-- Delete Modal -->
                                    <div class="modal fade modal-danger text-start" id="destroy{{$user->id}}" tabindex="-1" aria-labelledby="myModalLabel120" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="myModalLabel120">{{ __('Delete confirmation') }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    {{ __('Are you sure you want to delete?') }} <br><br>
                                                    <span class="text text-danger"> <b>{{ $user->name }}</b> </span><br><br>
                                                    {{ __('This process is irreversible.') }} <br>
                                                    {{ __('The record(s) will be deleted from the database permanently.') }}
                                                </div>
                                                <div class="modal-footer">
                                                <a class="btn btn-sm btn-danger" href="{{ route('user.destroy', ['user_id' => $user->id]) }}">{{ __('Delete') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Modal to add new user starts-->
                        <div class="modal modal-slide-in new-user-modal fade" id="addNewUser">
                            <div class="modal-dialog">
                                <form action="{{ route('user.store') }}" method="POST" class="add-new-user modal-content pt-0">
                                @csrf
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                    <div class="modal-header mb-1">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ __('Add new user') }}</h5>
                                    </div>
                                    <div class="modal-body flex-grow-1">
                                        <div class="mb-1">
                                            <label class="form-label" for="name">{{ __('Username') }}</label>
                                            <input type="text" name="name" class="form-control" placeholder="{{ __('Username') }}" required />
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label" for="password">{{ __('Password') }}</label>
                                            <input type="text" name="password" class="form-control" placeholder="{{ __('Password') }}" required />
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label" for="email">{{ __('Email') }}</label>
                                            <input type="email" name="email" class="form-control" placeholder="{{ __('Email') }}" required />
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label" for="phone">{{ __('Phone') }}</label>
                                            <input type="tel" name="phone" class="form-control" placeholder="14083243658" required />
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label" for="role">{{ __('Role') }}</label>
                                            <select class="form-select" id="role" name="role">
                                                <option value="admin">Admin</option>
                                                <option value="user" selected>User</option>
                                            </select>
                                        </div>
                                        @if (\Helper::isEx())
                                        <div class="mb-1">
                                            <label class="form-label" for="package_id">{{ __('Package') }}</label>
                                            <select class="form-select" id="package_id" name="package_id">
                                                @foreach($packages as $package)
                                                <option value="{{ $package->id }}" {{ ( $package->id === 2 ) ? 'selected' : '' }}>{{ $package->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label" for="billing_interval">{{ __('Interval') }}</label>
                                            <select name="billing_interval" class="form-select">>
                                                @foreach($intervals as $interval)
                                                <option value="{{ $interval }}">{{ $interval }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @else
                                            <input type="hidden"  name="package_id" value="2" />
                                            <input type="hidden"  name="billing_interval" value="monthly" />
                                        @endif
                                        <button type="submit" class="btn btn-primary me-1 data-submit">{{ __('Submit') }}</button>
                                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Modal to add new user Ends-->
                    </div>
                    <!-- list and filter end -->
                </section>
                <!-- users list ends -->
                <div class="row">
                    <div class="col-md-12">
                        {{ $users->links() }}
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
