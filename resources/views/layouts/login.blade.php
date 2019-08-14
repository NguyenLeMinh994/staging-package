<!DOCTYPE html>
<html lang="en">
	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
		<title>
			TAporta - B2B Travel Network - Leading Portal in Indochina -  - Hotel Search
		</title>
		<meta name="description" content="Latest updates and statistic charts">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
		<!--begin::Web font -->
		<script src="{{asset('/asset/vendors/base/webfont.js')}}"></script>
		<script>
			WebFont.load({
				google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
				active: function() {
					sessionStorage.fonts = true;
				}
			});
		</script>
		<!--end::Web font -->
		<!--begin::Base Styles -->  
		<!--begin::Page Vendors -->
		<link href="{{asset('/asset/package/login/custom.login.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('/asset/vendors/base/vendors.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('/asset/package/base/style.bundle.css')}}" rel="stylesheet" type="text/css" />
		<!--end::Base Styles -->
		<link rel="shortcut icon" href="{{asset('/asset/package/media/img/logo/favicon.ico')}}" />
		<!--end::Base Styles -->
		<!--begin::Global Theme Bundle -->
		<script src="{{asset('/asset/vendors/base/vendors.bundle.js')}}" type="text/javascript"></script>
		<script src="{{asset('/asset/package/base/scripts.bundle.js')}}" type="text/javascript"></script>
		<!--end::Global Theme Bundle -->
	<head>
	<!-- begin::Body -->
	<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
			<!-- begin:: Page -->
			<div class="m-grid m-grid--hor m-grid--root m-page">
			<div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-1" id="m_login" style="background-image: url({{asset('/asset/package/media/img/bg.png')}}); background-position: 0 0; background-repeat: no-repeat; background-attachment: fixed;">
				<header>
					<div class="header-inner">
						<div class="logo-holder">
							<a href="/"><img src="{{asset('/asset/package/media/img/logo/taporta-logo.png')}}" alt="TAporta"></a>
						</div>
						@if(request()->route()->uri() == "login")
						<div class="nav-button-holder">
							<div class="nav-button vis-m"><span></span><span></span><span></span></div>
						</div>
						<div class="nav-holder">
							<nav>
								<ul>
									<li><a class="act-link">Not yet a Partner?</a></li>
									<li><a href="{{ url('/register') }}" class="act-link signup_link">Sign Up!</a></li>
									<li><a href="#" class="act-link language_link"><span><img src="{{asset('/asset/package/media/img/language/EN_US.png')}}" alt="EN_US"></span>&nbsp;&nbsp;English</a></li>
								</ul>
							</nav>
						</div>
						@endif
					</div>
				</header>
				@yield('body.content')
				<footer>
					<div class="footer-inner">
						<p class="footer-inner_info">Copyrights © 2014-2019 TAporta.com, Managed by Mekong Partners Pte Ltd. Company Registration: 201406833D.</p>
					</div>
				</footer>
			</div>
		</div>
	</body>
</html>
<!-- end::Body -->