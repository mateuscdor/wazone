@include('layouts.header')

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <h4>{{ __('Send message') }}</h4>
            </div>
            <div class="content-body">
                <div class="card col-12">
                    <div class="card-body">
                        <form action="{{ route('sendmsg.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                            <div class="row">
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                <input type="hidden" name="job_id" value="{{ \Carbon\Carbon::now()->timestamp }}">
                                <div class="col-12">
                                    <label> Device </label>
                                    <select class="form-control" name="sender">
                                        @foreach($devices as $device)
                                        <option value="{{ $device->sender }}">{{ $device->name . ' (' . $device->sender . ')' }}</option>
                                        @endforeach
                                    </select><br>
                                </div>
                                <div class="col-6">
                                    <label> {{ __('Single receiver') }} </label> <label class="text-warning"> (Ex. 55918912341234, 5515912341234, 553012341234) </label>
                                    <input type="tel" name="single_receiver" placeholder="{{ __('Phone with country code') }}" class="form-control">
                                </div>
                                <div class="col-6">
                                    <label> {{ __('Multi receivers') }} </label> <label class="text-warning"> ({{ __('Optional') }}) </label>
                                    <select onchange="getphonebook()" id="phonebook" name="phonebook" class="form-control">
                                        <option value="[]">{{ __('Select phonebook') }}</option>
                                        @foreach($phonebooks as $phonebook)
                                        <option value="{{ $phonebook->data }}">{{ $phonebook->name }}</option>
                                        @endforeach
                                    </select><br>
                                </div>
                                <div class="col-6">
                                    <label> {{ __('Message text') }} </label>
                                    <select onchange="getmsgtext()" id="template" name="template" class="form-control">
                                        <option value="">{{ __('Select template') }}</option>
                                        @foreach($templates as $template)
                                        <option value="{{ $template->msgtext }}">{{ $template->name }}</option>
                                        @endforeach
                                    </select>
                                    <textarea id="msgtext" name="msgtext" class="form-control" rows="2" placeholder="{{ __('Message text here...') }}"></textarea><br>
                                </div>
                                <div class="col-6">
                                    <label> {{ __('Media file') }} </label> <label class="text-warning"> ({{ __('Optional') }})  JPG/JPEG/PNG/GIF/PDF/XLSX/MP3/MP4</label>
                                    <input type="file" name="mediafile" class="form-control"><br>
                                    <label class="text-warning"> {{ __("Button message samples") }} <a href="{{ __('https://visimisi.net/docs/wazone-buttons-message/') }}" target="_blank">{{ __('Click HERE') }}!</a></label>
                                </div>
                                @for ($i=1; $i<=$numOfButtons; $i++)
                                <div class="col-6">
                                    <label> {{ __('Button') . ' ' . $i }} </label> <label class="text-warning"> ({{ __('Optional') }}) </label>
                                    <input type="text" name="displayText{{ $i }}" placeholder="{{ __('Text on the button') }}" value="" class="form-control">
                                    <input type="text" name="responseText{{ $i }}" placeholder="{{str_replace('/public', '', url('/'))}} or +{{auth()->user()->phone}}" value="" class="form-control"><br>
                                </div>
                                @endfor
                                <div class="col-6">
                                    <label> {{ __('Schedule time') }} </label> <label class="text-warning"> ({{ __('Optional') }}) </label>
                                    <input type="datetime-local" id="schedule" name="schedule" class="form-control"><br>
                                </div>
                                <div>
                                    <button class="btn btn-primary" type="submit" id="sendmsg" onclick="this.disabled=true;this.form.submit();" name="send">{{ __('Send') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card col-12">
                    <div class="card-body">
                        <div class="card-header"><a href="{{ route('phonebook.list') }}"><h4>{{ __('Phonebook') }}</h4></a></div>
                        <div class="card-body">
                            <div class="areapb" id="areapb"></div><br>
                            <table class="table table-striped table-bordered datatable">
                                <thead>
                                    <tr>
                                        <th> {{ __('Phonebook') }} </th>
                                        <th> {{ __('Name & Receiver number') }} </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($phonebooks as $phonebook)
                                    <tr>
                                        <td>
                                        {{ $phonebook['name'] }}
                                        </td>
                                        <td>
                                        {{ str_replace(['"','[',']','name:','receiver:'], [''], \Illuminate\Support\Str::limit($phonebook->data, 100, $end='...')) }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
    <script src="app-assets/vendors/js/jquery/jquery.min.js"></script>
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

    function getmsgtext() {
    var msgtext = document.getElementById("template").value;
    document.getElementById("msgtext").innerHTML = msgtext;
    }

    function getphonebook() {
        var pbdatas = document.getElementById("phonebook").value.replace(/"|:|\[|\]|name|receiver/g, "");
        document.getElementById("areapb").innerHTML = pbdatas;
    }
</script>

@include('layouts.footer')
