@include('layouts.header')

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <h4>
                <p>{{ __('Wallet balance') }}: 
                    @if ($walletBalance < 0)
                    <span class="badge rounded-pill badge-light-danger me-1">
                    @else
                    <span class="badge rounded-pill badge-light-success me-1">
                    @endif
                    {{$walletBalance}}
                    </span>
                </p>
                </h4>
            </div>
            <div class="content-body">
                <section class="app-user-wallet-list">
                    <div class="card border-success">
                        <div class="table-responsive pt-0">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>{{ __('ID') }}</th>
                                        <th>{{ __('Me') }}</th>
                                        <th>{{ __('Other') }}</th>
                                        <th>{{ __('Type') }}</th>
                                        <th>{{ __('Amount') }}</th>
                                        <th>{{ __('Date') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transactions as $transaction)
                                    <tr>
                                        <td>
                                            {{$transaction->id}}
                                        </td>
                                        <td>
                                            {{$transaction->user->name}}
                                        </td>
                                        <td>
                                            {{\App\Models\User::where('id', $transaction->user2_id)->value('name')}}
                                        </td>
                                        <td>
                                            {{$transaction->type}}
                                        </td>
                                        <td>@if ($transaction->amount < 0 )
                                            <span class="badge rounded-pill badge-light-danger me-1">
                                            @else
                                            <span class="badge rounded-pill badge-light-success me-1">
                                            @endif
                                            {{$transaction->amount}}
                                            </span>
                                        </td>
                                        <td>
                                            {{$transaction->updated_at}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
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
