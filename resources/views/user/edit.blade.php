@extends('layouts.master')

@section('body.content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
	<!-- BEGIN: Subheader -->
	<div class="m-subheader ">
		<div class="d-flex align-items-center">
			<div class="mr-auto">
				<h3 class="m-subheader__title">
					User Management - Edit
				</h3>
			</div>
		</div>
	</div>
	<!-- END: Subheader -->
	
	<!--begin::Form Content-->
	<div class="m-content">
		@if (count($errors) > 0)
		<div class="m-alert m-alert--icon alert alert-danger">
			<div class="m-alert__icon">
				<i class="la la-times-circle"></i>
			</div>
			<div class="m-alert__text">
				<strong>Whoops!</strong> There were some problems with your input.
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
			<div class="m-alert__close">
				<button type="button" class="close" data-close="alert" aria-label="Close">
				</button>
			</div>
		</div>
		@endif
		<div class="m-portlet m-portlet--mobile">
			<!--begin::Form-->
			<form id="user_edit_form" class="m-form m-form--state m-form--fit m-form--label-align-right" method="post" action="{{ route('user.update', $user[0]->id) }}">
				<script>
					function redirectBaseURL() {
						window.location = "{!!URL::to('/')!!}/user";
					}

					$(function() {
						$("#user_edit_form").validate({
							rules: {
								user_lastname :{
									required: !0
								},
								user_firstname :{
									required: !0
								},
								user_phone :{
									required: !0,
								},
								user_password :{
									required: !0,
									pattern: /^(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,30}$/,
								},
								user_password_retype :{
									required: !0,
									equalTo: "[name=user_password]"
								},
								user_type :{
									required: !0
								},
								user_securitycode :{
									required: !0
								},
								user_status :{
									required: !0
								}
							},
							messages: {
								user_password: {
									pattern : "Your password must including 1 uppercase letter, 1 special character, alphanumeric characters and minimum is 8 characters"
								}
							},
							invalidHandler: function(e, r) {
								
							},
							submitHandler: function(e) {
								return true;
							}
						});
					});
				</script>
				<div class="m-portlet__body">
					@method('PATCH')
                    @csrf
					<div class="form-group m-form__group row">
						<label class="col-4 col-form-label">Supplier Type <span style="color:red">*</span></label>
						<div class="col-6">
							<input type="text" class="form-control m-input" placeholder="Select Supplier Name" maxlength="255" role="textbox" aria-autocomplete="list" maxlength="100" value="{{$user[0]->st_name}}" disabled>
						</div>
					</div>
					<div class="form-group m-form__group row">
						<label for="supplier_suggest" class="col-4 col-form-label">Supplier Name <span style="color:red">*</span></label>
						<div class="col-6">
                            <input type="text" class="form-control m-input" placeholder="Select Supplier Name" maxlength="255" role="textbox" aria-autocomplete="list" maxlength="100" value="{{$user[0]->supplier_name}}" disabled>
						</div>
					</div>
					<div class="form-group m-form__group row">
						<label class="col-4 col-form-label">User Code <span style="color:red"><span style="color:red">*</span></span></label>
						<div class="col-6">
							<input type="text" class="form-control m-input" placeholder="Enter Users Code" maxlength="20" value="{{$user[0]->user_code}}" disabled>
						</div>
                    </div>
                    <div class="form-group m-form__group row">
						<label class="col-4 col-form-label">User Name <span style="color:red">*</span></label>
						<div class="col-6">
							<input type="text" class="form-control m-input" placeholder="Enter Users Name" maxlength="20" value="{{$user[0]->username}}" disabled>
						</div>
					</div>
                    <div class="form-group m-form__group row">
						<label class="col-4 col-form-label">First Name <span style="color:red">*</span></label>
						<div class="col-6">
							<input type="text" class="form-control m-input" name="user_firstname" placeholder="Enter Users First Name" maxlength="20" value="{{$user[0]->first_name}}">
						</div>
					</div>
					<div class="form-group m-form__group row">
						<label class="col-4 col-form-label">Last Name <span style="color:red">*</span></label>
						<div class="col-6">
							<input type="text" class="form-control m-input" name="user_lastname" placeholder="Enter Users First Name" maxlength="20" " value="{{$user[0]->last_name}}">
						</div>
					</div>
					<div class="form-group m-form__group row">
						<label class="col-4 col-form-label">Phone <span style="color:red">*</span></label>
						<div class="col-6">
							<div class="input-group">
								<div class="input-group-prepend">
									<select class="select-country form-control m-input"></select>
								</div>
								<input type="text" class="form-control m-input input-phone" name="user_phone" id="user_phone" placeholder="Enter Phone" maxlength="20" value="{{$user[0]->phone}}"> 
							</div>
						</div>
					</div>
					<div class="form-group m-form__group row">
						<label class="col-4 col-form-label">Email <span style="color:red">*</span></label>
						<div class="col-6">
							<input type="email" class="form-control m-input" name="user_email" placeholder="Enter Email" maxlength="50" value="{{$user[0]->email}}" disabled>
						</div>
					</div>
                    <div class="form-group m-form__group row">
						<label class="col-4 col-form-label">Password <span style="color:red">*</span></label>
						<div class="col-6">
							<input type="password" id="inputPassword" name="user_password" class="form-control m-input" name="user_password" placeholder="Enter Password" maxlength="32">
						</div>
					</div>
					<div class="form-group m-form__group row">
						<label class="col-4 col-form-label">Password Again <span style="color:red">*</span></label>
						<div class="col-6">
							<input type="password" class="form-control m-input" name="user_password_retype" placeholder="Enter Password Again" maxlength="32">
						</div>
					</div>
                    <div class="form-group m-form__group row">
						<label class="col-4 col-form-label">User Type <span style="color:red">*</span></label>
						<div class="col-6">
							<select class="form-control m-input" name="user_type">
								<option value="">Please select a option</option>
                                <option value="admin" {{$user[0]->role=='admin'?'selected':''}}>Admin</option>
                                <option value="user" {{$user[0]->role=='user'?'selected':''}}>User</option>
                            </select>
						</div>
					</div>
					<div class="form-group m-form__group row">
						<label class="col-4 col-form-label">Status <span style="color:red">*</span></label>
						<div class="col-6">
							<select class="form-control m-input" name="user_status">
                                <option value="">Please select a status</option>
                                <option value="actived" {{$user[0]->user_status=='actived'?'selected':''}}>Active</option>
                                <option value="inactived" {{$user[0]->user_status=='inactived'?'selected':''}}>Inactive</option>
                            </select>
						</div>
					</div>
				</div>	
				<div class="m-portlet__foot m-portlet__foot--fit">
					<div class="m-form__actions">
						<div class="row">
							<div class="col-4"></div>
							<div class="col-6">
								<button type="submit" class="btn btn-primary m-btn m-btn--custom m-btn--bolder m-btn--uppercase">Submit</button>
								<button type="reset" class="btn btn-default m-btn m-btn--custom m-btn--bolder m-btn--uppercase" onclick="redirectBaseURL()">Cancel</button>
							</div>
						</div>
					</div>
				</div>
			</form>
			<!--end::Form-->
		</div>
	</div>
</div>
<script src="{{asset('/asset/vendors/custom/cleave/cleave.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/asset/vendors/custom/cleave/cleave-phone.i18n.js')}}" type="text/javascript"></script>
<script>
	$(function() {
		/* Phone Number Start */
		var code={CN:"86",ID:"62",JP:"81",KH:"855",KR:"82",LA:"856",MY:"60",PH:"63",SG:"65",TH:"66",TW:"886",VN:"84"};
		var selectCountry = $('.select-country');
		var userphone = "{!! substr ($user[0]->phone ,0 ,strpos($user[0]->phone,' '))!!}";
        var html = '';

		for (var i in code) {
			html += '<option value="+' + code[i] + '">' + i + '</option>';
		}

		selectCountry.html(html);
		selectCountry.val(userphone);


		var cleavePhone = new Cleave('.input-phone', {
			phone:           true,
			phoneRegionCode: '{!!$user[0]->country_code!!}'
		});

		selectCountry.on('change', function () {
			cleavePhone.setPhoneRegionCode(this.value);
			cleavePhone.setRawValue(this.value);
			$('.input-phone').focus();
		});
		/* Phone Number End */
	});
</script>
@endsection