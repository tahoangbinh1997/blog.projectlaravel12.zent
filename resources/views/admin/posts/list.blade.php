@extends('layouts.admin-temp')

@section('header')
	<title>Quản lý Bài viết</title>
	<link rel="stylesheet" href="{{asset('admin_assets/assets/css/lib/datatable/dataTables.bootstrap.min.css')}}">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">​
	<style type="text/css">
		.sorting_1 {
			text-align: right;
		}
		.child ul li {
			list-style-type: none;
			border-bottom: 1px solid black;
			padding-bottom: 8px;
		}
		.child>ul>li:not(:first-child) {
			padding-top: 8px;
		}
		.label-info {
		    background-color: #5bc0de;
		    border-radius: 5px;
		}
		.bootstrap-tagsinput {
		    background-color: #fff;
		    border: 1px solid #ccc;
		    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
		    display: inline-block;
		    padding: 4px 6px;
		    color: #555;
		    vertical-align: middle;
		    border-radius: 4px;
		    max-width: 100%;
		    line-height: 22px;
		    cursor: text;
		}
		.bootstrap-tagsinput .tag {
			margin-right: 2px;
			color: white;
		}
		.label {
		    display: inline;
		    padding: .2em .6em .3em;
		    font-size: 75%;
		    font-weight: 700;
		    line-height: 1;
		    color: #fff;
		    text-align: center;
		    white-space: nowrap;
		    vertical-align: baseline;
		    border-radius: .25em;
		}
		.red-alert {
			border: 1px solid red !important;
		}
	</style>
@endsection

@section('active1')
	active
@endsection

@section('content')
	<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Quản Lý Bài Viết</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="{{asset('')}}">Dashboard</a></li>
                            <li><a class="active">Quản Lý Bài Viết</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content mt-3">
            <div class="animated">
                <div class="row">

                	<div class="col-md-12">
                		<div class="card">
                			<div class="card-header">
                				<strong class="card-title">Bài Viết</strong>
                			</div>
                			<div class="card-body">
                				<table id="bootstrap-data-table" class="table table-striped table-bordered">
                					<thead>
                						<tr>
                							<th>Id</th>
                							<th>Title</th>
                							<th>Image</th>
                							<th>Description</th>
                							<th width="50px">Category_Name</th>
                							<th>Tag_Name</th>
                							<th>Action</th>
                						</tr>
                					</thead>
                					<div class="modal fade" id="scrollmodal-show" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
                						<div class="modal-dialog modal-lg" role="document">
                							<div class="modal-content">
                								<div class="modal-header">
                									<h5 class="modal-title" id="scrollmodalLabel">Bài viết</h5>
                									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                										<span aria-hidden="true">&times;</span>
                									</button>
                								</div>
                								<div class="modal-body">
                									<h3>Tiêu đề: </h3><span id="title_detail"></span>
                									<h3>Ảnh: </h3><img id="thumbnail_detail" width="300px" height="300px">
                									<h3>Mô tả: </h3><textarea name="description_detail" id="description_detail" class="description_detail"></textarea>
                									<h3>Slug: </h3><span id="slug_detail"></span>
                									<h3>Nội dung chính: </h3><br><textarea name="content_detail" id="content_detail"></textarea>
                									<h3>Số lượt truy cập: </h3><span id="view_count_detail"></span>
                									<h3>Tạo ngày: </h3><span id="created_at_detail"></span>
                									<h3>Thể loại: </h3><span id="category_detail"></span>
                									<h3>Thẻ tags: </h3><br>
                									<select name="tags_detail" id="tags_detail" class="form-control" multiple data-role="tagsinput"></select>
                								</div>
                								<div class="modal-footer">
                									<button type="button" class="btn btn-primary" data-dismiss="modal">Confirm</button>
                								</div>
                							</div>
                						</div>
                					</div>
                					<div class="modal fade" id="scrollmodal-edit" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
                						<div class="modal-dialog modal-lg" role="document">
                							<div class="modal-content">
                								<div class="modal-header">
                									<h5 class="modal-title" id="scrollmodalLabel">Bài viết</h5>
                									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                										<span aria-hidden="true">&times;</span>
                									</button>
                								</div>
                								<div class="modal-body">
                									<form id="form_edit" method="POST" enctype="multipart/form-data" role="form">
                										<div class="card">
									                      <div class="card-body card-block">
									                        <div class="form-group"><label for="title_update" class=" form-control-label">Tiêu đề</label><input type="text" name="title_update" id="title_update" placeholder="Điền tiêu đề" class="form-control"></div>
									                      	<p class="mess_title_update" style="color: red"></p>
									                        <div class="form-group"><label for="thumbnail_update" class=" form-control-label">Ảnh</label><input type="file" name="thumbnail_update" id="thumbnail_update" class="form-control"></div>
									                        <div class="form-group"><label for="description_update" class=" form-control-label">Mô tả</label><textarea name="description_update" id="description_update" class="description_update" class="form-control"></textarea></div>
									                      	<p class="mess_description_update" style="color: red"></p>
									                        <div class="form-group"><label for="slug_update" class=" form-control-label">Slug(giống title, không giấu và các từ cách nhau bằng dấu '-')</label><input name="slug_update" id="slug_update" placeholder="Điền slug" class="form-control"/></div>
									                      	<p class="mess_slug_update" style="color: red"></p>
									                        <div class="form-group"><label for="content_update" class=" form-control-label">Nội dung chính</label><textarea name="content_update" id="content_update" class="content_update" placeholder="Điền nội dung chính" class="form-control"></textarea></div>
									                      	<p class="mess_content_update" style="color: red"></p>
									                        <div class="form-group"><label for="content_update" class=" form-control-label">Thể loại</label><select name="category_update" id="category_update" class="form-control"></select></div>
									                        <div class="form-group"><label for="tags_update" class=" form-control-label">Thẻ tags</label><br><select name="tags_update" id="tags_update" class="form-control" multiple data-role="tagsinput"></select></div>
									                      	<p class="mess_tags_update" style="color: red"></p>
									                      </div>
									                    </div>
									                    <div class="modal-footer">
		                									<button type="submit" class="btn btn-primary">Confirm</button>
		                								</div>
                									</form>
                								</div>
                							</div>
                						</div>
                					</div>
                				</table>
                			</div>
                		</div>
                	</div>


                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
@endsection

@section('footer')
	<script src="{{asset('admin_assets/assets/js/lib/data-table/datatables.min.js')}}"></script>
	<script src="https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js" type="text/javascript"></script>
    <script src="{{asset('admin_assets/assets/js/lib/data-table/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('admin_assets/assets/js/lib/data-table/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('admin_assets/assets/js/lib/data-table/buttons.bootstrap.min.js')}}"></script>
    <script src="{{asset('admin_assets/assets/js/lib/data-table/jszip.min.js')}}"></script>
    <script src="{{asset('admin_assets/assets/js/lib/data-table/pdfmake.min.js')}}"></script>
    <script src="{{asset('admin_assets/assets/js/lib/data-table/vfs_fonts.js')}}"></script>
    <script src="{{asset('admin_assets/assets/js/lib/data-table/buttons.html5.min.js')}}"></script>
    <script src="{{asset('admin_assets/assets/js/lib/data-table/buttons.print.min.js')}}"></script>
    <script src="{{asset('admin_assets/assets/js/lib/data-table/buttons.colVis.min.js')}}"></script>
    <script src="{{asset('admin_assets/assets/js/lib/data-table/datatables-init.js')}}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>

    <script type="text/javascript">
    	$.ajaxSetup({
    		headers: {
    			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		}
    	});
    	$(function() {
    		$('#bootstrap-data-table').DataTable({
        		autoWidth: false,
                processing: true,
                serverSide: true,
                destroy: true,
                searching: true,
                ajax: '{!! route('getListPost') !!}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'title', name: 'title' },
                    { data: 'thumbnail', name: 'thumbnail' },
                    { data: 'description', name: 'description' },
                    { data: 'category_name', name: 'category_name' },
                    { data: 'tag_name', name: 'tag_name' },
                    { data: 'action', name: 'action' }
                ],
                responsive: {
		            details: {
		                type: 'column',
		                data: 'Array'
		            }
		        },
		        columnDefs: [ {
		            className: 'control',
		            orderable: false,
		            targets:   0
		        } ],
		        order: [ 0, 'asc' ]
            });
    	});
        
    </script>

    <script type="text/javascript">
    	CKEDITOR.replace('description_detail');
    	CKEDITOR.replace('content_detail');
		$(document).on('click', '.btn-detail', function(event) {
			var url = $(this).attr('data-url');
    			$.ajax({
    				type: 'get',
    				url: url,
    				success: function(response) {
    					console.log(response);
    					$('span#title_detail').text(response.data.title);
    					$('img#thumbnail_detail').attr('src','../storage/images/'+response.data.thumbnail+'');
						$('span#description_detail').text(response.data.description);
						$('span#slug_detail').text(response.data.slug);
						CKEDITOR.instances.description_detail.insertHtml(response.data.description);
						CKEDITOR.instances.description_detail.setReadOnly();
						CKEDITOR.instances.content_detail.insertHtml(response.data.content);
						CKEDITOR.instances.content_detail.setReadOnly();
						$('span#view_count_detail').text(response.data.view_count);
						$('span#created_at_detail').text(response.data.created_at);
						$('span#category_detail').text(response.data1.name);
						$('select#tags_detail').tagsinput('removeAll');
						for (var i = 0; i < response.data2.length; i++) {
							$('select#tags_detail').tagsinput('add', response.data2[i].name, {preventPost: true});
						}
    				},
    				error: function (jqXHR, textStatus, errorThrown) {
						//xử lý lỗi tại đây
					}
				})
		});
	</script>
	<script type="text/javascript">
    	CKEDITOR.replace('description_update');
    	CKEDITOR.replace('content_update');
		$(document).on('click', '.btn-update', function(event) {
			var url = $(this).attr('data-url');
    			$.ajax({
    				type: 'get',
    				url: url,
    				success: function(response) {
    					console.log(response);
    					$('input#title_update').val(response.data.title);
						CKEDITOR.instances.description_update.insertHtml(response.data.description);
						$('input#slug_update').val(response.data.slug);
						CKEDITOR.instances.content_update.insertHtml(response.data.content);
						$('select#category_update option').remove();
						for (var i = 0; i < response.data3.length; i++) {
							$('select#category_update').append(new Option(response.data3[i].name, response.data3[i].name));
							$('select#category_update').find('option[value='+response.data3[i].name+']').attr('data-id', i+1);
						}
						$("select#category_update option[value="+response.data1.name+"]").attr("selected","selected");
						$('form#form_edit').attr('data-url','http://blog.projectlaravel12.zent/admin-home/manager-posts/'+response.data.id+'/show-update');
						$('select#tags_update').tagsinput('removeAll');
						for (var i = 0; i < response.data2.length; i++) {
							$('select#tags_update').tagsinput('add', response.data2[i].name, {preventPost: true});
						}
    				},
    				error: function (jqXHR, textStatus, errorThrown) {
						//xử lý lỗi tại đây
					}
				})
		});
		$(document).on('submit', '#form_edit', function(event) {
			event.preventDefault();
			var bool = true;
			var title = $('input#title_update').val();
			var description = CKEDITOR.instances.description_update.getData();
			var slug = $('input#slug_update').val();
			var content = CKEDITOR.instances.content_update.getData();
			var category = $("select#category_update option:selected").val();
			var category_id = $("select#category_update option:selected").attr('data-id');
			var tag = $("select#tags_update").val();
			if ($.trim(title) == ''){
		        $('p.mess_title_update').text('Tiêu đề không được để trống!');
		        $('input#title_update').addClass('is-invalid');
		        bool = false;
		    } else {
		    	$('p.mess_title_update').text('');
		        $('input#title_update').removeClass('is-invalid');
		    }
			if ($.trim(description) == ''){
		        $('p.mess_description_update').text('Mô tả không được để trống!');
		        $('#cke_3_contents').addClass('red-alert');
		        bool = false;
		    } else {
		    	$('.mess_description_update').text('');
		        $('#cke_3_contents').removeClass('red-alert');
		    }
			if ($.trim(slug) == ''){
		        $('p.mess_slug_update').text('Slug không được để trống!');
		        $('input#slug_update').addClass('is-invalid');
		        bool = false;
		    } else {
		    	$('p.mess_slug_update').text('');
		        $('input#slug_update').removeClass('is-invalid');
		    }
			if ($.trim(content) == ''){
		        $('p.mess_content_update').text('Nội dung chính không được để trống!');
		        $('#cke_4_contents').addClass('red-alert');
		        bool = false;
		    } else {
		    	$('p.mess_content_update').text('');
		        $('#cke_4_contents').removeClass('red-alert');
		    }
			if ($.trim(tag) == ''){
		        $('p.mess_tags_update').text('Tag không được để trống!');
		        $('input#tags_update').addClass('is-invalid');
		        bool = false;
		    } else {
		    	$('p.mess_tags_update').text('');
		        $('input#tags_update').removeClass('is-invalid');
		    }

		    if ($.trim(title) != '' && $.trim(description) != '' && $.trim(slug) != '' && $.trim(content) != '' && $.trim(category) != '' && $.trim(tag) != '') {
		    	bool == true;
		    }

			if (bool == true) {
				var url = $(this).attr('data-url');

				// var category_split = category.split(" ");
				// alert(category_split);
				$.ajax({
					type: 'put',
					url: url,
					data: {
						title: title,
						description: description,
						slug: slug,
						content: content,
						category_id: category_id
					},
					success: function(response) {
						console.log(response);
						alert('Hello');
						$('#bootstrap-data-table').DataTable().ajax.reload(null,false);
					},
					error: function (jqXHR, textStatus, errorThrown) {
						alert('failed');
					}
				})
			}
		});
	</script>
@endsection