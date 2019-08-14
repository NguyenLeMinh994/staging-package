@extends('layouts.login')
@section('body.content')
<div class="m-grid__item m-grid__item--fluid m-login__wrapper cus-m-login__wrapper">
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <div class="m-content">
            <div class="row">
                <div class="col-lg-12">
                    <!--Begin::login box-->
                    <div class="m-pwd-recovery__container cus_login_box">
                        <div class="m-login__signin">
                            <div class="m-login__head">
                                <h3 class="m-login__title">Password Recovery</h3>
                            </div>
                            <form class="m-pwd-recovery__form m-form" method="POST" action="{{ route('password.update') }}" id="password_reset_form">
                                @csrf
                                @if(session()->has('status'))
									<div class="alert alert-success">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="padding-top:3px"></button>
										{{ session()->get('status') }}
									</div>
								@endif
                                <div class="m-form__heading">
                                    <h3 class="m-form__heading-title" style="font-size:1.2rem">Please create a new password for your account.</h3>
                                </div>
                                <div class="form-group m-form__group">
                                    <label for="password">New Password<span style="color:red">*</span></label>
                                    <span class="m-form__helper-customize">Minimum 8 characters.</span>
                                    <input type="password" id="password" name="password" class="form-control m-input m-login__form-input {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Please Enter Your New Password" maxlength="30" required>
                                    @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group m-form__group">
                                    <label for="confirm_password">Confirm New Password<span style="color:red">*</span></label>
                                    <input type="password" id="confirm_password" name="password_confirmation" class="form-control {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }} m-input m-login__form-input--last" placeholder="Please Confirm Your New Password" maxlength="30" required>
                                    @if ($errors->has('password_confirmation'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <input type="hidden" value="{{ urldecode(request()->get('email')) }}" name="email">
                                <input type="hidden" name="token" value="{{ $token }}">
                                <!---begin::action--->
                                <div class="m-login__form-action" style="text-align:right">
                                    <a href="#">
                                        <button type="submit" class="btn btn-primary m-btn--bolder m-btn--uppercase m-btn--wide" style="width:50%">Confirm</button>
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- End Login Box -->
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $("#password_reset_form").validate({
            rules: {
                email: {
                    required: !0,
                },
                password: {
                    required: !0,
                    pattern: /^(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,30}$/,
                },
                password_confirmation: {
                    required: !0,
                    equalTo: "[name=password]",
                }
            },
            messages: {
                password: {
                    pattern : "Your password must including 1 uppercase letter, 1 special character, alphanumeric characters"
                }
            },
            invalidHandler: function(e, t) {
                swal({
                    title: "",
                    text: "There are some errors in your submission.",
                    type: "error",
                    confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                })
            }
        });
    });
    </script>
@endsection