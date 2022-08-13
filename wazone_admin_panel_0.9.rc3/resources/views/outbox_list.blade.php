@include('layouts.header')

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <h4>{{ __('Outbox list') }}</h4>
            </div>
            <div class="content-body">
                <!-- job list start -->
                <section class="app-job-list">
                    <!-- list and filter start -->
                    <div class="card">
                        <div class="card-body border-bottom">
                            <button type="button" class="btn btn-sm btn-primary float-end" data-bs-toggle="modal" data-bs-target="#destroyall">
                                <i data-feather="trash" class="me-0"></i> {{ __('ALL') }} ({{$allCount}})
                            </button>
                            <!-- Modal destroyall-->
                            <div class="modal fade modal-danger text-start" id="destroyall" tabindex="-1" aria-labelledby="myModalLabel120" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="myModalLabel120">{{ __('Delete confirmation') }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            {{ __('Are you sure you want to delete?') }} <br>
                                            {{ __('This process is irreversible.') }} <br>
                                            {{ __('The record(s) will be deleted from the database permanently.') }}
                                        </div>
                                        <div class="modal-footer">
                                        <a class="btn btn-sm btn-danger" href="{{ route('outbox.destroyall', ['user_id' => auth()->user()->id]) }}">{{ __('Delete') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-sm btn-danger float-end" data-bs-toggle="modal" data-bs-target="#destroystatusFAILED">
                                <i data-feather="trash" class="me-0"></i> {{ __('FAILED') }} ({{$failedCount}})
                            </button>
                            <!-- Modal destroystatusFAILED-->
                            <div class="modal fade modal-danger text-start" id="destroystatusFAILED" tabindex="-1" aria-labelledby="myModalLabel120" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="myModalLabel120">{{ __('Delete confirmation') }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            {{ __('Are you sure you want to delete?') }} <br>
                                            {{ __('This process is irreversible.') }} <br>
                                            {{ __('The record(s) will be deleted from the database permanently.') }}
                                        </div>
                                        <div class="modal-footer">
                                        <a class="btn btn-sm btn-danger" href="{{ route('outbox.destroystatus', ['user_id' => auth()->user()->id, 'status' => 'FAILED']) }}">{{ __('Delete') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="button" class="btn btn-sm btn-success float-end" data-bs-toggle="modal" data-bs-target="#destroystatusSENT">
                                <i data-feather="trash" class="me-0"></i> {{ __('SENT') }} ({{$sentCount}})
                            </button>
                            <!-- Modal destroystatusSENT-->
                            <div class="modal fade modal-danger text-start" id="destroystatusSENT" tabindex="-1" aria-labelledby="myModalLabel120" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="myModalLabel120">{{ __('Delete confirmation') }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            {{ __('Are you sure you want to delete?') }} <br>
                                            {{ __('This process is irreversible.') }} <br>
                                            {{ __('The record(s) will be deleted from the database permanently.') }}
                                        </div>
                                        <div class="modal-footer">
                                        <a class="btn btn-sm btn-danger" href="{{ route('outbox.destroystatus', ['user_id' => auth()->user()->id, 'status' => 'SENT']) }}">{{ __('Delete') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="button" class="btn btn-sm btn-warning float-end" data-bs-toggle="modal" data-bs-target="#destroystatusPENDING">
                                <i data-feather="trash" class="me-0"></i> {{ __('PENDING') }} ({{$pendingCount}})
                            </button>
                            <!-- Modal destroystatusPENDING-->
                            <div class="modal fade modal-danger text-start" id="destroystatusPENDING" tabindex="-1" aria-labelledby="myModalLabel120" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="myModalLabel120">{{ __('Delete confirmation') }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            {{ __('Are you sure you want to delete?') }} <br>
                                            {{ __('This process is irreversible.') }} <br>
                                            {{ __('The record(s) will be deleted from the database permanently.') }}
                                        </div>
                                        <div class="modal-footer">
                                        <a class="btn btn-sm btn-danger" href="{{ route('outbox.destroystatus', ['user_id' => auth()->user()->id, 'status' => 'PENDING']) }}">{{ __('Delete') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="button" class="btn btn-sm btn-info float-end" data-bs-toggle="modal" data-bs-target="#resendfailed">
                                <i data-feather="send" class="me-0"></i> {{ __('RESEND FAILED') }} ({{$failedCount}})
                            </button>
                            <!-- Modal resendfailed-->
                            <div class="modal fade modal-info text-start" id="resendfailed" tabindex="-1" aria-labelledby="myModalLabel120" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="myModalLabel120">{{ __('Resend confirmation') }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            {{ __('Are you sure you want to resend?') }} <br>
                                            {{ __('This will change the FAILED status to PENDING.') }} <br>
                                            {{ __('The outbox will be sent on next crob job schedule.') }}
                                        </div>
                                        <div class="modal-footer">
                                        <a class="btn btn-sm btn-info" href="{{ route('outbox.resendfailed', ['user_id' => auth()->user()->id, 'status' => 'PENDING']) }}">{{ __('Resend') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <form action="{{ route('outbox.search') }}" method="GET">
                            @csrf
                                <div class="form-group form-group-feedback form-group-feedback-right search-box">
                                    <input type="text" name="filter" class="form-control-sm search-input" placeholder="{{ __('Name, Phone, Mesage') }}">
                                    <i data-feather="search" class="font-medium-4"></i>
                                </div>
                                <button type="submit" class="hidden">Search</button>
                            </form>
                        </div>
                        <div class="table-responsive pt-0">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th> {{ __('Job ID') }} </th>
                                        <th> {{ __('Job started') }} </th>
                                        <th> {{ __('Status') }} </th>
                                        <th> {{ __('Actions') }} </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($jobs as $job)
                                    <tr>
                                        <td><a href="{{ route('outbox.show', ['job_id' => $job->job_id]) }}">
                                        {{ $job->job_id }}</a>
                                        </td>
                                        <td><a href="{{ route('outbox.show', ['job_id' => $job->job_id]) }}">
                                        {{ date('Y-m-d H:i:s', $job->job_id) }}</a>
                                        </td>
                                        <td><a href="{{ route('outbox.show', ['job_id' => $job->job_id]) }}">
                                        <span class="badge rounded-pill badge-light-warning me-1">{{ $job->where([['job_id', '=', $job->job_id],['status', '=', 'PENDING']])->count() . ' ' . __('PENDING') }}</span>
                                        <span class="badge rounded-pill badge-light-success me-1">{{ $job->where([['job_id', '=', $job->job_id],['status', '=', 'SENT']])->count() . ' ' . __('SENT') }}</span>
                                        <span class="badge rounded-pill badge-light-danger me-1">{{ $job->where([['job_id', '=', $job->job_id],['status', '=', 'FAILED']])->count() . ' ' . __('FAILED') }}</span>
                                        <span class="badge rounded-pill badge-light-primary me-1">{{ $job->total . ' ' . __('TOTAL') }}</a>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#destroy{{$job->job_id}}">
                                                <i data-feather="trash" class="me-0"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Delete Modal -->
                                    <div class="modal fade modal-danger text-start" id="destroy{{$job->job_id}}" tabindex="-1" aria-labelledby="myModalLabel120" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="myModalLabel120">{{ __('Delete confirmation') }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    {{ __('Are you sure you want to delete?') }} <br><br>
                                                    <span class="text text-danger"> <b>{{ $job->job_id }}</b> </span><br><br>
                                                    {{ __('This process is irreversible.') }} <br>
                                                    {{ __('The record(s) will be deleted from the database permanently.') }}
                                                </div>
                                                <div class="modal-footer">
                                                <a class="btn btn-sm btn-danger" href="{{ route('outbox.destroyjob', ['job_id' => $job->job_id]) }}">{{ __('Delete') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- list and filter end -->
                </section>
                <!-- jobs list ends -->
                <div class="row">
                    <div class="col-md-12">
                        {{ $jobs->links() }}
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