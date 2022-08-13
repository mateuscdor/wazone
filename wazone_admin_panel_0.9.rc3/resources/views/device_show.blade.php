@include('layouts.header')

<!-- BEGIN: Content-->
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
        <h4>{{ $device->sender }} -> Server: {{env('NODE_URL')}}</h4>
        </div>
        <div class="content-body">
            <!-- devices show start -->
            <section class="app-device-show">
                <!-- show and filter start -->
                <!-- <div class="card"> -->
                    <div class="row">
                        <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
                            <div class="card border-primary align-items-center">
                                <div class="device-avatar-section" id="cardimg-{{$device->sender}}">
                                </div>
                            </div>
                            <div class="card-body">
                                <button type="button" class="btn btn-primary" data-toggle="tooltip" title="{{__('Refresh')}}" onclick="socksession('{{$device->sender}}')"><i data-feather="refresh-cw" class="me-0"></i></button>
                                <button type="button" class="btn btn-danger" data-toggle="tooltip" title="{{__('Logout')}}" onclick="walogout('{{$device->sender}}')"><i data-feather="log-out" class="me-0"></i></button>
                                <a class="btn btn-success" data-toggle="tooltip" title="{{__('Device contacts')}}" href="{{ route('device.showcontacts', ['device_id' => $device->id]) }}" target="_blank">{{ __('Contacts') }}</a>
                            </div>
                        </div>
                        <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
                            <div class="card border-primary">
                                <textarea class="form-control" id="cardcons-{{$device->sender}}" rows="18" style="background-color: #000;color: #00ff00;border: 1px solid #000;padding: 8px;font-family: courier new;" readonly></textarea>
                            </div>
                        </div>
                    </div>
                <!-- </div> -->
                <!-- show and filter end -->
            </section>
            <!-- devices show ends -->
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
<script src="app-assets/vendors/js/socket.io/socket.io.js"></script>
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

<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

<script>
const socket = io(`{{ env('NODE_URL') }}`)

$(`#cardimg-{{ $device->sender }}`).html(`<img src="app-assets/images/app/loading.gif" class="card-img-top center" alt="loading..." id="qrcode" style="height:250px; width:250px;"><br><p> {{ __('Connecting...') }} </p>`)
socket.emit('socksession', { sender: '{{ $device->sender }}' })

function socksession(sender) {
    $(`#cardimg-${sender}`).html(`<img src="app-assets/images/app/loading.gif" class="card-img-top center" alt="loading..." id="qrcode" style="height:250px; width:250px;"><br><p> {{ __('Connecting...') }} </p>`)
    socket.emit('socksession', { sender: sender })
}

function walogout(sender) {
    socket.emit ('walogout', { sender: sender})
}

socket.on('refreshCard', (data) => {
    if (data.status == 'open') {
        if (data.imgurl) {
            imgurl = data.imgurl;
        } else {
            imgurl = "app-assets/images/app/noimage.png";
        }
        footer1 = `Name : ${data.name}`;
        footer2 = `WA # : ${data.sender}`;
    } else if (data.status == 'close') {
        imgurl = 'app-assets/images/app/refresh.png';
        footer1 = 'Whatsapp logged out';
        footer2 = 'Please refresh!';
    } else if (data.status == 'qrReceived') {
        imgurl = data.imgurl;
        footer1 = 'Multi Device (Beta)';
        footer2 = 'Use your phone to scan!';
    }
    $(`#cardimg-${data.sender}`).html(`
        <img class="img-fluid rounded mt-3 mb-2" src="${imgurl}" height="250" width="250" alt="Device avatar" />
        <ul class="ps-1 mb-2">
            <li class="mb-50">${footer1}</li>
            <li class="mb-50">${footer2}</li>
        </ul>
    `)
})

//Listen on new_message
socket.on("showLog", (data) => {
    let tnow = new Date()
    $(`#cardcons-${data.sender}`).append("\n" + tnow + "\n" + data.text + "\n")
    var pscons = $(`#cardcons-${data.sender}`);
    if(pscons.length)
       pscons.scrollTop(pscons[0].scrollHeight - pscons.height());
})

</script>

@include('layouts.footer')
