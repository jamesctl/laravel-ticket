<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>{{ trans('general.login') }} - {{ trans('general.siteName') }}</title>

    <!-- Twitter data -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@treasury.jp">
    <meta name="twitter:title" content="treasury.jp">
    <meta name="twitter:description" content="Teaching online system">
    <meta name="twitter:image" content="{{ url('themes/frontend/assets') }}/images/social.jpg">



    @include('frontend.general.favicon')
    <link href="{{ asset('css') }}/font.css" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ url('themes/admin') }}/app-assets/vendors/css/vendors.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ url('themes/admin') }}/app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="{{ url('themes/admin') }}/app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="{{ url('themes/admin') }}/app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="{{ url('themes/admin') }}/app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="{{ url('themes/admin') }}/app-assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="{{ url('themes/admin') }}/app-assets/css/themes/semi-dark-layout.css">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css"
        href="{{ url('themes/admin') }}/app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="{{ url('themes/admin') }}/app-assets/css/pages/authentication.css">
    <!-- END: Page CSS-->

    <link rel="stylesheet" type="text/css"
        href="{{ url('themes/admin') }}/app-assets/vendors/css/extensions/toastr.css">
    <link rel="stylesheet" type="text/css"
        href="{{ url('themes/admin') }}/app-assets/css/plugins/extensions/toastr.css">


    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ url('themes/admin') }}/assets/css/style.css">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body
    class="vertical-layout vertical-menu-modern boxicon-layout no-card-shadow 1-column  navbar-sticky footer-static bg-full-screen-image  blank-page blank-page"
    data-open="click" data-menu="vertical-menu-modern" data-col="1-column">
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- login page start -->
                <section id="auth-login" class="row flexbox-container">
                    <div class="col-xl-8 col-11">
                        <div class="card bg-authentication mb-0">
                            <div class="row m-0">
                                <!-- left section-login -->
                                <div class="col-md-6 col-12 px-0">
                                    <div
                                        class="card disable-rounded-right mb-0 p-2 h-100 d-flex justify-content-center">
                                        <div class="card-header pb-1">
                                            <div class="card-title">
                                                <h4 class="text-center mb-2">{{ trans('general.register') }}</h4>
                                            </div>
                                        </div>
                                        
                                        <div class="card-content">
                                            <div class="card-body">
                                                <div class="divider">
                                                    <div class="divider-text text-uppercase text-muted">
                                                        <small>{{ trans('general.check_email_otp') }}</small>
                                                        <small>{{ $email }}</small>
                                                    </div>
                                                </div>

                                                {{ html()->form('POST', route('admin.otp_register'))->open() }}

                                                    <div class="form-group mb-50">
                                                        <label class="text-bold-600"
                                                            for="login-otp">{{ trans('general.otp') }} </label>
                                                        {{ html()->text('otp')->placeholder(__('general.otp'))->class('form-control') }}
                                                        @error('otp')<i class="text-danger">{{ $message }}</i>@enderror
                                                        @if (session()->has('error'))<i class="text-danger">{{ session()->get('error') }}</i>@endif
                                                    </div>
                                                    <input type="hidden" name="email" value="{{ $email }}">

                                                    <button type="submit"
                                                        class="btn btn-primary glow w-100 position-relative authentication-login-button"
                                                        href="javascript:void(0)">{{ trans('general.create') }}<i
                                                        id="icon-arrow" class="bx bx-right-arrow-alt"></i>
                                                    </button>
                                                {{ html()->form()->close() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- right section image -->
                                <div class="col-md-6 d-md-block d-none text-center align-self-center p-3">
                                    <div class="card-content">
                                        <img class="img-fluid"
                                            src="{{ url('themes/admin') }}/app-assets/images/pages/login.png"
                                            alt="branding logo">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- login page ends -->

            </div>
        </div>
    </div>
    <!-- END: Content-->


    <!-- BEGIN: Vendor JS-->
    <script src="{{ url('themes/admin') }}/app-assets/vendors/js/vendors.min.js"></script>

    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <!-- END: Page Vendor JS-->
    <script src="{{ url('themes/admin') }}/app-assets/vendors/js/extensions/toastr.min.js"></script>
    <script src="{{ url('themes/frontend') }}/js/jquery.validate.min.js"></script>
    <script src="{{ url('themes/admin') }}/js/global.js"></script>
    {{-- <script src="{{url('themes/admin')}}/js/login.js"></script> --}}
    <!-- BEGIN: Theme JS-->
    <script src="{{ url('themes/admin') }}/app-assets/js/core/app-menu.js"></script>
    <script src="{{ url('themes/admin') }}/app-assets/js/core/app.js"></script>
    <script src="{{ url('themes/admin') }}/app-assets/js/scripts/components.js"></script>
    <script src="{{ url('themes/admin') }}/app-assets/js/scripts/footer.js"></script>
    <script>
        $('form').on('submit', (e) => {
            $(e.target).find('[type=submit]').loading()
        })
    </script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <!-- END: Page JS-->

</body>
<!-- END: Body-->

</html>
