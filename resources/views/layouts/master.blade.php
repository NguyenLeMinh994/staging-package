<!DOCTYPE html>
<html lang="en">
	<!-- head: include css -->
	@include('layouts.head')
	<!-- foot: include js -->
	@include('layouts.foot')
	<!-- Begin::Body -->
	<?php 
		$aside_button = "";
		if (Session::has('aside_status'))
			$aside_button = Session::get('aside_status');
	?>
	<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default {{$aside_button}}">
		<!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page">
			<!-- header -->
			@include('layouts.navbar')		
			<!-- begin::Body -->
			<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
				@include('layouts.aside-menu')	

				@yield('body.content')
			</div>
			<!-- end::Body -->
			<!-- footer-->
			@include('layouts.footer')
		</div>
		<!-- end:: Page -->
	</body>
	<!-- end::Body -->
</html>
