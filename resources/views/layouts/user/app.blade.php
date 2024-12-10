<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ trans('panel.site_title') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- favicon -->
    <link rel="icon" href="{{asset('assets/images/favicon.png')}}" type="image/x-icon"/>
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}" type="image/x-icon"/>
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <!-- Font Awesome-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/fontawesome.css') }}">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/icofont.css') }}">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/themify.css') }}">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/flag-icon.css') }}">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/feather-icon.css') }}">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datatable-extension.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/date-picker.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/owlcarousel.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/prism.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/whether-icon.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/summernote.css') }}">
@stack('styles')
<!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.css') }}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{ asset('assets/css/color-1.css') }}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css') }}">

    <!-- feather icon js-->
    <script src="{{ asset('assets/js/icons/feather-icon/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/icons/feather-icon/feather-icon.js') }}"></script>

    @vite(['resources/css/tailwind.css', 'resources/css/media.css', 'resources/js/app.js'])
    <livewire:styles />
    <style>
        /* alert css */
        .return-message-div .alert {
            margin-bottom: 0 !important;
        }

        .return-message-div .alert-success {
            border-color: #1d9758;
            background: #1d9758;
        }
        /* ck-editor */
        .cke_1{ border:1px solid #e4e4e4!important; }
        /* global */
        .card-title{ padding-left:10px; border-left:4px solid #2198c3; }
        .float-right{ float:right; }
        /* modal */
        .modal-content{ padding:0!important; }
        .modal-header{ background: #2198c3!important; padding:0.75em 1em!important; }
        .modal-body{ padding:1em!important; }
        .modal-inside-title{
            color:#ffffff!important;
            font-size:1.4em;
            margin-bottom:0;
        }
    </style>
</head>

<body style="background-color: #f8f8f8">
<!-- Loader starts-->
<div class="loader-wrapper">
    <div class="theme-loader"></div>
</div>

@includeIf('layouts.user.header')

<div class="page-body px-4">
    <div class="return-message-div">

    </div>
    <!-- Container-fluid starts-->
{{ $slot }}
<!-- Container-fluid Ends-->
</div>

<!-- latest jquery-->
<script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
<!-- feather icon js-->
<script src="{{ asset('assets/js/icons/feather-icon/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/icons/feather-icon/feather-icon.js') }}"></script>
<!-- Sidebar jquery-->
<script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
<script src="{{ asset('assets/js/config.js') }}"></script>
<!-- Bootstrap js-->
<script src="{{ asset('assets/js/bootstrap/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap/bootstrap.min.js') }}"></script>
<!-- Plugins JS start-->
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
<script src="{{ asset('assets/js/prism/prism.min.js') }}"></script>
<script src="{{ asset('assets/js/clipboard/clipboard.min.js') }}"></script>
<script src="{{ asset('assets/js/counter/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('assets/js/counter/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('assets/js/counter/counter-custom.js') }}"></script>
<script src="{{ asset('assets/js/custom-card/custom-card.js') }}"></script>
<script src="{{ asset('assets/js/datepicker/date-picker/datepicker.js') }}"></script>
<script src="{{ asset('assets/js/datepicker/date-picker/datepicker.en.js') }}"></script>
<script src="{{ asset('assets/js/datepicker/date-picker/datepicker.custom.js') }}"></script>
<script src="{{ asset('assets/js/owlcarousel/owl.carousel.js') }}"></script>
<script src="{{ asset('assets/js/general-widget.js') }}"></script>
<script src="{{ asset('assets/js/height-equal.js') }}"></script>
<script src="{{ asset('assets/js/tooltip-init.js') }}"></script>
<script src="{{ asset('assets/js/editor/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('assets/js/editor/ckeditor/adapters/jquery.js') }}"></script>
<script src="{{ asset('assets/js/editor/ckeditor/styles.js') }}"></script>
<!-- Plugins JS Ends-->
<!-- Theme js-->
<script src="{{ asset('assets/js/script.js') }}"></script>
<script> feather.replace() </script>
<script>
    // global formatter
    $(document).ready(function(e){
        //run the real time notification
        setInterval(function () {getRealTimeNotification()}, 30000);//request every x seconds

        // enter instead of tab
        $('form input').keydown(function (e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                return false;
            }
        });
        // month format
        var length = 0;
        $('.month-year-input').on('input',function (e){
            var count = $(this).val().length;
            if(length>(length=count)) return; // enable deleting
            if ($(this).val().length > 7) { $(this).val($(this).val().substr(0, 7));  } // cannot over length
            if(count == 2){ // add spacing
                $(this).focus().val(function( index, value ) { return value + " " ; });
            }
        });
        // date format
        $('.date-input').on('input',function (e){
            var count = $(this).val().length;
            if(length>(length=count)) return; //enable deleting
            if ($(this).val().length > 10) {
                $(this).val($(this).val().substr(0, 10));
            }
            if(count == 2 || count == 5){
                $(this).focus().val(function( index, value ) {
                    return value + "-" ;
                });
            }
        });
        // ic format
        $('.ic-no-input').on('input',function (e){
            var count = $(this).val().length;
            if(length>(length=count)) return; //enable deleting
            if ($(this).val().length > 13) {
                $(this).val($(this).val().substr(0, 13));
            }
            if(count == 6 || count == 9){
                $(this).focus().val(function( index, value ) {
                    return value + "-" ;
                });
            }
        });
    });

    function getRealTimeNotification(){
        $('#noti_box').html('');

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });
        $.ajax({
            type: "POST",
            url: "{{ route('admin.notification.refreshNotification') }}",
            data: {
            },
            success: function (result) {
                // $('#noti_box').empty();

                $('#noti_box').html(result);

                feather.replace();
            }
        });
    }
</script>
@include('admin.caseLists.partials.caseJs')
@stack('scripts')
<!-- Plugin used-->
<livewire:scripts />
</body>
</html>
