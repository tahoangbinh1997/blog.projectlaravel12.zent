@extends('layouts.admin-temp')

@section('posts-active')
    active
@endsection

@section('posts')
    active
@endsection

@section('header')
<style type="text/css">
	button#post-detail,
	button#post-edit,
	button#post-delete {
		padding: 6px 10px;
	}
	#post-detail>i,
	#post-edit>i,
	#post-delete>i {
		height: 20px;
		display: inline-flex;
		justify-content: center;
		align-items: center;
		margin-right: 0px;
	}
	#post-edit>i,
	#post-delete>i {
		left: 1px;
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
		<h2><span class="fa fa-arrow-circle-o-left"></span> Quản Lý Bài Viết</h2><br><br><br>
		<a href="{{route('admin-posts-create')}}"><button type="button" class="btn btn-info" style="font-size: 15px;margin-bottom: 10px;border-radius: 5px;"><i class="glyphicon glyphicon-pencil"></i>Thêm mới bài viết</button></a>
	</div>
	<!-- END PAGE TITLE -->                

	<!-- PAGE CONTENT WRAPPER -->
	<div class="page-content-wrap">                

		<div class="row">
			<div class="col-md-12">

				<!-- START DEFAULT DATATABLE -->
				<div class="panel panel-default">
					<div class="panel-heading">                                
						<h3 class="panel-title">Danh sách bài viết</h3>
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
									<th>Title</th>
									<th>Thumbnail</th>
									<th>Description</th>
									<th>Category</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach($posts as $post)
									<tr>
										<td width="40px">{{$post->id}}</td>
										<td width="250px">{{$post->title}}</td>
										<td width="100px"><img width="150px" height="150px" src="{{asset('storage')}}/{{$post->thumbnail}}"></td>
										<td width="200px">{{$post->description}}</td>
										<td>
											@foreach($categories as $category)
												@if($category->id == $post->category_id)
													{{$category->name}}
												@endif
											@endforeach
										</td>
										<td align="center">
											<a href="{{route('admin-posts-show',$post->id)}}" title="Detail" data-toggle="tooltip"><button class="btn btn-info" id="post-detail" title="Detail"><i class="glyphicon glyphicon-folder-open"></i></button></a>
											<a href="{{route('admin-posts-edit',['id' => $post->id])}}" title="Edit" data-toggle="tooltip"><button class="btn btn-warning" id="post-edit" title="Edit"><i class="glyphicon glyphicon-edit"></i></button></a>
											<form action="" style="display: initial;" method="POST" id="form_delete_post">
												@csrf
												{{ method_field('PUT') }}
												<a href="#" data-id="{{$post->id}}" data-url="{{route('admin-posts-delete',['id'=>$post->id])}}" class="btn-delete" title="Delete" data-toggle="tooltip"><button class="btn btn-danger" id="post-delete" title="Delete"><i class="glyphicon glyphicon-trash"></i></button></a>
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

	<script type="text/javascript">
		@if (session('create_success'))
		$(document).ready(function() {
			Command: toastr["success"]("{{session('create_success')}}"),

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
		@endif
		@if (session('update_success'))
		$(document).ready(function() {
			Command: toastr["success"]("{{session('update_success')}}"),

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
		@endif
		@if (session('detail_show_error'))
		$(document).ready(function() {
			Command: toastr["warning"]("{{session('detail_show_error')}}"),

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
		@endif
		$(document).ready(function() {
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
								type: 'put',
								dataType: 'json',
								data: {
									_token: $('#form_delete_post input[name="_token"]').val(),
									_method: $('#form_delete_post input[name="_method"]').val(),
									id: button_id,
								},
							})
							.done(function(response) {
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
									window.location.href='{{route('admin-posts')}}'
								},1500)
							})
							.fail(function() {
								console.log("error");
							})
							.always(function() {
								console.log('complete');
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