<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Smartpanel</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="/cms/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="/cms/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="/cms/css/core.min.css" rel="stylesheet" type="text/css">
	<link href="/cms/css/components.css" rel="stylesheet" type="text/css">
	<link href="/cms/css/colors.css" rel="stylesheet" type="text/css">
	<link href="/cms/css/customize.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->
	@yield('css')

</head>

<body>

	<!-- Main navbar -->
	@include('admin.includes.header')
	<!-- /main navbar -->

	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main sidebar -->
			@include('admin.includes.sidebar')
			<!-- /main sidebar -->

			<!-- Main content -->
			<div class="content-wrapper">

				@yield('page-header')

						<!-- Content area -->
				<div class="content">
					@yield('content')
					@include('admin.includes.footer')
				</div>
				<!-- /content area -->

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->

	<!-- Core JS files -->
	<script type="text/javascript" src="/cms/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="/cms/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="/cms/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="/cms/js/plugins/loaders/blockui.min.js"></script>
	<script type="text/javascript" src="/cms/js/plugins/notifications/pnotify.min.js"></script>
	<script type="text/javascript" src="/cms/js/pages/components_notifications_pnotify.js"></script>
	<!-- /core JS files -->
	@yield('js')

	<script>
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
	</script>

	@if(Session::has('notify'))
		<script type="text/javascript">
			@foreach(Session::get('notify') as $notify)
			new PNotify({
				text: '{{ $notify['message'] }}',
				type: '{{ $notify['alert'] }}',
				addclass: 'alert alert-{{ $notify['alert'] }} alert-styled-right',
			});
			@endforeach
		</script>
	@endif
</body>
</html>