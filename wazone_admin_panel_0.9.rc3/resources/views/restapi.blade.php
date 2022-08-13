@include('layouts.header')

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            @if (auth()->user()->role === 'admin')
            <div class="content-header row">
                <h4>{{ __('License activation status') }}</h4>
            </div>
            <div class="content-body">
                <!-- templates list start -->
                <section class="app-template-list">
                    <!-- list and filter start -->
                    <div class="card">
                        <div class="card-body border-bottom">
                            @if ($authed)
                            <span class="badge rounded-pill badge-light-success me-1">Activated</span>
                            @else
                            <span class="badge rounded-pill badge-light-danger me-1">Please activate first!</span>
                            <a href="{{ url('auth/userid') }}" type="button" class="btn btn-primary">Activate now!</a>
                            @endif
                        </div>
                    </div>
                </section>
            </div>
            @endif
            <div class="content-header row">
                <h4>{{ __('Rest API') }}</h4>
            </div>
            <div class="content-body">
                <!-- templates list start -->
                <section class="app-template-list">
                    <!-- list and filter start -->
                    <div class="card">
                        <div class="card-body border-bottom">

<h3>PHP API CODE Send Text/Media Message (GET)</h3>
<!-- HTML generated using highlightmycode -->
<div style="background: #ffffff; overflow:auto;width:auto;border:solid gray;border-width:.1em .1em .1em .8em;padding:.2em .6em;">
<pre class="php" style="font-family:monospace;"><span class="text-gray-dark">&lt;?php</span>
    <span class="text-primary">$response1</span> <span class="text-success">=</span> <span class="text-danger">file_get_contents</span><span class="text-success">&#40;</span><span class="text-primary">'{{env('NODE_URL')}}/send?receiver={{$receiver}}&amp;msgtext={{$msgtext2}}&amp;sender={{$sender}}&amp;token={{$token}}'</span><span class="text-success">&#41;</span><span class="text-success">;</span>
    <span class="text-primary">$response2</span> <span class="text-success">=</span> <span class="text-danger">file_get_contents</span><span class="text-success">&#40;</span><span class="text-primary">'{{env('NODE_URL')}}/send?receiver={{$receiver}}&amp;msgtext={{$msgtext2}}&amp;sender={{$sender}}&amp;token={{$token}}&amp;mediaurl={{$mediaurl}}'</span><span class="text-success">&#41;</span><span class="text-success">;</span>
&nbsp;
    <span class="text-gray-dark">echo</span> <span class="text-primary">$response1</span><span class="text-success">;</span>
    <span class="text-gray-dark">echo</span> <span class="text-primary">$response2</span><span class="text-success">;</span></pre>
</div>
<br><br>

<h3>PHP API CODE Send Text/Media Message (POST)</h3>
<div style="background: #ffffff; overflow:auto;width:auto;border:solid gray;border-width:.1em .1em .1em .8em;padding:.2em .6em;">
<pre class="php" style="font-family:monospace;"><span class="text-gray-dark">&lt;?php</span>
    
    <span class="text-primary">$nodeurl</span> <span class="text-success">=</span> <span class="text-primary">'{{env('NODE_URL')}}/send'</span><span class="text-success">;</span>
&nbsp;
    <span class="text-primary">$mediaurl</span> <span class="text-success">=</span> <span class="text-primary">'{{$mediaurl}}'</span><span class="text-success">;</span>
&nbsp;
    <span class="text-primary">$buttons</span> <span class="text-success">=</span> <span class="text-success">&#91;</span>
        <span class="text-success">&#91;</span><span class="text-primary">'index'</span> <span class="text-success">=&gt;</span> <span class="text-primary">1</span><span class="text-success">,</span> <span class="text-primary">'urlButton'</span> <span class="text-success">=&gt;</span> <span class="text-success">&#91;</span><span class="text-primary">'displayText'</span> <span class="text-success">=&gt;</span> <span class="text-primary">'Visit my website!'</span><span class="text-success">,</span> <span class="text-primary">'url'</span> <span class="text-success">=&gt;</span> <span class="text-primary">'{{ str_replace('/public','',url('/')) }}'</span><span class="text-success">&#93;</span><span class="text-success">&#93;</span><span class="text-success">,</span>
        <span class="text-success">&#91;</span><span class="text-primary">'index'</span> <span class="text-success">=&gt;</span> <span class="text-primary">2</span><span class="text-success">,</span> <span class="text-primary">'callButton'</span> <span class="text-success">=&gt;</span> <span class="text-success">&#91;</span><span class="text-primary">'displayText'</span> <span class="text-success">=&gt;</span> <span class="text-primary">'Call me!'</span><span class="text-success">,</span> <span class="text-primary">'phoneNumber'</span> <span class="text-success">=&gt;</span> <span class="text-primary">'+1 (234) 5678-9012'</span><span class="text-success">&#93;</span><span class="text-success">&#93;</span><span class="text-success">,</span>
        <span class="text-success">&#91;</span><span class="text-primary">'index'</span> <span class="text-success">=&gt;</span> <span class="text-primary">3</span><span class="text-success">,</span> <span class="text-primary">'quickReplyButton'</span> <span class="text-success">=&gt;</span> <span class="text-success">&#91;</span><span class="text-primary">'displayText'</span> <span class="text-success">=&gt;</span> <span class="text-primary">'This is a reply, just like normal buttons!'</span><span class="text-success">,</span> <span class="text-primary">'id'</span> <span class="text-success">=&gt;</span> <span class="text-primary">'id-like-buttons-message'</span><span class="text-success">&#93;</span><span class="text-success">&#93;</span><span class="text-success">,</span>
    <span class="text-success">&#93;</span><span class="text-success">;</span>
&nbsp;
    <span class="text-primary">$data</span> <span class="text-success">=</span> <span class="text-success">&#91;</span>
        <span class="text-primary">'receiver'</span>  <span class="text-success">=&gt;</span> <span class="text-primary">'{{$receiver}}'</span><span class="text-success">,</span>
        <span class="text-primary">'msgtext'</span>   <span class="text-success">=&gt;</span> <span class="text-primary">'{{$msgtext}}'</span><span class="text-success">,</span>
        <span class="text-primary">'sender'</span>    <span class="text-success">=&gt;</span> <span class="text-primary">'{{$sender}}'</span><span class="text-success">,</span>
        <span class="text-primary">'token'</span>     <span class="text-success">=&gt;</span> <span class="text-primary">'{{$token}}'</span><span class="text-success">,</span>
        <span class="text-primary">'mediaurl'</span>  <span class="text-success">=&gt;</span> <span class="text-primary">$mediaurl</span><span class="text-success">,</span> <span class="text-warning">// delete this line if no media</span>
        <span class="text-primary">'buttons'</span>   <span class="text-success">=&gt;</span> <span class="text-primary">$buttons</span><span class="text-success">,</span> <span class="text-warning">// delete this line if no buttons</span>
    <span class="text-success">&#93;</span><span class="text-success">;</span>
&nbsp;
    <span class="text-primary">$ch</span> <span class="text-success">=</span> <span class="text-danger">curl_init</span><span class="text-success">&#40;</span><span class="text-success">&#41;</span><span class="text-success">;</span>
    <span class="text-danger">curl_setopt</span><span class="text-success">&#40;</span><span class="text-primary">$ch</span><span class="text-success">,</span> <span class="text-warning">CURLOPT_HTTPHEADER</span><span class="text-success">,</span> <span class="text-success">&#91;</span><span class="text-primary">'Content-Type: application/x-www-form-urlencoded'</span><span class="text-success">&#93;</span><span class="text-success">&#41;</span><span class="text-success">;</span>
    <span class="text-danger">curl_setopt</span><span class="text-success">&#40;</span><span class="text-primary">$ch</span><span class="text-success">,</span> <span class="text-warning">CURLOPT_CUSTOMREQUEST</span><span class="text-success">,</span> <span class="text-primary">'POST'</span><span class="text-success">&#41;</span><span class="text-success">;</span>
    <span class="text-danger">curl_setopt</span><span class="text-success">&#40;</span><span class="text-primary">$ch</span><span class="text-success">,</span> <span class="text-warning">CURLOPT_RETURNTRANSFER</span><span class="text-success">,</span> <span class="text-primary">true</span><span class="text-success">&#41;</span><span class="text-success">;</span>
    <span class="text-danger">curl_setopt</span><span class="text-success">&#40;</span><span class="text-primary">$ch</span><span class="text-success">,</span> <span class="text-warning">CURLOPT_POSTFIELDS</span><span class="text-success">,</span> <span class="text-danger">http_build_query</span><span class="text-success">&#40;</span><span class="text-primary">$data</span><span class="text-success">&#41;</span><span class="text-success">&#41;</span><span class="text-success">;</span>
    <span class="text-danger">curl_setopt</span><span class="text-success">&#40;</span><span class="text-primary">$ch</span><span class="text-success">,</span> <span class="text-warning">CURLOPT_URL</span><span class="text-success">,</span> <span class="text-primary">$nodeurl</span><span class="text-success">&#41;</span><span class="text-success">;</span>
    <span class="text-danger">curl_setopt</span><span class="text-success">&#40;</span><span class="text-primary">$ch</span><span class="text-success">,</span> <span class="text-warning">CURLOPT_TIMEOUT</span><span class="text-success">,</span> <span class="text-primary">30</span><span class="text-success">&#41;</span><span class="text-success">;</span>
    <span class="text-danger">curl_setopt</span><span class="text-success">&#40;</span><span class="text-primary">$ch</span><span class="text-success">,</span> <span class="text-warning">CURLOPT_SSL_VERIFYHOST</span><span class="text-success">,</span> <span class="text-primary">0</span><span class="text-success">&#41;</span><span class="text-success">;</span>
    <span class="text-danger">curl_setopt</span><span class="text-success">&#40;</span><span class="text-primary">$ch</span><span class="text-success">,</span> <span class="text-warning">CURLOPT_SSL_VERIFYPEER</span><span class="text-success">,</span> <span class="text-primary">0</span><span class="text-success">&#41;</span><span class="text-success">;</span>
    <span class="text-primary">$response</span> <span class="text-success">=</span> <span class="text-danger">curl_exec</span><span class="text-success">&#40;</span><span class="text-primary">$ch</span><span class="text-success">&#41;</span><span class="text-success">;</span>
    <span class="text-danger">curl_close</span><span class="text-success">&#40;</span><span class="text-primary">$ch</span><span class="text-success">&#41;</span><span class="text-success">;</span>
&nbsp;
    <span class="text-gray-dark">echo</span> <span class="text-primary">$response</span><span class="text-success">;</span> </pre>
</div>
<br><br>

@if (auth()->user()->role === 'admin')
<h3>Cron job send text and media</h3>
<!-- HTML generated using highlightmycode -->
<div style="background: #ffffff; overflow:auto;width:auto;border:solid gray;border-width:.1em .1em .1em .8em;padding:.2em .6em;">
<pre class="javascript" style="font-family:monospace;"><span class="text-danger">/usr/local/bin/php</span> <span class="text-warning">{{ base_path() }}</span><span class="text-danger">/artisan schedule:run</span> <span class="text-success">&gt;&gt;</span> <span class="text-success">/</span><span class="text-warning">dev</span><span class="text-success">/</span><span class="text-primary">null</span> <span class="text-danger">2</span><span class="text-success">&gt;&amp;</span><span class="text-danger">1</span></pre>
</div>
<br><br>
@endif

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
</script>

@include('layouts.footer')
