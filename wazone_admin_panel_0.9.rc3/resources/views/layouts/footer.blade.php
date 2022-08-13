    <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light">
        <p class="clearfix mb-0"><span class="float-md-start d-block d-md-inline-block mt-25">COPYRIGHT &copy; <script>document.write(new Date().getFullYear());</script> {{ env('APP_NAME') }} by visimisi.net. <span class="d-none d-sm-inline-block"> All rights Reserved</span></span><span class="float-md-end d-none d-md-block">Laravel v{{ Illuminate\Foundation\Application::VERSION }} || PHP v{{ PHP_VERSION }} <i data-feather="heart"></i></span></p>
    </footer>
    <button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
    <!-- END: Footer-->

    <!-- BEGIN: whatsapp support -->
    @if (!empty(env('SUPPORT_BUTTON')))
    <div class="floating_btn">
        <a target="_blank" href="https://wa.me/{{env('SUPPORT_BUTTON_PHONE')}}">
        <div class="contact_icon">
            <i data-feather="message-square" class="font-large-1 me-0"></i>
        </div>
        </a>
        <p class="text_icon">{{ __('Need help?') }}</p>
    </div>
    <style>a{text-decoration:none}.floating_btn{position:fixed;bottom:30px;right:30px;width:100px;height:100px;display:flex;flex-direction:column;align-items:center;justify-content:center;z-index:1000}@keyframes pulsing{to{box-shadow:0 0 0 30px rgba(232,76,61,0)}}.contact_icon{background-color:#42db87;color:#fff;width:60px;height:60px;font-size:30px;border-radius:50px;text-align:center;box-shadow:2px 2px 3px #999;display:flex;align-items:center;justify-content:center;transform:translatey(0px);animation:pulse 1.5s infinite;box-shadow:0 0 0 0 #42db87;-webkit-animation:pulsing 1.25s infinite cubic-bezier(0.66,0,0,1);-moz-animation:pulsing 1.25s infinite cubic-bezier(0.66,0,0,1);-ms-animation:pulsing 1.25s infinite cubic-bezier(0.66,0,0,1);animation:pulsing 1.25s infinite cubic-bezier(0.66,0,0,1);font-weight:400;font-family:sans-serif;text-decoration:none!important;transition:all 300ms ease-in-out}.text_icon{margin-top:8px;color:#707070;font-size:13px}</style>
    @endif
    <!-- END: whatsapp support -->

</body>
<!-- END: Body-->

</html>