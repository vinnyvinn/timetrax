<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <meta charset="utf-8"/>
    <title>TimeTrax | Administration</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <meta id="token" name="token" value="{{ csrf_token() }}"/>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('plugins/bootstrap-modal/css/bootstrap-modal.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('plugins/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}"/>

    <link href="{{ asset('plugins/uniform/css/uniform.default.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/fullcalendar.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/bootstrap-toastr/toastr.min.css') }}"/>

    <link href="{{ asset('plugins/bootstrap-daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('plugins/fullcalendar/fullcalendar.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('plugins/morris/morris.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('admin/pages/css/tasks.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/components-rounded.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/plugins.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/jquery-ui.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('admin/layout4/css/layout.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('admin/layout4/css/themes/light.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('admin/layout4/css/custom.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('plugins/select2/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/timepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
    @yield('header')
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}"/>
    <style>
        .ui-slider-handle--custom {
            line-height: 1.25em;
            width: 7% !important;
            height: 1.3em !important;
            text-align: center;
        }
    </style>
</head>
<body class="page-header-fixed page-sidebar-closed-hide-logo page-sidebar-fixed">
<div id="app">
<div class="overlay" id="loader" hidden><span class="fa fa-cog fa-4x fa-spin"></span><h5>Please Wait</h5></div>
<div class="errorDiv">

</div>
@include('partials.nav')
<!-- BEGIN CONTAINER -->
<div class="page-container">

@include('partials.sidebar')

<!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content" id="content">
            @yield('content')
        </div>
    </div>
    <!-- END CONTENT -->
</div>

{{--@include('partials.footer')--}}


<!--[if lt IE 9]>
<script src="{{ asset('plugins/respond.min.js') }}"></script>
<script src="{{ asset('plugins/excanvas.min.js') }}"></script>
<![endif]-->
<script src="{{ asset('plugins/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-migrate.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-toastr/toastr.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('plugins/jquery.blockui.min.js') }}"></script>
<script src="{{ asset('plugins/jquery.cokie.min.js') }}"></script>
<script src="{{ asset('plugins/uniform/jquery.uniform.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
<script src="{{ asset('plugins/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('scripts/metronic.js') }}"></script>
<script src="{{ asset('admin/layout4/scripts/layout.js') }}"></script>
<script src="{{ asset('admin/layout4/scripts/quick-sidebar.js') }}"></script>
<script src="{{ asset('admin/pages/scripts/tasks.js') }}"></script>
<script src="{{ asset('plugins/moment.min.js') }}"></script>
<script src="{{ asset('js/fullcalendar.min.js') }}"></script>
<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/select2/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js') }}"></script>
<script src="{{ asset('js/bootstrap-timepicker.min.js') }}"></script>
<script src="{{ asset('js/scripts.js') }}"></script>
<!-- <script src="{{ asset('js/sweetalert.min.js') }}"></script> -->
<script src="{{ asset('js/sweetalertAll.js') }}"></script>

<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.colVis.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src='http://maps.google.com/maps/api/js?sensor=false&libraries=places'></script>
<script src="js/locationpicker.jquery.js"></script>
<script>
    jQuery(document).ready(function() {
        Metronic.init(); // init metronic core componets
        Layout.init(); // init layout
        QuickSidebar.init(); // init quick sidebar
        Tasks.initDashboardWidget(); // init tash dashboard widget

        $('.slider').slider({
            min: $('.slider').data('min'),
            max: $('.slider').data('max'),
            step: $('.slider').data('step'),
            value: $('.slider').data('value'),
            animate: 'fast',
            create: function (event, ui) {
                $('.slider').children().text($('.slider').data('value')).parent().next().val($('.slider').data('value'));
            },
            slide: function (event, ui) {
                $(this).children().text(ui.value).parent().next().val(ui.value);
            }
        });
        $('.slider-range').slider({
            range: true,
            values: [1.2, 2.5],
            step: 0.1,
            min: 1,
            max: 5,
            create: function () {
                $('.slider-range').children().first().text($('.slider-range').slider('values')[0]).next().text($('.slider-range').slider('values')[1]);
                $('.slider-range').prev().val($('.slider-range').slider('values')[1]).prev().val($('.slider-range').slider('values')[0]);
            },
            slide: function (event, ui) {
                $(this).children().first().text(ui.values[0]).next().text(ui.values[1]);
                $(this).prev().val(ui.values[1]).prev().val(ui.values[0]);
            }
        });
        $('#setting-select').select2();
    });
</script>

@if(count($errors) > 0)
    <?php
    $displayErrors = "";
    foreach($errors->all() as $error)
    {
        $displayErrors .= $error . "<br>";
    }
    ?>

    <script>
        $(function() {
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "positionClass": "toast-top-right",
                "onclick": null,
                "showDuration": "1000",
                "hideDuration": "1000",
                "timeOut": "9000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            toastr['error']("{!! $displayErrors !!}");
        });
    </script>
@endif

@if(session()->has('flash_message'))
    <script>
        $(function() {
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "positionClass": "toast-top-right",
                "onclick": null,
                "showDuration": "1000",
                "hideDuration": "1000",
                "timeOut": "9000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            toastr['{{ session('flash_message_status') }}']("{!! session('flash_message') !!}");
        });
    </script>
    <script>
        $('body').on('click', 'td.warning input', function () {
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            }, function () {
                swal("Deleted!", "Your imaginary file has been deleted.", "success");
            });
        });
    </script>
@endif
@yield('footer')
<script type="text/javascript">
            setInterval(function () {
             console.log('we ready');
            }, 3000); 
</script>
</div>
</body>
</html>