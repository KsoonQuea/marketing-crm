<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- required meta -->
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    {{--    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon"/>--}}
    <title>{{ trans('panel.site_title') }}</title>

    <!-- bootstrap five css -->
    <link rel="stylesheet" href="{{ asset('landing-assets/vendors/bootstrap/css/bootstrap.min.css') }}"/>
    <!-- font awesome five css -->
    <link rel="stylesheet" href="{{ asset('landing-assets/vendors/font-awesome/css/all.min.css') }}"/>
    <!-- nice select css -->
    <link rel="stylesheet" href="{{ asset('landing-assets/vendors/nice-select/css/nice-select.css') }}"/>
    <!-- magnific popup css -->
    <link rel="stylesheet" href="{{ asset('landing-assets/vendors/magnific-popup/css/magnific-popup.css') }}"/>
    <!-- slick css -->
    <link rel="stylesheet" href="{{ asset('landing-assets/vendors/slick/css/slick.css') }}"/>

    <!-- main css -->
    <link rel="stylesheet" href="{{ asset('landing-assets/css/style.css') }}"/>
    @vite(['resources/css/app.css', 'resources/css/tailwind.css'])
    @stack('styles')
</head>

<body>
@include('layouts.landing.header')
{{ $slot }}

<!-- Scroll To Top -->
<a href="javascript:void(0)" class="scrollToTop">
    <i class="fas fa-angle-double-up"></i>
</a>

<!-- ==== js dependencies start ==== -->

<!-- jquery -->
<script src="{{ asset('landing-assets/vendors/jquery/jquery.min.js') }}"></script>
<!-- bootstrap five js -->
<script src="{{ asset('landing-assets/vendors/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- nice select js -->
<script src="{{ asset('landing-assets/vendors/nice-select/js/jquery.nice-select.min.js') }}"></script>
<!-- magnific popup js -->
<script src="{{ asset('landing-assets/vendors/magnific-popup/js/jquery.magnific-popup.min.js') }}"></script>
<!-- slick js -->
<script src="{{ asset('landing-assets/vendors/slick/js/slick.js') }}"></script>
<!-- shuffle js -->
<script src="{{ asset('landing-assets/vendors/shuffle/shuffle.min.js') }}"></script>

<!-- ==== js dependencies end ==== -->

<!-- plugin js -->
<script src="{{ asset('landing-assets/js/plugin.js') }}"></script>
@stack('scripts')
<!-- main js -->
<script src="{{ asset('landing-assets/js/main.js') }}"></script>
</body>

</html>
