<!DOCTYPE html>
@php
App::setLocale(auth()->user()->lang);
@endphp
<html class="loading {{ auth()->user()->theme }}" lang="{{ auth()->user()->lang }}">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Wazone Whatsapp Gateway by visimisi.net, simple but powerful, handles complex tasks, clean and easy to read codes.">
    <meta name="keywords" content="wazone gateway, multi device, baileys, multi sessions, multi users">
    <meta name="author" content="ARROCY">
    <title>{{ env('APP_NAME') }}</title>
    <link rel="apple-touch-icon" href="{{ url('/') }}/app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('/') }}/app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/vendors/css/vendors.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/themes/bordered-layout.css">
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/themes/semi-dark-layout.css">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/app-assets/css/plugins/forms/form-validation.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/css/style.css">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">

    <!-- BEGIN: Header-->
    <nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow container-xxl">
        <div class="navbar-container d-flex content">
            <ul class="nav navbar-nav d-xl-none">
                <li class="nav-item"><a class="nav-link menu-toggle" href="#"><i class="ficon" data-feather="menu"></i></a></li>
            </ul>
            <!-- BEGIN: Alert -->
            @if (Session::has('success_alert'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <div class="alert-body">{!! Session::get('success_alert') !!}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @elseif(Session::has('danger_alert'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <div class="alert-body">{!! Session::get('danger_alert') !!}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if ($errors->any())
            <div class="alert alert-danger" alert-dismissible fade show role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <!-- END: Alert -->

            <ul class="nav navbar-nav align-items-center ms-auto">
                <li class="nav-item impersonate">
                    @impersonating($guard = null)
                        <a class="btn btn-warning" href="{{ route('user.leaveimpersonate') }}">ADMIN</a>
                    @endImpersonating
                </li>
                <li class="nav-item dropdown dropdown-language"><a class="nav-link dropdown-toggle" id="dropdown-flag" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="flag-icon flag-icon-{{ auth()->user()->lang }}"></i><span class="selected-language">{{ auth()->user()->lang }}</span></a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-flag">
                        @foreach(glob(base_path() . '/lang/*.json') as $file)
                        @php $locale = pathinfo($file, PATHINFO_FILENAME); @endphp
                        <a class="dropdown-item" href="{{ route('user.locale', ['locale' => $locale]) }}" data-language="{{ $locale }}">
                            <i class="flag-icon flag-icon-{{ $locale }}"></i>
                            {{ $locale }}
                        </a>
                        @endforeach
                    </div>
                </li>
                <li class="nav-item dropdown dropdown-user">
                    <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="user-nav d-sm-flex d-none">
                            <span class="user-name fw-bolder">{{ auth()->user()->name }}</span>
                            <span class="user-status">{{ App\Models\Package::where('id', auth()->user()->package_id)->value('name') }}</span>
                        </div>
                        <span class="avatar">
                            <img class="round" src="{{ env('APP_URL') . '/public/users/' . auth()->user()->id . '/avatar.png' }}" alt="avatar" height="40" width="40">
                            <span class="avatar-status-online"></span>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
                        <a class="dropdown-item" href="{{ route('user.show', ['user_id' => auth()->user()->id]) }}">
                            <i class="me-50" data-feather="user"></i> Profile
                        </a>
                        @if (Auth::check())
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="me-50" data-feather="power"></i> Logout
                        </a>
                        <form method="POST" id="logout-form" action="{{ route('logout') }}">
                            @csrf
                        </form>
                        @else
                        <a class="dropdown-item" href="{{ Route::has('login') ? route('login') : 'javascript:void(0)' }}">
                            <i class="me-50" data-feather="log-in"></i> Login
                        </a>
                        @endif
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <!-- END: Header-->

    <!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item me-auto">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <span class="brand-logo">
                            <img src="{{ \Helper::setting('logoUrl') }}"  height="36">
                            <defs>
                                <lineargradient id="linearGradient-1" x1="100%" y1="10.5120544%" x2="50%" y2="89.4879456%">
                                    <stop stop-color="#000000" offset="0%"></stop>
                                    <stop stop-color="#FFFFFF" offset="100%"></stop>
                                </lineargradient>
                                <lineargradient id="linearGradient-2" x1="64.0437835%" y1="46.3276743%" x2="37.373316%" y2="100%">
                                    <stop stop-color="#EEEEEE" stop-opacity="0" offset="0%"></stop>
                                    <stop stop-color="#FFFFFF" offset="100%"></stop>
                                </lineargradient>
                            </defs>
                            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="Artboard" transform="translate(-400.000000, -178.000000)">
                                    <g id="Group" transform="translate(400.000000, 178.000000)">
                                        <path class="text-primary" id="Path" d="M-5.68434189e-14,2.84217094e-14 L39.1816085,2.84217094e-14 L69.3453773,32.2519224 L101.428699,2.84217094e-14 L138.784583,2.84217094e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L6.71554594,44.4188507 C2.46876683,39.9813776 0.345377275,35.1089553 0.345377275,29.8015838 C0.345377275,24.4942122 0.230251516,14.560351 -5.68434189e-14,2.84217094e-14 Z" style="fill:currentColor"></path>
                                        <path id="Path1" d="M69.3453773,32.2519224 L101.428699,1.42108547e-14 L138.784583,1.42108547e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L32.8435758,70.5039241 L69.3453773,32.2519224 Z" fill="url(#linearGradient-1)" opacity="0.2"></path>
                                        <polygon id="Path-2" fill="#000000" opacity="0.049999997" points="69.3922914 32.4202615 32.8435758 70.5039241 54.0490008 16.1851325"></polygon>
                                        <polygon id="Path-21" fill="#000000" opacity="0.099999994" points="69.3922914 32.4202615 32.8435758 70.5039241 58.3683556 20.7402338"></polygon>
                                        <polygon id="Path-3" fill="url(#linearGradient-2)" opacity="0.099999994" points="101.428699 0 83.0667527 94.1480575 130.378721 47.0740288"></polygon>
                                    </g>
                                </g>
                            </g>
                        </span>
                        <h2 class="brand-text">{{ env('APP_NAME') }}</h2>
                    </a></li>
                <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class="nav-item"><a class="d-flex align-items-center" href="{{ route('user.show', ['user_id' => auth()->user()->id]) }}"><i data-feather="user"></i><span class="menu-item text-truncate">{{ __('Profile') }}</span></a></li>
                <li class="nav-item"><a class="d-flex align-items-center" href="{{ route('device.list') }}"><i data-feather="phone"></i><span class="menu-item text-truncate">{{ __('Devices') }}</span><span class="badge badge-light-primary rounded-pill ms-auto me-1">{{ DB::table('devices')->where('user_id', '=', auth()->user()->id)->count() }}</span></a></li>
                <li class="nav-item"><a class="d-flex align-items-center" href="{{ route('sendmsg.index') }}"><i data-feather="send"></i><span class="menu-item text-truncate">{{ __('Send message') }}</span></a></li>
                <li class="nav-item"><a class="d-flex align-items-center" href="{{ route('autoreply.list') }}"><i data-feather="repeat"></i><span class="menu-item text-truncate">{{ __('Autoreply') }}</span></a></li>
                <li class="nav-item"><a class="d-flex align-items-center" href="{{ route('outbox.list') }}"><i data-feather="external-link"></i><span class="menu-item text-truncate">{{ __('Outbox') }}</span></a></li>
                <li class="nav-item"><a class="d-flex align-items-center" href="{{ route('phonebook.list') }}"><i data-feather="book"></i><span class="menu-item text-truncate">{{ __('Phonebooks') }}</span></a></li>
                <li class="nav-item"><a class="d-flex align-items-center" href="{{ route('template.list') }}"><i data-feather="message-square"></i><span class="menu-item text-truncate">{{ __('Templates') }}</span></a></li>
                <li class="nav-item"><a class="d-flex align-items-center" href="{{ route('blocked.list') }}"><i data-feather="lock"></i><span class="menu-item text-truncate">{{ 'Blocked Numbers' }}</span></a></li>
                <li class="nav-item"><a class="d-flex align-items-center" href="{{ route('restapi.index') }}"><i data-feather="zap"></i><span class="menu-item text-truncate">{{ __('Rest API') }}</span></a></li>
                @if (\Module::find('ChatSupport') && \Module::find('ChatSupport')->isEnabled())
                <li class="nav-item"><a class="d-flex align-items-center" href="{{ route('support.index') }}"><i data-feather='message-circle'></i><span class="menu-item text-truncate">{{ __('Chat support') }}</span></a></li>
                @endif

                @if (auth()->user()->role === 'admin')
                <li class="navigation-header"><span>Admin Access</span><i data-feather="more-horizontal"></i></li>
                <li class="nav-item"><a class="d-flex align-items-center" href="{{ route('module.list') }}"><i data-feather="layers"></i><span class="menu-item text-truncate">{{ __('Modules') }}</span></a></li>
                @if (\Helper::isEx())
                <li class="nav-item"><a class="d-flex align-items-center" href="{{ route('package.list') }}"><i data-feather="package"></i><span class="menu-item text-truncate">{{ __('Packages') }}</span></a></li>
                @endif
                <li class="nav-item"><a class="d-flex align-items-center" href="{{ route('setting.list') }}"><i data-feather="settings"></i><span class="menu-item text-truncate">{{ __('Settings') }}</span></a></li>
                <li class="nav-item"><a class="d-flex align-items-center" href="{{ route('user.list') }}"><i data-feather="users"></i><span class="menu-item text-truncate">{{ __('Users') }}</span><span class="badge badge-light-primary rounded-pill ms-auto me-1">{{ DB::table('users')->count() }}</span></a></li>
                @endif
                <li class="navigation-header"><span>{{ file_get_contents(base_path('version.txt')) }}{{ (\Helper::isEx()) ? '.extended' : '' }}</span><i data-feather="more-horizontal"></i></li>
            </ul>
        </div>
    </div>
    <!-- END: Main Menu-->

