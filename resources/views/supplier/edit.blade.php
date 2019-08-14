@extends('layouts.master')

@section('body.content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
	<div class="m-content">
		<!--Begin::Main Portlet-->
		<div class="m-portlet m-portlet--full-height">
			<!--begin: Portlet Head-->
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<h3 class="m-portlet__head-text">
							Supplier Management - Edit
						</h3>
					</div>
				</div>
			</div>
			<!--end: Portlet Head-->

			<!--begin: Portlet Body-->
			<div class="m-portlet__body m-portlet__body--no-padding">
				<!--begin: Form Wizard-->
				<div class="m-wizard m-wizard--4 m-wizard--brand" id="m_wizard">
					<div class="row m-row--no-padding">
						<div class="col-xl-3 col-lg-12 m--padding-top-20 m--padding-bottom-15">
							<!--begin: Form Wizard Head -->
							<div class="m-wizard__head">
								<!--begin: Form Wizard Nav -->
								<div class="m-wizard__nav">
									<div class="m-wizard__steps">
										<div class="m-wizard__step m-wizard__step--done" m-wizard-target="m_wizard_form_step_1">
											<div class="m-wizard__step-info">
												<a href="#" class="m-wizard__step-number">
													<span>
														<span>1</span>
													</span>
												</a>
												<div class="m-wizard__step-label">
													Supplier Details
												</div>
												<div class="m-wizard__step-icon">
													<i class="la la-check"></i>
												</div>
											</div>
										</div>
										<div class="m-wizard__step" m-wizard-target="m_wizard_form_step_2">
											<div class="m-wizard__step-info">
												<a href="#" class="m-wizard__step-number">
													<span>
														<span>2</span>
													</span>
												</a>
												<div class="m-wizard__step-label">
													Contact Information
												</div>
												<div class="m-wizard__step-icon">
													<i class="la la-check"></i>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!--end: Form Wizard Nav -->
							</div>
							<!--end: Form Wizard Head -->
						</div>
						<div class="col-xl-9 col-lg-12">
							<!--begin: Form Wizard Form-->
							<div class="m-wizard__form">
								<!--
									1) Use m-form--label-align-left class to alight the form input lables to the right
									2) Use m-form--state class to highlight input control borders on form validation
								-->
								<form class="m-form m-form--label-align-left- m-form--state" id="m_form">
									@method('PATCH')
									@csrf
									<!--begin: Form Body -->
									<div class="m-portlet__body m-portlet__body--no-padding">
										<!--begin: Form Wizard Step 1-->
										<div class="m-wizard__form-step m-wizard__form-step--current" id="m_wizard_form_step_1">
											<div class="m-form__section m-form__section--first">
												<div class="form-group m-form__group row topbottom-no-padding">
													<div class="col-lg-6 m-form__group-sub">
														<label class="col-form-label">Country</label>
                                                        <input type="text" class="form-control m-input" autocomplete="off" placeholder="Select Country Name" maxlength="255" value="{{$supplier->country_code}} - {{$supplier->country_name}}" disabled>
													</div>
													<div class="col-lg-6 m-form__group-sub">
														<label class="col-form-label">Region</label>
														<input type="text" class="form-control m-input" autocomplete="off" placeholder="Select Region Name" maxlength="255" value="{{$supplier->region_name}}" disabled>
													</div>
												</div>
												<div class="form-group m-form__group row topbottom-no-padding">
                                                    <div class="col-lg-6 m-form__group-sub">
                                                        <label class="col-form-label">Supplier Code</label>
                                                        <input type="text" class="form-control m-input" autocomplete="off" placeholder="Select Supplier Code" maxlength="255" value="{{$supplier->supplier_code}}" disabled>
                                                    </div>
													<div class="col-lg-6 m-form__group-sub">
														<label class="col-form-label">Supplier Name <span style="color:red">*</span></label>
														<input type="text" class="form-control m-input" name="supplier_name" placeholder="Enter Supplier Name" maxlength="50" value="{{$supplier->supplier_name}}">
													</div>
												</div>
												<div class="form-group m-form__group row topbottom-no-padding">
													<div class="col-lg-6 m-form__group-sub">
														<label class="col-form-label">Supplier Type <span style="color:red">*</span></label>
														<select class="form-control m-input" name="supplier_category">
															<option value="">Please select an option.</option>
															@foreach ($supplierType as $item)
															<option value="{{$item->st_id}}" {{$item->st_id==$supplier->st_id?'selected':''}}>{{$item->st_name}}</option>
															@endforeach
														</select>
													</div>
													<div class="col-lg-6 m-form__group-sub">
														<label class="col-form-label">Status</label>
														<div class="m-radio-inline">
															<label class="m-radio m-radio--solid m-radio--brand">
																<input type="radio" name="status" value="actived" {{$supplier->supplier_status=="actived"?'checked':''}}> Active
																<span></span>
															</label>
															<label class="m-radio m-radio--solid m-radio--brand">
																<input type="radio" name="status" value="inactived" {{$supplier->supplier_status=="inactived"?'checked':''}}> Inactive
																<span></span>
															</label>
														</div>
													</div>
												</div>
												<div class="form-group m-form__group row topbottom-no-padding">
													<div class="col-lg-6 m-form__group-sub">
														<label class="col-form-label">Address 1 <span style="color:red">*</span></label>
														<input type="text" class="form-control m-input" name="supplier_address_1" placeholder="Enter Address 1" maxlength="255" value="{{$supplier->supplier_address_1}}">
													</div>
													<div class="col-lg-6 m-form__group-sub">
														<label class="col-form-label">Address 2</label>
														<input type="text" class="form-control m-input" name="supplier_address_2" placeholder="Enter Address 2 (Optional)" maxlength="255" value="{{$supplier->supplier_address_2}}">
													</div>
												</div>
												<div class="form-group m-form__group row topbottom-no-padding">
													<div class="col-lg-6 m-form__group-sub">
														<label class="col-form-label">Phone <span style="color:red">*</span></label>
														<div class="input-group">
															<div class="input-group-prepend">
																<select class="select-country form-control m-input"></select>
															</div>
															<input type="text" class="form-control m-input input-phone" name="supplier_phone" id="supplier_phone" placeholder="Enter Phone" maxlength="25" value="{{$supplier->supplier_phone}}">
														</div>
													</div>
													<div class="col-lg-6 m-form__group-sub">
														<label class="col-form-label">Website</label>
														<input type="text" class="form-control m-input" name="supplier_web" placeholder="Enter Website (Optional)" maxlength="100" value="{{$supplier->supplier_web}}">
													</div>
												</div>
												<div class="form-group m-form__group row topbottom-no-padding">
													<div class="col-lg-6 m-form__group-sub">
														<label class="col-form-label">Facebook Page</label>
														<input type="text" class="form-control m-input" name="social_1" placeholder="Enter Facebook Page (Optional)" maxlength="100" value="{{$supplier->supplier_social_1}}">
													</div>
													<div class="col-lg-6 m-form__group-sub">
														<label class="col-form-label">Other Social Media Page</label>
														<input type="text" class="form-control m-input" name="social_2" placeholder="Enter Other Social Media Page (Optional)" maxlength="100" value="{{$supplier->supplier_social_2}}">
													</div>
												</div>
												<div class="form-group m-form__group row topbottom-no-padding">
													<div class="col-lg-12">
														<label class="col-form-label">Supplier Description</label>
                                                    <textarea class="form-control m-input" id="description" name="description" placeholder="Enter Supplier Description (Optional) 500 character" rows="5" cols="100" maxlength="500">{{$supplier->supplier_description}}</textarea>
													</div>
												</div>
											</div>
										</div>
										<!--end: Form Wizard Step 1-->
										
										<!--begin: Form Wizard Step 2-->
										<div class="m-wizard__form-step" id="m_wizard_form_step_2">
											<div class="m-form__section m-form__section--first">
												<div class="m-form__heading">
													<h3 class="m-form__heading-title">Contact Person (Sales/Business Development)</h3>
												</div>
												<div class="form-group m-form__group row topbottom-no-padding">
													<div class="col-lg-6 m-form__group-sub">
														<label class="col-form-label">First Name <span style="color:red">*</span></label>
														<input type="text" class="form-control m-input" name="contact1_firstname" id="contact1_firstname" placeholder="Enter First Name" maxlength="100" value="{{$contact[0]->contact_firstname}}">
													</div>
													<div class="col-lg-6 m-form__group-sub">
														<label class="col-form-label">Last Name <span style="color:red">*</span></label>
														<input type="text" class="form-control m-input" name="contact1_lastname" id="contact1_lastname" placeholder="Enter Last Name" maxlength="100" value="{{$contact[0]->contact_lastname}}">
													</div>
												</div>
												<div class="form-group m-form__group row topbottom-no-padding">
													<div class="col-lg-6 m-form__group-sub">
														<label class="col-form-label">Job Title <span style="color:red">*</span></label>
														<input type="text" class="form-control m-input" name="contact1_role" id="contact1_role" placeholder="Enter Role" maxlength="100" value="{{$contact[0]->contact_role}}">
													</div>
													<div class="col-lg-6 m-form__group-sub">
														<label class="col-form-label">Skype ID</label>
														<input type="text" class="form-control m-input" name="contact1_skype" id="contact1_skype" placeholder="Enter Skype ID" maxlength="50" value="{{$contact[0]->contact_skype}}">
													</div>
												</div>
												<div class="form-group m-form__group row topbottom-no-padding">
													<div class="col-lg-6 m-form__group-sub">
														<label class="col-form-label">Email <span style="color:red">*</span></label>
														<input type="email" class="form-control m-input" name="contact1_email" id="contact1_email" placeholder="Enter Email" maxlength="100" value="{{$contact[0]->contact_email}}">
													</div>
													<div class="col-lg-6 m-form__group-sub">
														<label class="col-form-label">Mobile <span style="color:red">*</span></label>
														<input type="text" class="form-control m-input input-phone" name="contact1_phone" id="contact1_phone" placeholder="Enter Mobile Phone" maxlength="25" value="{{$contact[0]->contact_phone}}">
													</div>
												</div>
												<div class="m-separator m-separator--dashed m-separator--lg"></div>
												<div class="m-form__heading">
													<h3 class="m-form__heading-title">Contact Person (Reservations/Operations)</h3>
												</div>
												<div class="form-group m-form__group row topbottom-no-padding">
													<div class="col-lg-6 m-form__group-sub">
														<label class="col-form-label">First Name <span style="color:red">*</span></label>
														<input type="text" class="form-control m-input" name="contact2_firstname" id="contact2_firstname" placeholder="Enter First Name" maxlength="100" value="{{$contact[1]->contact_firstname}}">
													</div>
													<div class="col-lg-6 m-form__group-sub">
														<label class="col-form-label">Last Name <span style="color:red">*</span></label>
														<input type="text" class="form-control m-input" name="contact2_lastname" id="contact2_lastname" placeholder="Enter Last Name" maxlength="100" value="{{$contact[1]->contact_lastname}}">
													</div>
												</div>
												<div class="form-group m-form__group row topbottom-no-padding">
													<div class="col-lg-6 m-form__group-sub">
														<label class="col-form-label">Job Title <span style="color:red">*</span></label>
														<input type="text" class="form-control m-input" name="contact2_role" id="contact2_role" placeholder="Enter Role" maxlength="100" value="{{$contact[1]->contact_role}}">
													</div>
													<div class="col-lg-6 m-form__group-sub">
														<label class="col-form-label">Skype ID</label>
														<input type="text" class="form-control m-input" name="contact2_skype" id="contact2_skype" placeholder="Enter Skype ID" maxlength="50" value="{{$contact[1]->contact_skype}}">
													</div>
												</div>
												<div class="form-group m-form__group row topbottom-no-padding">
													<div class="col-lg-6 m-form__group-sub">
														<label class="col-form-label">Email <span style="color:red">*</span></label>
														<input type="email" class="form-control m-input" name="contact2_email" id="contact2_email" placeholder="Enter Email" maxlength="100" value="{{$contact[1]->contact_email}}">
													</div>
													<div class="col-lg-6 m-form__group-sub">
														<label class="col-form-label">Mobile <span style="color:red">*</span></label>
														<input type="text" class="form-control m-input" name="contact2_phone" id="contact2_phone" placeholder="Enter Mobile Phone" maxlength="25" value="{{$contact[1]->contact_phone}}">
													</div>
												</div>
											</div>
										</div>
										<!--end: Form Wizard Step 2-->
									</div>
									<!--end: Form Body -->

									<!--begin: Form Actions -->
									<div class="m-portlet__foot m-portlet__foot--fit m--margin-top-40">
										<div class="m-form__actions">
											<div class="row">
												<div class="col-lg-6 m--align-left">
													<a href="#" class="btn btn-secondary m-btn m-btn--custom m-btn--icon" data-wizard-action="prev">
														<span>
															<i class="la la-arrow-left"></i>&nbsp;&nbsp;
															<span>Back</span>
														</span>
													</a>
												</div>
												<div class="col-lg-6 m--align-right">
													<a href="#" class="btn btn-primary m-btn m-btn--custom m-btn--icon" data-wizard-action="submit">
														<span>
															<i class="la la-check"></i>&nbsp;&nbsp;
															<span>Submit</span>
														</span>
													</a>
													<a href="#" class="btn btn-success m-btn m-btn--custom m-btn--icon" data-wizard-action="next">
														<span>
															<span>Continue</span>&nbsp;&nbsp;
															<i class="la la-arrow-right"></i>
														</span>
													</a>
												</div>
											</div>
										</div>
									</div>
									<!--end: Form Actions -->
								</form>
							</div>
							<!--end: Form Wizard Form-->
						</div>
					</div>
				</div>
				<!--end: Form Wizard-->
			</div>
			<!--end: Portlet Body-->
		</div>
		<!--End::Main Portlet-->
	</div>
</div>
<script src="{{asset('/asset/vendors/custom/cleave/cleave.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/asset/vendors/custom/cleave/cleave-phone.i18n.js')}}" type="text/javascript"></script>

<script>
    /* Phone Number Start */
    var code={CN:"86",ID:"62",JP:"81",KH:"855",KR:"82",LA:"856",MY:"60",PH:"63",SG:"65",TH:"66",TW:"886",VN:"84",MM:"95"};
    var selectCountry = $('.select-country');
    var supplierphone = "{!! substr ($supplier->supplier_phone ,0 ,strpos($supplier->supplier_phone,' '))!!}";
    var html = '';

    for (var i in code) {
        html += '<option value="+' + code[i] + '">' + i + '</option>';
    }

    selectCountry.html(html);
    selectCountry.val(supplierphone);

    var cleavePhone = new Cleave('.input-phone', {
        phone:           true,
        phoneRegionCode: '{!!$supplier->country_code!!}'
    });

    selectCountry.on('change', function () {
        cleavePhone.setPhoneRegionCode(this.value);
        cleavePhone.setRawValue(this.value);
        $('.input-phone').focus();
    });
    /* Phone Number End */

    /* Contact 1 on change Start */
    $("#contact1_firstname").on('change', function () {
        let contact2_firstname = $("#contact2_firstname").val();
        if (contact2_firstname.length <= 0)
            $("#contact2_firstname").val($("#contact1_firstname").val())
    });

    $("#contact1_lastname").on('change', function () {
        let contact2_lastname = $("#contact2_lastname").val();
        if (contact2_lastname.length <= 0)
            $("#contact2_lastname").val($("#contact1_lastname").val())
    });

    $("#contact1_role").on('change', function () {
        let contact2_role = $("#contact2_role").val();
        if (contact2_role.length <= 0)
            $("#contact2_role").val($("#contact1_role").val())
    });

    $("#contact1_skype").on('change', function () {
        let contact2_skype = $("#contact2_skype").val();
        if (contact2_skype.length <= 0)
            $("#contact2_skype").val($("#contact1_skype").val())
    });

    $("#contact1_email").on('change', function () {
        let contact2_email = $("#contact2_email").val();
        if (contact2_email.length <= 0)
            $("#contact2_email").val($("#contact1_email").val())
    });

    $("#contact1_phone").on('change', function () {
        let contact2_phone = $("#contact2_phone").val();
        if (contact2_phone.length <= 0)
            $("#contact2_phone").val($("#contact1_phone").val())
    });
    /* Contact 1 on change End */


	/* Wizard Start */
	var WizardDemo = function() {
		$("#m_wizard");
		var e, r, i = $("#m_form");
		return {
			init: function() {
				var n;
				$.validator.addMethod(
					"phone_regex",
					function(value, element) {
						if (/[0-9]+$/.test(value.trim()) && /[0-9]/.test(value.trim().substring(value.length-2))) {
							if (((value.trim().split(" ").length)-1) == 2){
								var re1 = new RegExp("\\(?\\+?([0-9]{3})\\)?([ .-]?)([0-9]{2,3})\\2([0-9]{2,3})");
								return this.optional(element) || re1.test(value);
							}
							else
							{
								var re2 = new RegExp("\\(?\\+?([0-9]{3})\\)?([ .-]?)([0-9]{2,3})\\2([0-9]{2,3})\\2([0-9]{2,3})");
								return this.optional(element) || re2.test(value);
							}
						}
						return this.optional(element);
					},
					"Please enter a valid phone number."
				);
				$("#m_wizard"), i = $("#m_form"), (r = new mWizard("m_wizard", {
					startStep: 1,
					manualStepForward: !0
				})).on("beforeNext", function(r) {
					!0 !== e.form() && r.stop()
				}), r.on("change", function(e) {
					mUtil.scrollTop()
				}), e = i.validate({
					ignore: ":hidden",
					rules: {
						country_suggest: {
							required: !0
						},
						country_id: {
							required: !0
						},
						country_name: {
							required: !0
						},
						region_suggest: {
							required: !0
						},
						region_id: {
							required: !0
						},
						supplier_name: {
							required: !0
						},
						supplier_category:{
							required:!0
						},
						supplier_address_1: {
							required: !0
						},
						supplier_phone: {
							required: !0,
							minlength: 10
						},
						contact1_firstname: {
							required: !0
						},
						contact1_lastname: {
							required: !0
						},
						contact1_role: {
							required: !0
						},
						contact1_email: {
							required: !0
						},
						contact1_phone: {
							required: !0,
							phone_regex: !0,
						},
						contact2_firstname: {
							required: !0
						},
						contact2_lastname: {
							required: !0
						},
						contact2_role: {
							required: !0
						},
						contact2_email: {
							required: !0
						},
						contact2_phone: {
							required: !0,
							phone_regex: !0,
						}
					},
					invalidHandler: function(e, r) {
						//mUtil.scrollTop(), 
						swal({
							title: "",
							text: "There are some errors in your submission. Please correct them.",
							type: "error",
							confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
						})
					},
					submitHandler: function(e) {}
				}), (n = i.find('[data-wizard-action="submit"]')).on("click", function(r) {
					//updating the CKEditor related fields, before performing Ajax Submit
					for (instance in CKEDITOR.instances) {
						CKEDITOR.instances[instance].updateElement();
					};
					r.preventDefault(), e.form() && (mApp.progress(n), i.ajaxSubmit({
						url: 		"{!!route('supplier.update', $supplier->supplier_id)!!}", 
						type: 		'POST',
						success: function(response) {
							console.log(response);
							mApp.unprogress(n); 
							if(response.error == false) {
								swal({
									title: "",
									text: response.message,
									type: "success",
									confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
								}).then(function() {
									window.location = "{!!URL::to('/')!!}/supplier";
								})
							}
							else{
								swal({
									title: "",
									html: response.message,
									type: "error",
									confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
								})
							}
						}
					}))
				})
			}
		}
	}();

	$(document).ready(function() {
		CKEDITOR.replace('description');
		WizardDemo.init();
	});
</script>
@endsection