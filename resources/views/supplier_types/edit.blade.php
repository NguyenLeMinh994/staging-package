@extends('layouts.master')

@section('body.content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
	<!-- BEGIN: Subheader -->
	<div class="m-subheader ">
		<div class="d-flex align-items-center">
			<div class="mr-auto">
				<h3 class="m-subheader__title">
                    Supplier Type - Edit
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
		<div class="row">
			<div class="col-md-6">
				<div class="m-portlet m-portlet--mobile">
					<!--begin::Form-->
					<form id="supplier_edit_form" class="m-form m-form--state m-form--fit m-form--label-align-left" method="post" action="{{ route('supplier-type.update', $supplierType->st_id) }}">
                        <script>
							function redirectBaseURL() {
								window.location = "{!!URL::to('/')!!}/supplier-type";
							}

							$(function() {
								$("#supplier_edit_form").validate({
									rules: {
										st_name :{
											required: true
										},
										st_status :{
											required: true
										}
									},
									submitHandler: function(e) {
										return true
									}
								})
							});
                        </script>
                        <div class="m-portlet__body">
                            @method('PATCH')
                            @csrf
							<div class="form-group m-form__group row">
								<label for="st_name" class="col-4 col-form-label">Supplier Type Name <span style="color:red">*</span></label>
								<div class="col-8">
									<input type="text" class="form-control m-input" id="st_name" name="st_name" placeholder="Enter Supplier Type" maxlength="35" value="{{$supplierType->st_name}}">
								</div>
							</div>
							<div class="form-group m-form__group row">
								<label class="col-4 col-form-label">Status <span style="color:red">*</span></label>
								<div class="col-8">
									<select class="form-control m-input" name="st_status">
										<option value="">Please select an option.</option>
										<option value="actived" <?php if ( $supplierType->st_status=='actived') echo 'selected'?>>Active</option>
										<option value="inactived" <?php if ( $supplierType->st_status=='inactived') echo 'selected'?>>Inactive</option>
									</select>
								</div>
							</div>
						</div>	
						<div class="m-portlet__foot m-portlet__foot--fit">
							<div class="m-form__actions">
								<div class="row">
									<div class="col-md-6 col-4"></div>
									<div class="col-md-6 col-8">
										<button type="submit" class="btn btn-primary m-btn m-btn--custom m-btn--bolder m-btn--uppercase">Submit</button>
										<button type="reset" class="btn btn-default m-btn m-btn--custom m-btn--bolder m-btn--uppercase" onclick="redirectBaseURL()">Cancel</button>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!--end::Form-->
</div>
@endsection