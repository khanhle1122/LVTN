<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="description" content="Responsive HTML Admin Dashboard Template based on Bootstrap 5">
	<meta name="author" content="NobleUI">
	<meta name="keywords" content="nobleui, bootstrap, bootstrap 5, bootstrap5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<title>Quản Lý dự án xây dựng</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

	<!-- Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
	<!-- End fonts -->

	<!-- core:css -->
	{{-- <link rel="stylesheet" href="{{ asset('frontend/style.css') }}"> --}}
	<link rel="stylesheet" href="{{ asset('assets/vendors/core/core.css') }}">
	<!-- endinject -->
	<!-- jQuery (Toastr cần jQuery) -->

	<!-- Plugin css for this page -->
	<link rel="stylesheet" href="{{ asset('assets/vendors/flatpickr/flatpickr.min.css') }}">
	<!-- End plugin css for this page -->

	<!-- Datatables CSS -->
	<link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css') }}">
  
	<!-- inject:css -->
	<link rel="stylesheet" href="{{ asset('assets/fonts/feather-font/css/iconfont.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
	<!-- endinject -->

	<!-- Plugin css for this page -->
	<link rel="stylesheet" href="{{ asset('assets/vendors/select2/select2.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/vendors/jquery-tags-input/jquery.tagsinput.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/vendors/dropzone/dropzone.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/vendors/dropify/dist/dropify.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/vendors/pickr/themes/classic.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}">
	<!-- End plugin css for this page -->
   
	<!-- Layout styles -->  
	<link rel="stylesheet" href="{{ asset('assets/css/demo1/style.css') }}">
	<!-- End layout styles -->

	<link rel="shortcut icon" href="{{ asset('assets/images/favicon.svg') }}" />
</head>
<body>
	<div class="main-wrapper">
		<!-- Trong blade layout -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
		<!-- Sidebar and navbar -->
		@include('admin.body.sidebar')
		<div class="page-wrapper">
			@include('admin.body.header')

			<!-- Main content -->
			@yield('admin')
		</div>
	</div>

	<!-- core:js -->
	<script src="{{ asset('assets/vendors/core/core.js') }}"></script>
	<!-- endinject -->

	<!-- Plugin js for this page -->
	<script src="{{ asset('assets/vendors/flatpickr/flatpickr.min.js') }}"></script>
	<script src="{{ asset('assets/vendors/apexcharts/apexcharts.min.js') }}"></script>
	<!-- End plugin js for this page -->

	<!-- inject:js -->
	<script src="{{ asset('assets/vendors/feather-icons/feather.min.js') }}"></script>
	<script src="{{ asset('assets/js/template.js') }}"></script>
	<!-- endinject -->

	<!-- Custom js for this page -->
	<script src="{{ asset('assets/js/dashboard-dark.js') }}"></script>
	<script src="{{ asset('assets/js/data-table.js') }}"></script>

	<!-- Plugin js for this page -->
	<script src="{{ asset('assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
	<script src="{{ asset('assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js') }}"></script>
	<script src="{{ asset('assets/vendors/jquery-validation/jquery.validate.min.js') }}"></script>
	<script src="{{ asset('assets/vendors/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
	<script src="{{ asset('assets/vendors/inputmask/jquery.inputmask.min.js') }}"></script>
	<script src="{{ asset('assets/vendors/select2/select2.min.js') }}"></script>
	<script src="{{ asset('assets/vendors/typeahead.js/typeahead.bundle.min.js') }}"></script>
	<script src="{{ asset('assets/vendors/jquery-tags-input/jquery.tagsinput.min.js') }}"></script>
	<script src="{{ asset('assets/vendors/dropzone/dropzone.min.js') }}"></script>
	<script src="{{ asset('assets/vendors/dropify/dist/dropify.min.js') }}"></script>
	<script src="{{ asset('assets/vendors/pickr/pickr.min.js') }}"></script>
	<script src="{{ asset('assets/vendors/moment/moment.min.js') }}"></script>
	<script src="{{ asset('assets/vendors/flatpickr/flatpickr.min.js') }}"></script>
	<!-- End plugin js for this page -->

	<!-- Custom js for this page -->
	<script src="{{ asset('assets/js/form-validation.js') }}"></script>
	<script src="{{ asset('assets/js/bootstrap-maxlength.js') }}"></script>
	<script src="{{ asset('assets/js/inputmask.js') }}"></script>
	<script src="{{ asset('assets/js/select2.js') }}"></script>
	<script src="{{ asset('assets/js/typeahead.js') }}"></script>
	<script src="{{ asset('assets/js/tags-input.js') }}"></script>
	<script src="{{ asset('assets/js/dropzone.js') }}"></script>
	<script src="{{ asset('assets/js/dropify.js') }}"></script>
	<script src="{{ asset('assets/js/pickr.js') }}"></script>
	<script src="{{ asset('assets/js/flatpickr.js') }}"></script>
	<!-- End custom js for this page -->

	<script>
		@if(Session::has('message'))
			var type = "{{ Session::get('alert-type', 'info') }}";
			var message = "{!! Session::get('message') !!}";
			switch(type){
				case 'info':
					toastr.info(message);
					break;
				case 'success':
					toastr.success(message);
					break;
				case 'warning':
					toastr.warning(message);
					break;
				case 'error':
					toastr.error(message);
					break;
			}
		@endif
	</script>
		 
		
</body>
</html>
