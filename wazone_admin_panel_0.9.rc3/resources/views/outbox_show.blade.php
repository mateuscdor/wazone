@include('layouts.header')

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <h4>{{ __('Send message job#') . ' ' . $job_id }}</h4>
            </div>
            <div class="content-body">
                <!-- job list start -->
                <section class="app-job-list">
                    <!-- list and filter start -->
                    <div class="card">
                        <!-- <div class="card-body border-bottom">
                            <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addNewJob">{{ __('Add New Job') }}</button>
                        </div> -->
                        <div class="table-responsive pt-0">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th> {{ __('Sender') }} </th>
                                    <th> {{ __('Receiver') }} </th>
                                    <th> {{ __('Message text') }} </th>
                                    <th> {{ __('Media file') }} </th>
                                    <th> {{ __('Button') }} </th>
                                    <th> {{ __('Schedule') }} </th>
                                    <th> {{ __('Job status') }} </th>
                                    <th> {{ __('Actions') }} </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($job as $outbox)
                                <tr>
                                    <td>
                                    {{ $outbox->sender }}
                                    </td>
                                    <td>
                                    {{ $outbox->receiver }}
                                    </td>
                                    <td>
                                    {{ str_replace('{name}', $outbox->rec_name, $outbox->msgtext) }}
                                    </td>
                                    <td>
                                    {{ $outbox->mediafile }}
                                    </td>
                                    <td>
                                    {{ ($outbox->data == '[]' ? 'NO' : 'YES') }}
                                    </td>
                                    <td>
                                    {{ $outbox->schedule }}
                                    </td>
                                    <td>
                                    @if ($outbox->status == 'PENDING')
                                        <span class="badge rounded-pill badge-light-warning me-1">{{ $outbox->status }}</span>
                                    @elseif($outbox->status == 'SENT')
                                        <span class="badge rounded-pill badge-light-success me-1">{{ $outbox->status }}</span>
                                    @elseif($outbox->status == 'FAILED')
                                        <span class="badge rounded-pill badge-light-danger me-1">{{ $outbox->status }}</span>
                                    @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#destroy{{$outbox->id}}">
                                            <i data-feather="trash" class="me-0"></i>
                                        </button>
                                    </td>
                                </tr>
                                <!-- Delete Modal -->
                                <div class="modal fade modal-danger text-start" id="destroy{{$outbox->id}}" tabindex="-1" aria-labelledby="myModalLabel120" aria-hidden="true">
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
                                            <a class="btn btn-sm btn-danger" href="{{ route('outbox.destroyobx', ['outbox_id' => $outbox->id]) }}">{{ __('Delete') }}</a>
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
