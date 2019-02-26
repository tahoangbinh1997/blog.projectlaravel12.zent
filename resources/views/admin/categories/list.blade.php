@extends('layouts.admin-temp')

@section('categories-active')
    active
@endsection

@section('categories')
    active
@endsection

@section('header')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<style type="text/css">
	button#categories-detail,
	button#categories-edit,
	button#categories-delete {
		padding: 6px 10px;
	}
	#categories-detail>i,
	#categories-edit>i,
	#categories-delete>i {
		height: 20px;
		display: inline-flex;
		justify-content: center;
		align-items: center;
		margin-right: 0px;
	}
	#categories-edit>i,
	#categories-delete>i {
		left: 1px;
	}
	#category_detail_name,
	#category_detail_slug,
	#category_detail_description,
	#category_detail_created_at,
	#category_detail_updated_at {
		margin: 15px 00px 0px 0px;
	}
	#category_add_description,
	#category_edit_description {
		resize: none;
		height: 100px;
	}
</style>
@endsection
@section('content')

	<!-- START BREADCRUMB -->
	<ul class="breadcrumb">
		<li><a href="{{asset('')}}admin/home">Home</a></li>
		<li class="active">Quản lý bài viết</li>
	</ul>

	<!-- END BREADCRUMB -->
	<!-- PAGE TITLE -->
	<div class="page-title">                    
		<h2><span class="fa fa-arrow-circle-o-left"></span> Quản Lý Thể Loại</h2><br><br><br>
		<a data-toggle="modal" href="#category_add"><button type="button" class="btn btn-info" style="font-size: 15px;margin-bottom: 10px;border-radius: 5px;"><i class="glyphicon glyphicon-pencil"></i>Thêm mới category</button></a>
	</div>
	<!-- END PAGE TITLE -->                

	<!-- PAGE CONTENT WRAPPER -->
	<div class="page-content-wrap">                

		<div class="row">
			<div class="col-md-12">

				<!-- START DEFAULT DATATABLE -->
				<div class="panel panel-default">
					<div class="panel-heading">                                
						<h3 class="panel-title">Danh sách các categories</h3>
						<ul class="panel-controls">
							<li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
							<li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
							<li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
						</ul>                                
					</div>
					<div class="panel-body">
						<table class="table datatable" id="data-table">
							<thead>
								<tr>
									<th>Id</th>
									<th>Name</th>
									<th>Slug</th>
									<th>Created_at</th>
									<th>Update_at</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach($categories as $category)
									<tr>
										<td width="40px">{{$category->id}}</td>
										<td width="200px">{{$category->name}}</td>
										<td width="200px">{{$category->slug}}</td>
										<td>
											@php
		                                    $date = new DateTime($category->created_at); // tạo biến mới để đổi kiểu thời gian mặc định của csdl
		                                    $month_num = $date->format('m'); //lấy ra tháng
		                                    $convert_month = DateTime::createFromFormat('!m',$month_num); //convert tháng sang kiểu chữ
		                                    @endphp
		                                    {{$convert_month->format('F')}} {{$date->format('d')}}, {{$date->format('Y')}}<br> {{$date->format('H:i:s')}}
										</td>
										<td>
											@php
		                                    $date = new DateTime($category->updated_at); // tạo biến mới để đổi kiểu thời gian mặc định của csdl
		                                    $month_num = $date->format('m'); //lấy ra tháng
		                                    $convert_month = DateTime::createFromFormat('!m',$month_num); //convert tháng sang kiểu chữ
		                                    @endphp
		                                    {{$convert_month->format('F')}} {{$date->format('d')}}, {{$date->format('Y')}}<br> {{$date->format('H:i:s')}}
										</td>
										<td align="center">
											<a href="#category_detail" class="btn-detail" data-url="{{route('admin-categories-show',$category->id)}}" data-toggle="modal" title="Detail"><button class="btn btn-info" id="categories-detail" title="Detail" data-toggle="tooltip"><i class="glyphicon glyphicon-folder-open"></i></button></a>
											<a href="#category_edit" class="btn-edit" update_url="{{route('admin-categories-update',['id' => $category->id])}}" data-url="{{route('admin-categories-edit',['id' => $category->id])}}" title="Edit" data-toggle="modal"><button class="btn btn-warning" data-toggle="tooltip" id="categories-edit" title="Edit"><i class="glyphicon glyphicon-edit"></i></button></a>
											<form style="display: initial;" method="POST" id="form_delete_category">
												@csrf
												{{ method_field('delete') }}
												<a href="#" class="btn-delete" data-id="{{$category->id}}" data-url="{{route('admin-categories-destroy',$category->id)}}" title="Delete" data-toggle="tooltip"><button class="btn btn-danger" id="categories-delete" title="Delete"><i class="glyphicon glyphicon-trash"></i></button></a>
											</form>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
				<!-- END DEFAULT DATATABLE -->

			</div>
		</div>                                

	</div>
	<!-- PAGE CONTENT WRAPPER -->                                

	{{-- MODAL category DETAIL --}}
	<div class="modal fade" id="category_detail">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Thẻ category: </h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<span class="label label-info" style="font-size: 12px;font-weight: bold;margin-right: 50px;">Tên thẻ loại:</span>
						<h5 id="category_detail_name"></h5>
					</div>
					<div class="form-group">
						<span class="label label-info" style="font-size: 12px;font-weight: bold;margin-right: 50px;">Slug:</span>
						<h5 id="category_detail_slug"></h5>
					</div>
					<div class="form-group">
						<span class="label label-info" style="font-size: 12px;font-weight: bold;margin-right: 50px;">Mô tả thể lại:</span>
						<h5 id="category_detail_description"></h5>
					</div>
					<div class="form-group">
						<span class="label label-info" style="font-size: 12px;font-weight: bold;margin-right: 50px;">Ngày tạo:</span>
						<h5 id="category_detail_created_at"></h5>
					</div>
					<div class="form-group">
						<span class="label label-info" style="font-size: 12px;font-weight: bold;margin-right: 50px;">Ngày cập nhật:</span>
						<h5 id="category_detail_updated_at"></h5>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
				</div>
			</div>
		</div>
	</div>
	{{-- END MODAL category DETAIL --}}

	{{-- MODAL category ADD --}}
	<div class="modal fade" id="category_add">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Thẻ category: </h4>
				</div>
				<div class="modal-body">
					<form action="" id="form_add_category" data-url="{{route('admin-categories-store')}}" method="POST" role="form">
						@csrf
						<legend>Thêm mới thẻ category</legend>
						<div class="form-group">
							<label for="">Tên thể loại:</label>
							<input type="text" name="name" class="form-control" id="category_add_name" placeholder="Mời nhập vào nội dung">
						</div>
						<div class="form-group">
							<label for="">Mô tả thể loại:</label>
							<textarea name="description" class="form-control" id="category_add_description" placeholder="Mời nhập vào nội dung"></textarea>
						</div>
						<input type="submit" name="category_add_submit" class="btn btn-primary" value="Thêm mới">
						<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	{{-- END MODAL category ADD --}}
	<div class="modal fade" id="category_edit">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Thẻ category: </h4>
				</div>
				<div class="modal-body">
					<form action="" id="form_edit_category" method="POST" role="form">
						@csrf
						{{ method_field('put') }}
						<legend>Cập nhật thông tin thẻ category</legend>
						<div class="form-group">
							<label for="">Tên thể loại:</label>
							<input type="text" name="name" class="form-control" id="category_edit_name" placeholder="Mời nhập vào nội dung">
						</div>
						<div class="form-group">
							<label for="">Mô tả thể loại:</label>
							<textarea type="text" name="name" class="form-control" id="category_edit_description" placeholder="Mời nhập vào nội dung"></textarea>
						</div>
						<input type="submit" name="category_edit_submit" class="btn btn-primary" value="Cập nhật">
						<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	{{-- MODAL category EDIT --}}
@endsection

@section('footer')
	<!-- THIS PAGE PLUGINS -->
	<script type='text/javascript' src='{{asset('')}}admin_assets/js/plugins/icheck/icheck.min.js'></script>
	<script type="text/javascript" src="{{asset('')}}admin_assets/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>

	<script type="text/javascript" src="{{asset('')}}admin_assets/js/plugins/datatables/jquery.dataTables.min.js"></script>    
	<script type="text/javascript" src="{{asset('')}}admin_assets/js/plugins/bootstrap/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="{{asset('')}}admin_assets/js/plugins/bootstrap/bootstrap-timepicker.min.js"></script>
	<script type="text/javascript" src="{{asset('')}}admin_assets/js/plugins/bootstrap/bootstrap-colorpicker.js"></script>
	<!-- END PAGE PLUGINS -->
	
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			$('.btn-detail').on('click', function(event) {
				var url = $(this).data('url');
				$.ajax({
					url: url,
					type: 'GET',
				})
				.done(function(response) {
					console.log(response)
					$('h5#category_detail_name').text(response.data.name);
					$('h5#category_detail_slug').text(response.data.slug);
					$('h5#category_detail_description').text(response.data.description);
					$('h5#category_detail_created_at').text(response.data.created_at);
					$('h5#category_detail_updated_at').text(response.data.updated_at);
					Command: toastr["success"](response.detail_success),

					toastr.options = {
						"closeButton": false,
						"debug": false,
						"newestOnTop": false,
						"progressBar": false,
						"positionClass": "toast-top-right",
						"preventDuplicates": false,
						"onclick": null,
						"showDuration": "300",
						"hideDuration": "1000",
						"timeOut": "5000",
						"extendedTimeOut": "1000",
						"showEasing": "swing",
						"hideEasing": "linear",
						"showMethod": "fadeIn",
						"hideMethod": "fadeOut"
					}
				})
				.fail(function() {
					console.log("error");
				})
				.always(function() {
					console.log("complete");
				});

			});

			$('#form_add_category').submit(function(event){
				event.preventDefault();
				var url=$(this).data('url');

				$.ajax({
					url: url,
					type: 'POST',
					data: {
						name: $('input#category_add_name').val(),
						description: $('textarea#category_add_description').val(),
						category_add_submit: $('input[name="category_add_submit"]').val(),
					},
				})
				.done(function(response) {
					console.log("success");
					if(response.errors){
						$.each(response.errors, function(index, val) {
							Command: toastr["warning"](val),

							toastr.options = {
								"closeButton": false,
								"debug": false,
								"newestOnTop": false,
								"progressBar": false,
								"positionClass": "toast-top-right",
								"preventDuplicates": false,
								"onclick": null,
								"showDuration": "300",
								"hideDuration": "1000",
								"timeOut": "5000",
								"extendedTimeOut": "1000",
								"showEasing": "swing",
								"hideEasing": "linear",
								"showMethod": "fadeIn",
								"hideMethod": "fadeOut"
							}
						});

					}else{
						console.log(response.data);
						Command: toastr["success"](response.create_success),

						toastr.options = {
							"closeButton": false,
							"debug": false,
							"newestOnTop": false,
							"progressBar": false,
							"positionClass": "toast-top-right",
							"preventDuplicates": false,
							"onclick": null,
							"showDuration": "300",
							"hideDuration": "1000",
							"timeOut": "5000",
							"extendedTimeOut": "1000",
							"showEasing": "swing",
							"hideEasing": "linear",
							"showMethod": "fadeIn",
							"hideMethod": "fadeOut"
						}

						setTimeout(function(){
							window.location.href='{{route('admin-categories')}}';
						},1500)
					}
				})
				.fail(function(response) {
					console.log("error");
				})
				.always(function() {
					console.log("complete");
				});
				
			});

			$('.btn-edit').click(function(event) {
				var url = $(this).data('url');
				var update_url = $(this).attr('update_url');

				$.ajax({
					url: url,
					type: 'GET',
				})
				.done(function(response) {
					console.log("success");
					$('input#category_edit_name').val(response.data.name);
					$('textarea#category_edit_description').text(response.data.description);

					Command: toastr["success"](response.edit_display),

					toastr.options = {
						"closeButton": false,
						"debug": false,
						"newestOnTop": false,
						"progressBar": false,
						"positionClass": "toast-top-right",
						"preventDuplicates": false,
						"onclick": null,
						"showDuration": "300",
						"hideDuration": "1000",
						"timeOut": "5000",
						"extendedTimeOut": "1000",
						"showEasing": "swing",
						"hideEasing": "linear",
						"showMethod": "fadeIn",
						"hideMethod": "fadeOut"
					}
					$('#form_edit_category').attr('data-url',update_url);
				})
				.fail(function() {
					console.log("error");
				})
				.always(function() {
					console.log("complete");
				});
				
			});

			$('#form_edit_category').submit(function(event){
				event.preventDefault();
				var url = $(this).data('url');
				$.ajax({
					url: url,
					type: 'PUT',
					data: {
						name: $('#form_edit_category input#category_edit_name').val(),
						description: $('#form_edit_category textarea#category_edit_description').val(),
						_token: $('#form_edit_category input[name="_token"]').val(),
						_method: $('#form_edit_category input[name="_method"]').val(),
						category_edit_submit: $('#form_edit_category input[name="category_edit_submit"]').val(),
					},
				})
				.done(function(response) {
					console.log("success");
					if(response.errors){
						$.each(response.errors, function(index, val) {
							Command: toastr["warning"](val),

							toastr.options = {
								"closeButton": false,
								"debug": false,
								"newestOnTop": false,
								"progressBar": false,
								"positionClass": "toast-top-right",
								"preventDuplicates": false,
								"onclick": null,
								"showDuration": "300",
								"hideDuration": "1000",
								"timeOut": "5000",
								"extendedTimeOut": "1000",
								"showEasing": "swing",
								"hideEasing": "linear",
								"showMethod": "fadeIn",
								"hideMethod": "fadeOut"
							}
						});
					}else{
						console.log(response.data);
						Command: toastr["success"](response.update_success),

						toastr.options = {
							"closeButton": false,
							"debug": false,
							"newestOnTop": false,
							"progressBar": false,
							"positionClass": "toast-top-right",
							"preventDuplicates": false,
							"onclick": null,
							"showDuration": "300",
							"hideDuration": "1000",
							"timeOut": "5000",
							"extendedTimeOut": "1000",
							"showEasing": "swing",
							"hideEasing": "linear",
							"showMethod": "fadeIn",
							"hideMethod": "fadeOut"
						}

						setTimeout(function(){
							window.location.href='{{route('admin-categories')}}';
						},1500)
					}
				})
				.fail(function() {
					console.log("error");
				})
				.always(function() {
					console.log("complete");
				});
				
			});

			$('.btn-delete').click(function(event){
				event.preventDefault();
				var button_url=$(this).data('url');
				var button_id=$(this).data('id');
				Swal({
					title: 'Bạn có chắc là muốn xóa?',
					text: "Bạn chắc là muốn xóa bản ghi này chứ!",
					type: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					cancelButtonText: 'Không xóa!',
					confirmButtonText: 'Xóa!'
				}).then((result) => {
					if (result.value) {
						Swal(
							'Xóa bài viết thành công!',
							'Bài viết sẽ được chuyển vào phần bài viết đã bị xóa',
							'success'
							)
						$('button.swal2-confirm').on('click', function(event) {
							$.ajax({
								url: button_url,
								type: 'delete',
							})
							.done(function(response) {
								if (response.delete_success) {
									Command: toastr["warning"](""+response.delete_success+""),

									toastr.options = {
										"closeButton": false,
										"debug": false,
										"newestOnTop": false,
										"progressBar": false,
										"positionClass": "toast-top-right",
										"preventDuplicates": false,
										"onclick": null,
										"showDuration": "300",
										"hideDuration": "1000",
										"timeOut": "5000",
										"extendedTimeOut": "1000",
										"showEasing": "swing",
										"hideEasing": "linear",
										"showMethod": "fadeIn",
										"hideMethod": "fadeOut"
									}

									setTimeout(function(){
										window.location.href='{{route('admin-categories')}}'
									},1500)
								}
								if (response.delete_errors) {
									Command: toastr["warning"](""+response.delete_errors+""),

									toastr.options = {
										"closeButton": false,
										"debug": false,
										"newestOnTop": false,
										"progressBar": false,
										"positionClass": "toast-top-right",
										"preventDuplicates": false,
										"onclick": null,
										"showDuration": "300",
										"hideDuration": "1000",
										"timeOut": "5000",
										"extendedTimeOut": "1000",
										"showEasing": "swing",
										"hideEasing": "linear",
										"showMethod": "fadeIn",
										"hideMethod": "fadeOut"
									}
								}
							})
							.fail(function() {
								console.log("error");
							})
							.always(function() {
								console.log('complete')
							});
							
						});
					}
				})
			})
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#data-table').DataTable( {
				"order": [[ 0, "desc" ]]
			} );
		} );
	</script>
@endsection