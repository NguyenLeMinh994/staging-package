@extends('layouts.master')

@section('body.content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
<!-- BEGIN: Subheader -->
	<div class="m-subheader ">
		<div class="d-flex align-items-center">
			<div class="mr-auto">
				<h3 class="m-subheader__title">
					User Management
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
				<table class="table table-striped- table-bordered table-hover table-checkable" id="user_table">
					<thead>
						<tr>
							<th>
								User Code
							</th>
							<th>
								User Name
							</th>
							<th>
								First Name
							</th>
							<th>
								Last Name
							</th>
							<th>
								Supplier
							</th>
							<th>
								Supplier Type
							</th>
							<th>
								User Type
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
					foreach($user as $v):
					?>
					<tr>
						<td>{{$v->user_code}}</td>
						<td>{{$v->username}}</td>
						<td>{{$v->first_name}}</td>
						<td>{{$v->last_name}}</td>
						<td>{{$v->supplier_name}}</td>
						<td>{{$v->st_name}}</td>
						<td>{{$v->role=='admin'?'1':'2'}}</td>
						<td>{{$v->user_status=='actived'?'1':'2'}}</td>
						<td>{{$v->uid=='0'?'SuperAdmin':$v->user_name}}</td>
						<td>{{$v->updated_at}}</td>
						<td>
							<span class="dropdown">
								<a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
									<i class="la la-ellipsis-h"></i>
								</a>
									<div class="dropdown-menu dropdown-menu-right">
										<a class="dropdown-item" href="{{ route('user.edit', $v->id)}}">
											<i class="la la-edit"></i> Edit Record
										</a>
										<a class="dropdown-item" href="javascript:void(0)" onclick="openDeleteModal('{{ $v->id }}')" >
											<i class="la la-trash"></i> Delete Record
										</a>
									</div>
							</span>
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
				<h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<!--begin::Form-->
			<form id="delete_form" class="m-form m-form--state m-form--fit m-form--label-align-left" action=""  method="post">
				<div class="modal-body">
					<p>Are you sure you want to delete this user ?</p>
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

<script type="text/javascript">
	function openDeleteModal(id){
		let url = "{!! URL::current() !!}/"+id;
		$('#delete_form').attr('action', url);
		$("#delete_modal").modal();	
	}

	$(document).ready(function() {
		$("#user_table").DataTable({
			pageLength: 25,
			columnDefs: [{
				targets: -1,
				title: "Actions",
				orderable: !1,
			},{
                targets: 6,
                render: function(a, t, e, n) {
                    var l = {
                        1: {
                            title: "Admin",
                            state: "danger"
                        },
                        2: {
                            title: "User",
                            state: "primary"
                        }
                    };
                    return void 0 === l[a] ? a : '<span class="m-badge m-badge--' + l[a].state + ' m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-' + l[a].state + '">' + l[a].title + "</span>"
                }
            },{
				targets: 7,
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
@endsection