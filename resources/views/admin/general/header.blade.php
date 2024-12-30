<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="24muaban">
    <meta name="keywords" content="24muaban">
    <meta name="author" content="24muaban">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>



    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('themes/admin/app-assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('themes/admin/app-assets/vendors/css/charts/apexcharts.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('themes/admin/app-assets/vendors/css/extensions/dragula.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('themes/admin/app-assets/vendors/css/ui/prism.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('themes/admin/app-assets/vendors/css/file-uploaders/dropzone.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('themes/admin/app-assets/css/plugins/file-uploaders/dropzone.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('themes/admin/app-assets/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('themes/admin/app-assets/css/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('themes/admin/app-assets/css/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('themes/admin/app-assets/css/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('themes/admin/app-assets/css/themes/dark-layout.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('themes/admin/app-assets/css/themes/semi-dark-layout.css') }}">
        <link rel="stylesheet" type="text/css"
        href="{{ asset('themes/admin/app-assets/vendors/css/editors/quill/quill.snow.css') }}">
    <!-- END: Theme CSS-->
    <!-- <link rel="stylesheet" type="text/css" href="{{ asset('quill/quill.snow.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('quill/quill.bubble.css') }}"> -->
    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('themes/admin/app-assets/css/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('themes/admin/app-assets/css/pages/dashboard-analytics.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('themes/admin/css/sweetalert2.min.css') }}">
    <!-- END: Page CSS-->


    <link rel="stylesheet" type="text/css"
        href="{{ asset('themes/admin/app-assets/vendors/css/extensions/toastr.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('themes/admin/app-assets/css/plugins/extensions/toastr.css') }}">


    <link rel="stylesheet" type="text/css"
        href="{{ asset('themes/admin/app-assets/vendors/css/editors/quill/katex.min.css') }}">


    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('themes/admin/assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('themes/admin/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/admin/assets/css/jquery-ui.css') }}">
    <link href="{{ asset('themes/admin/assets/css/summernote-lite.min.css') }}" rel="stylesheet">
    <link href="{{ asset('themes/admin/assets/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <!-- END: Custom CSS-->

    <script type="text/javascript">
        var rootDomain = '{{ url('') }}';
        var theModule = '';
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @livewireStyles
    @stack('css')
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body
    class="vertical-layout vertical-menu-modern boxicon-layout no-card-shadow 2-columns  navbar-sticky footer-static  "
    data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">

    <!-- BEGIN: Header-->
    <div class="header-navbar-shadow"></div>
    <nav class="header-navbar main-header-navbar navbar-expand-lg navbar navbar-with-menu fixed-top ">
        <div class="navbar-wrapper">
            <div class="navbar-container content">
                <div class="navbar-collapse" id="navbar-mobile">
                    <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                        <ul class="nav navbar-nav">
                            <li class="nav-item mobile-menu d-xl-none mr-auto"><a
                                    class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                                        class="ficon bx bx-menu"></i></a></li>
                        </ul>

                        <ul class="nav navbar-nav bookmark-icons">
                            <li class="nav-item d-none d-lg-block"><a class="nav-link" href="{{ asset('admin') }}"
                                    data-toggle="tooltip" data-placement="top"
                                    title="{{ trans('general.dashboard') }}"><i
                                        class="ficon bx bxs-categories"></i></a></li>

                        </ul>

                    </div>
                    <ul class="nav navbar-nav float-right">
                        {{-- <li class="dropdown dropdown-language nav-item">
                            <a class="dropdown-toggle nav-link dropdown-language-link" data-toggle="dropdown"
                                href="#" aria-expanded="false">
                                <img src="{{ getFlagByLocale(App::getLocale()) }}" alt=""
                                    class="border-custom">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-toogle-custom">
                                <a href="{{ route('locale.update', ['locale' => 'en']) }}" class="">
                                    <img src="{{ getFlagByLocale('en') }}" alt="" class="border-custom"></a>

                                <div class="dropdown-divider mb-0"></div>
                                <a href="{{ route('locale.update', ['locale' => 'ja']) }}" class=""><img
                                        class="border-custom" src="{{ getFlagByLocale('ja') }}" alt=""></a>
                            </div>
                        </li> --}}

                        <li class="dropdown dropdown-user nav-item">
                            <a class="dropdown-toggle nav-link dropdown-user-link" href="#"
                                data-toggle="dropdown">
                                <div class="user-nav d-sm-flex d-none"><span
                                        class="user-name">
                            <img src="{{ Auth::user()->avatarUrl ?? '' }}" alt="" class="border-custom">
                                        {{ Auth::user()->name ?? 'N/A' }}</span></div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right pb-0">
                                <a class="dropdown-item" href="{{ asset('admin/profile') }}"><i
                                        class="bx bx-user mr-50"></i> {{ trans('general.edit') }}
                                    {{ trans('general.profile') }}</a>

                                <div class="dropdown-divider mb-0"></div>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bx bx-power-off mr-50"></i> {{ trans('general.logout') }}
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- END: Header-->
