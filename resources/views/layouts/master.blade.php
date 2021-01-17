<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> @yield('title')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">

  <!--  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/icon.png') }}"> -->

  <!-- <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"> -->

  <link rel="stylesheet" href="{{ asset('assets/themes/limitless/css/icons/icomoon/styles.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  
  <link rel="stylesheet" href="{{ asset('assets/themes/limitless/css/core.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/themes/limitless/css/components.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/themes/limitless/css/colors.css') }}">
  <link href="{{ asset('assets/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('assets/plugins/bootstrap-toastr/toastr.min.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('assets/plugins/bootstrap-touchspin/bootstrap.touchspin.min.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('assets/plugins/fullcalendar/fullcalendar.css') }}" rel="stylesheet" type="text/css" />
  
  <link href="{{ asset('assets/plugins/fancybox/jquery.fancybox.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('assets/plugins/amcharts/plugins/export/export.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('assets/plugins/datepicker/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
  
  <!-- new theme -->
  <link rel="stylesheet" href="{{ asset('assets/new_theme/vendors/font-awesome/css/all.min.css') }}" type="text/css" />
  <link rel="stylesheet" href="{{ asset('assets/new_theme/vendors/css/vendor.bundle.base.css') }}" type="text/css" />
  <link rel="stylesheet" href="{{ asset('assets/new_theme/css/style.css') }}" type="text/css" />
  <link rel="shortcut icon" href="{{ asset('assets/new_theme/images/favicon.png') }}" />
  <link rel="stylesheet" href="{{ asset('assets/new_theme/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
  <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    
  <!-- jQuery 2.2.3 -->
  <script src="{{ asset('assets/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>

  <script src="{{ asset('assets/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('assets/plugins/jQueryUi/jquery-ui.min.js') }}" type="text/javascript"></script>
   

  {{--Start Page header level scripts--}}
  @yield('page-header-scripts')
  {{--End Page level scripts--}}

  <style>
  #chartdiv {
    width: 100%;
    height: 380px;
  }
  .swal2-modal {
    display: block !important;
  }
  </style>
</head>

<body class="">
  <!-- Main navbar -->

  <div class="container-scroller">
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="dashboard.php"><img
            src="{{ asset('assets/new_theme/images/logo-mini-largue2.jpeg') }}" alt="logo" /></a>

        <a class="navbar-brand brand-logo-mini" href="dashboard.php"><img
            src="{{ asset('assets/new_theme/images/logo-mini2.png') }}" alt="logo" /></a>
      </div>





      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="fas fa-align-justify"></span>
        </button>
        <ul class="navbar-nav mr-lg-2">
          
        </ul>
        <ul class="navbar-nav navbar-nav-right">
          
          
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="fas fa-align-justify"></span>
        </button>
      </div>
      </div>
      
      
      
    </nav>

    <div class="container-fluid page-body-wrapper">
        
        
        
      @include('left_menu.admin')

      <div class="main-panel">
        <div class="content-wrapper">
          <section class="">
            @if(Session::has('flash_notification.message'))
            <script>
            toastr. {
              {
                Session::get('flash_notification.level')
              }
            }('{{ Session::get("flash_notification.message") }}', 'Response Status')
            </script>
            @endif
            @if (isset($msg))
            <div class="alert alert-success">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              {{ $msg }}
            </div>
            @endif
            @if (isset($error))
            <div class="alert alert-error">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              {{ $error }}
            </div>
            @endif
            @if (count($errors) > 0)
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
            @endif

            @yield('content')
          </section>
        </div>

        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2020 <a
                href="https://www.t-cobro.com/" target="_blank">Tcobro Web</a>. Todos los derechos reservados.</span>
          </div>
        </footer>
      </div>
    </div>

    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}"
      type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.min.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/plugins/jquery-validation/additional-methods.min.js') }}" type="text/javascript">
    </script>
    <script>
    jQuery.validator.setDefaults({
      // Different components require proper error label placement
      ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
      errorClass: 'validation-error-label',
      successClass: 'validation-valid-label',
      highlight: function(element, errorClass) {
        $(element).removeClass(errorClass);
      },
      unhighlight: function(element, errorClass) {
        $(element).removeClass(errorClass);
      },
      errorPlacement: function(error, element) {

        // Styled checkboxes, radios, bootstrap switch
        if (element.parents('div').hasClass("checker") || element.parents('div').hasClass("choice") || element
          .parent().hasClass('bootstrap-switch-container')) {
          if (element.parents('label').hasClass('checkbox-inline') || element.parents('label').hasClass(
              'radio-inline')) {
            error.appendTo(element.parent().parent().parent().parent());
          } else {
            error.appendTo(element.parent().parent().parent().parent().parent());
          }
        }

        // Unstyled checkboxes, radios
        else if (element.parents('div').hasClass('checkbox') || element.parents('div').hasClass('radio')) {
          error.appendTo(element.parent().parent().parent());
        }

        // Input with icons and Select2
        else if (element.parents('div').hasClass('has-feedback') || element.hasClass(
            'select2-hidden-accessible')) {
          error.appendTo(element.parent());
        }

        // Inline checkboxes, radios
        else if (element.parents('label').hasClass('checkbox-inline') || element.parents('label').hasClass(
            'radio-inline')) {
          error.appendTo(element.parent().parent());
        }

        // Input group, styled file input
        else if (element.parent().hasClass('uploader') || element.parents().hasClass('input-group')) {
          error.appendTo(element.parent().parent());
        } else {
          error.insertAfter(element);
        }
      }
    });

    $('.delete').on('click', function (e) {
        e.preventDefault();
        var href = $(this).attr('href');
        swal({
            title: 'Are you sure?',
            text: '',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ok',
            cancelButtonText: 'Cancel'
        }).then(function () {
            window.location = href;
        })
    });

    </script>

    <script src="{{ asset('assets/plugins/moment/js/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"
      type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/bootstrap-touchspin/bootstrap.touchspin.min.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/plugins/tinymce/tinymce.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/fancybox/jquery.fancybox.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/jquery.numeric.js') }}"></script>

    <script src="{{ asset('assets/themes/limitless/js/plugins/loaders/pace.min.js') }}"></script>
    <script src="{{ asset('assets/themes/limitless/js/plugins/loaders/blockui.min.js') }}"></script>
    <script src="{{ asset('assets/themes/limitless/js/core/app.js') }}"></script>
    <script src="{{ asset('assets/themes/limitless/js/plugins/ui/ripple.min.js') }}"></script>
    <script src="{{ asset('assets/themes/limitless/js/plugins/forms/styling/uniform.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="{{ asset('assets/themes/limitless/js/plugins/tables/datatables/datatables.min.js') }}"></script>
    <!-- new theme -->
    <script src="{{ asset('assets/new_theme/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assets/new_theme/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/new_theme/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('assets/new_theme/js/template.js') }}"></script>
    <script src="{{ asset('assets/new_theme/js/settings.js') }}"></script>
    <script src="{{ asset('assets/new_theme/js/todolist.js') }}"></script>
    <!-- end -->

    @yield('footer-scripts')
    <!-- ChartJS 1.0.1 -->
    <script src="{{ asset('assets/themes/limitless/js/custom.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDJYGsppHU_r_BjvfYFw-lwaQsbPqVV2zw&language=en">
    </script>
    <script src="{{ asset('assets/new_theme/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/new_theme/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/new_theme/vendors/select2/select2.min.js') }}"></script>    
    <script src="{{ asset('assets/new_theme/js/data-table.js') }}"></script>
    
  <!-- Custom js for this page -->
<script src="{{ asset('assets/new_theme/js/formpickers.js') }}"></script>
<script src="{{ asset('assets/new_theme/js/form-addons.js') }}"></script>
<script src="{{ asset('assets/new_theme/js/x-editable.js') }}"></script>
<script src="{{ asset('assets/new_theme/js/dropify.js') }}"></script>
<script src="{{ asset('assets/new_theme/js/dropzone.js') }}"></script>
<script src="{{ asset('assets/new_theme/js/jquery-file-upload.js') }}"></script>
<!---<script src="{{ asset('assets/new_theme/js/formpickers.js') }}"></script>--->
<script src="{{ asset('assets/new_theme/js/form-repeater.js') }}"></script>
<script src="{{ asset('assets/new_theme/js/inputmask.js') }}"></script>
<script src="{{ asset('assets/new_theme/js/select2.js') }}"></script>
  <!-- endinject -->  
  </div>

</body>

</html>