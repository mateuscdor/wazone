@include('layouts.header')

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <h4>{{ $phonebook->name }} {{ __('Phonebook') }}</h4>
            </div>
            <div class="content-body">
                <!-- job list start -->
                <section class="app-job-list">
                    <!-- list and filter start -->
                    <div class="card">
                        <div class="card-body border-bottom">
                            <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addContact">{{ __('Add new contact') }}</button>
                        </div>
                        <div class="table-responsive pt-0">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>{{ __('Id') }}</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Phone') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php($contacts = json_decode($phonebook->data,true))
                                @foreach($contacts as $contact)
                                    <tr>
                                        <td><a href="javascript:;" data-bs-target="#editContact-{{$contact['id']}}" data-bs-toggle="modal">
                                        {{ $contact['id'] }}</a>
                                        </td>
                                        <td><a href="javascript:;" data-bs-target="#editContact-{{$contact['id']}}" data-bs-toggle="modal">
                                        {{ $contact['name'] }}</a>
                                        </td>
                                        <td><a href="javascript:;" data-bs-target="#editContact-{{$contact['id']}}" data-bs-toggle="modal">
                                        {{ $contact['phone'] }}</a>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#destroy-{{$contact['id']}}">
                                                <i data-feather="trash" class="me-0"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Delete Modal -->
                                    <div class="modal fade modal-danger text-start" id="destroy-{{$contact['id']}}" tabindex="-1" aria-labelledby="myModalLabel120" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="myModalLabel120">{{ __('Delete confirmation') }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    {{ __('Are you sure you want to delete?') }} <br><br>
                                                    <span class="text text-danger"> <b>{{ $contact['name'] }}</b> </span><br><br>
                                                    {{ __('This process is irreversible.') }} <br>
                                                    {{ __('The record(s) will be deleted from the database permanently.') }}
                                                </div>
                                                <div class="modal-footer">
                                                    <a class="btn btn-sm btn-danger" href="{{ route('phonebook.destroycontact', ['contact_id' => $contact['id'], 'phonebook_id' => $phonebook->id]) }}">{{ __('Delete') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Edit Contact Modal -->
                                    <div class="modal fade" id="editContact-{{$contact['id']}}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-contact">
                                            <div class="modal-content">
                                                <div class="modal-header bg-transparent">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                                    <div class="text-center mb-2">
                                                        <h1 class="mb-1">{{ __('Edit contact') }}</h1>
                                                    </div>
                                                    <form action="{{ route('phonebook.editcontact') }}" method="GET" id="editContactForm" class="row gy-1 pt-75" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="row">
                                                        <div class="col-12 col-md-6">
                                                            <input type="hidden" name="contact_id" value="{{ $contact['id'] }}" />
                                                            <input type="hidden" name="phonebook_id" value="{{ $phonebook->id }}" />
                                                            <label class="form-label" for="contact_name">{{ __('Contact name') }}</label>
                                                            <input type="text" name="contact_name" class="form-control" value="{{ $contact['name'] }}" placeholder="{{ __('Contact name') }}" required />
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <label class="form-label" for="contact_phone">{{ __('Contact phone') }}</label>
                                                            <input type="text" name="contact_phone" class="form-control" value="{{ $contact['phone'] }}" placeholder="{{ __('Contact phone') }}" />
                                                        </div>
                                                        <div class="col-12 text-center mt-2 pt-50">
                                                            <button type="submit" class="btn btn-primary me-1">{{ __('Submit') }}</button>
                                                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                                                {{ __('Cancel') }}
                                                            </button>
                                                        </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/ Edit Contact Modal -->
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Add Contact Modal -->
                        <div class="modal fade" id="addContact" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered modal-add-contact">
                                <div class="modal-content">
                                    <div class="modal-header bg-transparent">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body pb-5 px-sm-5 pt-50">
                                        <div class="text-center mb-2">
                                            <h1 class="mb-1">{{ __('Add contact') }}</h1>
                                        </div>
                                        <form action="{{ route('phonebook.addcontact') }}" method="GET" id="addContactForm" class="row gy-1 pt-75" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                            <div class="col-12 col-md-6">
                                                <input type="hidden" name="contact_id" value="{{ $contact['id'] }}" />
                                                <input type="hidden" name="phonebook_id" value="{{ $phonebook->id }}" />
                                                <label class="form-label" for="contact_name">{{ __('Contact name') }}</label>
                                                <input type="text" name="contact_name" class="form-control" value="{{ $contact['name'] }}" placeholder="{{ __('Contact name') }}" required />
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label class="form-label" for="contact_phone">{{ __('Contact phone') }}</label>
                                                <input type="text" name="contact_phone" class="form-control" value="{{ $contact['phone'] }}" placeholder="{{ __('Contact phone') }}" />
                                            </div>
                                            <div class="col-12 text-center mt-2 pt-50">
                                                <button type="submit" class="btn btn-primary me-1">{{ __('Submit') }}</button>
                                                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                                    {{ __('Cancel') }}
                                                </button>
                                            </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ Add Contact Modal -->
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
