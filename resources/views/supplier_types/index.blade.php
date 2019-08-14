@extends('layouts.master')

@section('body.content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
<!-- BEGIN: Subheader -->
	<div class="m-subheader ">
		<div class="d-flex align-items-center">
			<div class="mr-auto">
				<h3 class="m-subheader__title">
                    Supplier Type
				</h3>
			</div>
			<div>
				<a href="{{ URL::current() }}/create" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air">
					<span>
						<i class="la la-plus"></i>
						<span>
							New Record
						</span>
					</span>
				</a>
			</div>
		</div>
	</div>
	<!-- END: Subheader -->
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
		@if(session()->get('success'))
			<div class="m-alert m-alert--icon alert alert-success" role="alert">
				<div class="m-alert__icon">
					<i class="la la-check-circle"></i>
				</div>
				<div class="m-alert__text">
					{{ session()->get('success') }}
				</div>
				<div class="m-alert__close">
					<button type="button" class="close" data-close="alert" aria-label="Close">
					</button>
				</div>
			</div>
		@endif
		<div class="m-portlet m-portlet--mobile">
			<div class="m-portlet__body">
				<!--begin: Datatable -->
				<table class="table table-striped- table-bordered table-hover table-checkable" id="suppliertype_table">
					<thead>
						<tr>
							<th>
								Supplier Type ID
							</th>
							<th>
								Supplier Type Name
							</th>
							<th>
								Status
							</th>
							<th>
								Updated By
							</th>
							<th>
								Last Updated
							</th>
							<th>
								Actions
							</th>
						</tr>
					</thead>
					<tbody>
					<?php
					foreach($supplier as $v):
					?>
					<tr>
						<td>{{$v->st_id}}</td>
						<td>{{$v->st_name}}</td>
						<td>
							<?php 
								if($v->st_status=='actived')
									echo 1;
								else 
									echo 2;					
							?>
						</td>
						<td>{{$v->user_name}}</td>
						<td>{{$v->updated_at}}</td>
						<td>
							<a href="{{ route('supplier-type.edit', $v->st_id)}}" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit">
								<i class="la la-edit"></i>
							</a>
							<a href="javascript:void(0)" onclick="openDeleteModal('{{ $v->st_id }}')" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">
								<i class="la la-trash"></i>
							</a>
						</td>
                	</tr>
                	<?php endforeach;?>
					</tbody>
				</table>
			</div>
		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
	</div>
</div>
<!--begin::Delete Modal-->
<div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Delete Supplier Type</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<!--begin::Form-->
			<form id="delete_form" class="m-form m-form--state m-form--fit m-form--label-align-left" action=""  method="post">
				<div class="modal-body">
					<p>Are you sure you want to delete this supplier type ?</p>
						@csrf
						@method('DELETE')
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary m-btn m-btn--custom m-btn--bolder m-btn--uppercase">Yes</button>
					<button type="reset" class="btn btn-default m-btn m-btn--custom m-btn--bolder m-btn--uppercase" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	function openDeleteModal(id){
		let url = "{!! URL::current() !!}/"+id;
		$('#delete_form').attr('action', url);
		$("#delete_modal").modal();	
	}

	$(document).ready(function() {
		$("#suppliertype_table").DataTable({
			pageLength: 25,
			columnDefs: [{
				targets: -1,
				title: "Actions",
				orderable: !1,
			},{
				targets: 2,
				render: function(a, t, e, n) {
					var l = {
						1: {
							title: "Active",
							class: " m-badge--primary"
						},
						2: {
							title: "Inactive",
							class: " m-badge--danger"
						},
					};
					return void 0 === l[a] ? a : '<span class="m-badge ' + l[a].class + ' m-badge--wide">' + l[a].title + "</span>"
				}
			}]
		});
	});
</script>
<!--end:: Delete Modal-->
@endsection
