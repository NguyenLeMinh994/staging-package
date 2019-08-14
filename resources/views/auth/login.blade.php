@extends('layouts.login')
@section('body.content')
<!-- css custom login -->
<div class="m-grid__item m-grid__item--fluid m-login__wrapper cus-m-login__wrapper">
	<div class="m-grid__item m-grid__item--fluid m-wrapper">
		<div class="m-content">
			<div class="row">
				<div class="col-lg-5">
					<!--Begin::login box-->
					<div class="m-login__container cus_login_box">
						<div class="m-login__signin">
							<div class="m-login__head">
								<h3 class="m-login__title">Sign In</h3>
							</div>
							<form class="m-login__form m-form" method="POST" action="{{ route('login') }}">
								@csrf
								@if(session()->has('login_error'))
									<div class="alert alert-danger">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="padding-top:3px"></button>
										{{ session()->get('login_error') }}
									</div>
								@endif
								<div class="form-group m-form__group">
									<input class="form-control m-input {{ $errors->has('email') ? ' is-invalid' : '' }}" type="email" placeholder="Please Enter Your Email" name="identity" value="{{ old('identity') }}" autocomplete="off">
								</div>
								<div class="form-group m-form__group">
									<input class="form-control m-input {{ $errors->has('password') ? ' is-invalid' : '' }} m-login__form-input--last" type="password" placeholder="Please Enter Your Password" name="password">
								</div>
								<div class="form-group m-form__group" style="text-align:right;font-size:10.5pt; font-weight:500">
									<a href="#" class="m-link" id="m_login_forget_password" style="padding-top:20px">
										<span>Forgot Your Password ?</span>
									</a>
								</div>
								<!---begin::action--->
								<div class="m-login__form-action" style="text-align:right">
									<a href="#">
										<button id="m_login_signin_submit" class="btn btn-primary m-btn--bolder m-btn--uppercase m-btn--wide" style="width:50%">Login</button>
									</a>
								</div>
							</form>
						</div>
						<div class="m-login__forget-password">
							<div class="m-login__head">
								<h3 style="text-align:left;">Locked Out or Lost Password?</h3>
								<div class="m-login__desc" style="text-align:left;color:#212529">Enter your login email. A link to reset your password will be sent to your registered email address.</div>
							</div>
							<form class="m-login__form m-form" method="POST">
								@csrf
								<div class="form-group m-form__group">
									<input type="email" class="form-control m-input {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Please Enter Your Email" id="email" name="email" value="{{ old('email') }}" autocomplete="off">
								</div>
								<div class="m-login__form-action" style="text-align:right;">
									<button id="m_login_forget_password_submit" class="btn btn-primary m-btn m-btn--bolder m-btn--uppercase m-btn--wide m-btn--custom m-btn--air">Request</button>&nbsp;&nbsp;
									<button id="m_login_forget_password_cancel" class="btn btn-outline-primary m-btn m-btn--bolder m-btn--uppercase m-btn--wide m-btn--custom">Cancel</button>
								</div>
							</form>
						</div>
					</div>
					<!-- End Login Box -->
				</div>
				<div class="col-lg-7">
					<!--Cotent::right-->
					<div class="m-grid__item m-grid__item--order-tablet-and-mobile-2 m-grid m-grid--hor m-login__aside cus_content_box">
						<div class="m-grid__item">
							<p class="m-login__new" style="margin-top:13px;"><span>New!</span></p>
							<h3 class="m-login__welcome">Attract more bookings with Package Plus +</h3>
							<p class="m-login__msg">Our new supplier tools customize and distribute your products in a <b>fast, easy</b> and <b>effective</b> way!</p>
						</div>
					</div>
					<!--EndCotent::right-->
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var SnippetLogin = function() {
		var e = $("#m_login"),
			i = function(e, i, a) {
				var l = $('<div class="alert alert-' + i + ' alert-dismissible" role="alert">\t\t\t<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>\t\t\t<span></span>\t\t</div>');
				e.find(".alert").remove(), l.prependTo(e), mUtil.animateClass(l[0], "fadeIn animated"), l.find("span").html(a)
			},
			a = function() {
				e.removeClass("m-login--forget-password"), e.removeClass("m-login--signup"), e.addClass("m-login--signin"), mUtil.animateClass(e.find(".m-login__signin")[0], "flipInX animated")
			},
			l = function() {
				$("#m_login_forget_password").click(function(i) {
					i.preventDefault(), e.removeClass("m-login--signin"), e.removeClass("m-login--signup"), e.addClass("m-login--forget-password"), mUtil.animateClass(e.find(".m-login__forget-password")[0], "flipInX animated")
				}), $("#m_login_forget_password_cancel").click(function(e) {
					e.preventDefault(), a();
				})
			};
		return {
			init: function() {
				l(), $("#m_login_signin_submit").click(function(e) {
					e.preventDefault();
					var a = $(this),
						l = $(this).closest("form");
					l.validate({
						rules: {
							identity: {
								required: !0,
								email: !0
							},
							password: {
								required: !0
							}
						},
						messages: {
							identity: {
								required: "Please enter your email"
							},
							password: {
								required: "Please enter your password"
							}
						},
					}), l.valid() && (l.submit())
				}), $("#m_login_forget_password_submit").click(function(l) {
					l.preventDefault();
					var t = $(this),
						r = $(this).closest("form");
					r.validate({
						rules: {
							email: {
								required: !0,
								email: !0
							}
						}
					}), r.valid() && (t.addClass("m-loader m-loader--right m-loader--light").attr("disabled", !0), r.ajaxSubmit({
						url: "{{ route('password.email') }}",
						success: function(l, s, n, o) {
							setTimeout(function() {
								t.removeClass("m-loader m-loader--right m-loader--light").attr("disabled", !1), r.clearForm(), r.validate().resetForm(), a();
								var l = e.find(".m-login__signin form");
								l.clearForm(), l.validate().resetForm(), i(l, "danger", "An email with instructions to reset your password has been sent.")
							}, 2e3)
						}
					}))
				})
			}
		}
	}();

	//Opent button on mobile view
	var nb = $(".nav-button");
	var nh = $(".nav-holder");
	// mobile menu ------------------
	function showMenu() {
		nb.removeClass("vis-m");
		nh.slideDown(500);
	}
	function hideMenu() {
		nb.addClass("vis-m");
		nh.slideUp(500);
	}
	nb.on("click", function() {
		if ($(this).hasClass("vis-m")) showMenu(); else hideMenu();
	});
		

	$(document).ready(function() {
		SnippetLogin.init();
	});
</script>
@endsection	