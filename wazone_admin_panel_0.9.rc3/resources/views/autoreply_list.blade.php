@include('layouts.header')

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <h4>{{ __('Autoreply list') }}</h4>
            </div>
            <div class="content-body">
                <!-- autoreply list start -->
                <section class="app-autoreply-list">
                    <!-- list and filter start -->
                    <div class="card">
                        <div class="card-body border-bottom">
                            <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addNewAutoreply">{{ __('Add new autoreply') }}</button>
                            <form action="{{ route('autoreply.search') }}" method="GET">
                            @csrf
                                <div class="form-group form-group-feedback form-group-feedback-right search-box">
                                    <input type="text" name="filter" class="form-control-sm search-input" placeholder="{{ __('Phone, Message') }}">
                                    <i data-feather="search" class="font-medium-4"></i>
                                </div>
                                <button type="submit" class="hidden">Search</button>
                            </form>
                        </div>
                        <div class="table-responsive pt-0">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>{{ __('Sender') }}</th>
                                        <th>{{ __('Keyword') }}</th>
                                        <th>{{ __('Match %') }}</th>
                                        <th>{{ __('Response') }}</th>
                                        <th>{{ __('Media file') }}</th>
                                        <th>{{ __('Button') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($autoreplies as $autoreply)
                                    <tr>
                                        <td><a href="javascript:;" data-bs-target="#editAutoreply-{{$autoreply->id}}" data-bs-toggle="modal">
                                        {{ $autoreply->sender }}</a>
                                        </td>
                                        <td><a href="javascript:;" data-bs-target="#editAutoreply-{{$autoreply->id}}" data-bs-toggle="modal">
                                        {{ $autoreply->keyword }}</a>
                                        </td>
                                        <td><a href="javascript:;" data-bs-target="#editAutoreply-{{$autoreply->id}}" data-bs-toggle="modal">
                                        {{ $autoreply->match_percent }}</a>
                                        </td>
                                        <td><a href="javascript:;" data-bs-target="#editAutoreply-{{$autoreply->id}}" data-bs-toggle="modal">
                                        {{ \Illuminate\Support\Str::limit($autoreply->response, 150, $end='...') }}</a>
                                        </td>
                                        <td><a href="javascript:;" data-bs-target="#editAutoreply-{{$autoreply->id}}" data-bs-toggle="modal">
                                        {{ $autoreply->mediafile }}</a>
                                        </td>
                                        <td><a href="javascript:;" data-bs-target="#editAutoreply-{{$autoreply->id}}" data-bs-toggle="modal">
                                        {{ ($autoreply->data == '[]' ? 'NO' : 'YES') }}</a>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#destroy{{$autoreply->id}}">
                                                <i data-feather="trash" class="me-0"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Delete Modal -->
                                    <div class="modal fade modal-danger text-start" id="destroy{{$autoreply->id}}" tabindex="-1" aria-labelledby="myModalLabel120" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="myModalLabel120">{{ __('Delete confirmation') }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    {{ __('Are you sure you want to delete?') }} <br><br>
                                                    <span class="text text-danger"> <b>{{ $autoreply->keyword }}</b> </span><br><br>
                                                    {{ __('This process is irreversible.') }} <br>
                                                    {{ __('The record(s) will be deleted from the database permanently.') }}
                                                </div>
                                                <div class="modal-footer">
                                                    <a class="btn btn-sm btn-danger" href="{{ route('autoreply.destroy', ['autoreply_id' => $autoreply->id]) }}">{{ __('Delete') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Edit Autoreply Modal -->
                                    <div class="modal fade" id="editAutoreply-{{$autoreply->id}}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-autoreply">
                                            <div class="modal-content">
                                                <div class="modal-header bg-transparent">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                                    <div class="text-center mb-2">
                                                        <h1 class="mb-1">{{ __('Edit autoreply') }}</h1>
                                                    </div>
                                                    <form action="{{ route('autoreply.update') }}" method="POST" id="editAutoreplyForm" class="row gy-1 pt-75" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="row">
                                                        <div class="col-12">
                                                            <input type="hidden" name="autoreply_id" value="{{ $autoreply->id }}" />
                                                            <input type="hidden" name="prev_mediafile" value="{{ $autoreply->mediafile }}" />
                                                            <input type="hidden" name="prev_mediaurl" value="{{ $autoreply->mediaurl }}" />
                                                            <input type="hidden" name="prev_keyword" value="{{ $autoreply->keyword }}" />
                                                            <label class="form-label" for="sender">{{ __('Autoreply sender') }}</label>
                                                            <select class="form-control" name="sender">
                                                                <option value="all" {{ ($autoreply->sender == "all" ? "selected" : "") }}>{{ __('ALL') }}</option>
                                                                @foreach($devices as $device)
                                                                <option value="{{ $device->sender }}" {{ ($autoreply->sender == $device->sender ? "selected" : "") }}>{{ $device->name . ' (' . $device->sender . ')' }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <label class="form-label" for="keyword">{{ __('Autoreply keyword') }}</label>
                                                            <input type="text" name="keyword" class="form-control" value="{{ $autoreply->keyword }}" placeholder="{{ __('Autoreply keyword') }}" required />
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <label class="form-label" for="match_percent">{{ __('Autoreply match percentage') }}</label>
                                                            <input type="text" name="match_percent" class="form-control" value="{{ $autoreply->match_percent }}" placeholder="1 - 100" required />
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <label class="form-label" for="response">{{ __('Autoreply response') }}</label> <label class="text-warning"> {name} {{ __('will display the receivers name') }} </label>
                                                            <textarea name="response" class="form-control" rows="4" placeholder="Response text" required>{{ $autoreply->response }}</textarea>
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <label class="form-label" for="mediafile">{{ __('Autoreply mediafile') }}</label> <label class="text-warning"> ({{ __('Optional') }}) JPG/JPEG/PNG/GIF/PDF/XLSX/MP3/MP4 </label>
                                                            <input type="file" name="mediafile" class="form-control" />{{ $autoreply->mediafile }}<br>
                                                            <label class="text-warning"> {{ __("Button message samples") }} <a href="{{ __('https://visimisi.net/docs/wazone-buttons-message/') }}" target="_blank">{{ __('Click HERE') }}!</a></label>
                                                        </div>
                                                        @if(json_decode($autoreply->data))
                                                            @foreach(json_decode($autoreply->data) as $key => $val)
                                                                <div class="col-12 col-md-6">
                                                                @foreach($val as $k => $v)
                                                                    @php $odd = true @endphp
                                                                    @if(is_integer($v))
                                                                        <label>{{ __('Button') . ' ' . $v }}</label> <label class="text-warning">({{ __('Optional') }})</label>
                                                                        @continue
                                                                    @else
                                                                        @foreach($v as $value)
                                                                            @if($odd)
                                                                                @php $name = 'displayText' . $val->index @endphp
                                                                                @php $odd = false @endphp 
                                                                            @else
                                                                                @php $name = 'responseText' . $val->index @endphp
                                                                                @php $odd = true @endphp
                                                                            @endif
                                                                            <input type="text" name="{{$name}}" value="{{$value}}" class="form-control">
                                                                        @endforeach
                                                                        <br>
                                                                    @endif
                                                                @endforeach
                                                                </div>
                                                            @endforeach
                                                        @endif
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
                                    <!--/ Edit Autoreply Modal -->
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Modal to add new autoreply starts-->
                        <div class="modal modal-slide-in new-autoreply-modal fade" id="addNewAutoreply">
                            <div class="modal-dialog">
                                <form action="{{ route('autoreply.store') }}" method="POST" class="add-new-autoreply modal-content pt-0" enctype="multipart/form-data">
                                @csrf
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                    <div class="modal-header mb-1">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ __('Add new autoreply') }}</h5>
                                    </div>
                                    <div class="modal-body flex-grow-1">
                                        <div class="mb-1">
                                            <label class="form-label" for="sender">{{ __('Autoreply sender') }}</label>
                                            <select class="form-control" name="sender">
                                                <option value="all">{{ __('ALL') }}</option>
                                                @foreach($devices as $device)
                                                <option value="{{ $device->sender }}">{{ $device->name . ' (' . $device->sender . ')' }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label" for="keyword">{{ __('Autoreply keyword') }}</label>
                                            <input type="text" name="keyword" class="form-control" placeholder="{{ __('Autoreply keyword') }}" required />
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label" for="match_percent">{{ __('Autoreply match percentage') }}</label>
                                            <input type="number" name="match_percent" class="form-control dt-dname" placeholder="1 - 100" value="100" required />
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label" for="response">{{ __('Autoreply response') }}</label>
                                            <textarea name="response" class="form-control" rows="4" placeholder="{name} {{ __('will display the receivers name') }}" required></textarea>
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label" for="mediafile">{{ __('Autoreply mediafile') }}</label> <label class="text-warning"> ({{ __('Optional') }})  JPG/JPEG/PNG/GIF/PDF/XLSX/MP3/MP4 </label>
                                            <input type="file" name="mediafile" class="form-control" placeholder="{{ __('Autoreply mediafile') }}" /><br>
                                            <label class="text-warning"> {{ __("Button message samples") }} <a href="{{ __('https://visimisi.net/docs/wazone-buttons-message/') }}" target="_blank">{{ __('Click HERE') }}!</a></label>
                                        </div>
                                        @for ($i=1; $i<=$numOfButtons; $i++)
                                        <div class="mb-1">
                                            <label> {{ __('Button') . ' ' . $i }} </label> <label class="text-warning"> ({{ __('Optional') }}) </label>
                                            <input type="text" name="displayText{{ $i }}" placeholder="{{ __('Text on the button') }}" value="" class="form-control">
                                            <input type="text" name="responseText{{ $i }}" placeholder="{{str_replace('/public', '', url('/'))}} or +{{auth()->user()->phone}}" value="" class="form-control"><br>
                                        </div>
                                        @endfor
                                        <button type="submit" class="btn btn-primary me-1 data-submit">{{ __('Submit') }}</button>
                                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Modal to add new autoreply Ends-->
                    </div>
                    <!-- list and filter end -->
                </section>
                <!-- autoreply list ends -->
                <div class="row">
                    <div class="col-md-12">
                        {{ $autoreplies->links() }}
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
