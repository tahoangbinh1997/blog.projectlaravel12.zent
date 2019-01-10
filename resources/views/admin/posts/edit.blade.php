@extends('layouts.admin-temp')

@section('posts-active')
    active
@endsection

@section('posts')
    active
@endsection

@section('header')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
<style type="text/css">
.post-info-important .row {
	margin-bottom: 6px;
}
.page-content {
	height: 100%!important;
}
.file-preview {
	display: block!important;
	height: 220px!important;
}
.bootstrap-tagsinput {
	width: 100%!important;
}
</style>
@endsection

@section('content')
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
	<li><a href="{{asset('')}}admin/home">Home</a></li>
	<li><a href="{{asset('')}}admin/home/manager-posts">Quản lý bài viết</a></li>
	<li class="active">Cập nhật thông tin bài viết</li>
</ul>

<!-- END BREADCRUMB -->

<!-- PAGE TITLE -->
<div class="page-title">                    
	<h2><span class="fa fa-arrow-circle-o-left"></span> Cập Nhật Thông Tin Bài Viết</h2>
</div>
<!-- END PAGE TITLE -->                

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
	<div class="row">
		<form method="POST" id="form_validate" action="{{route('admin-posts-update' , ['id' => $post->id])}}" {{-- action="javascript:alert('Form #validate submited');" --}} enctype="multipart/form-data" class="form-horizontal">
			@csrf
			{{method_field('patch')}}
		<div class="col-md-8">
			<div class="panel panel-default">
				<div class="panel-body post-info-important">
					<div class="row">
						<b>Tiêu đề (<span style="color: red;">*</span>)</b>
					</div>
					<div class="row">
						<div class="input-group" title="Tiêu đề bài viết" data-toggle="tooltip" >
							<div class="input-group-addon"><i class="glyphicon glyphicon-edit"></i></div>
							<input type="text" name="title" id="title" class="form-control" value="{{$post->title}}" />
						</div>
						@if($errors->has('title'))
						<p style="color: red;">
							{{$errors->first('title')}}
						</p>
						@endif
					</div>
					<div class="row">
						<b>Tóm tắt (<span style="color: red;">*</span>)</b>
					</div>
					<div class="row" title="Tóm tắt bài viết" data-toggle="tooltip" >
						<textarea name="description" class="form-control" id="description" rows="5" style="resize: none;" >{{$post->description}}</textarea>
						@if($errors->has('description'))
						<p style="color: red;">
							{{$errors->first('description')}}
						</p>
						@endif
					</div>
					<div class="row">
						<b>Ảnh bài viết (<span style="color: red;">*</span>)</b>
					</div>
					<div class="row" title="Ảnh của bài viết" data-toggle="tooltip" >
						<input type="file" class="file" value="{{$post->thumbnail}}" name="thumbnail" data-preview-file-type="any"/>
						@if($errors->has('thumbnail'))
						<p style="color: red;">
							{{$errors->first('thumbnail')}}
						</p>
						@endif
					</div>
					<div class="row">
						<b>Nội dung (<span style="color: red;">*</span>)</b>
					</div>
					<div class="row post_content_base" title="Nội dung bài viết" data-toggle="tooltip" >
						<textarea name="content" class="validate[required] form-control" id="content" rows="10" cols="80">
							{{$post->content}}
						</textarea>
						@if($errors->has('content'))
						<p style="color: red;">
							{{$errors->first('content')}}
						</p>
						@endif
						
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<!-- START PANEL WITH REFRESH CALLBACKS -->
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title" style="color: blue;font-size: 15px;font-weight: bold;"><span class="glyphicon glyphicon-flag"></span> Trạng thái (<span style="color: red;">*</span>)</h3>
				</div>
				<div class="panel-body" title="Trạng thái bài viết" data-toggle="tooltip" >
					<select class="form-control select" data-live-search="true" name="post_status">
						<option>Publish</option>
						<option>Trash</option>
					</select>
					@if($errors->has('post_status'))
					<p style="color: red;">
						{{$errors->first('post_status')}}
					</p>
					@endif
				</div>
				<div class="panel-footer">
					<button class="btn btn-info pull-right" name="submit_update" type="submit" style="font-size: 13px;font-weight: bold;">Lưu</button>
				</div>                                                                                          
			</div>
			<!-- END PANEL WITH REFRESH CALLBACKS -->

			<!-- START PANEL WITH REFRESH CALLBACKS -->
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title" style="color: blue;font-size: 15px;font-weight: bold;"><span class="glyphicon glyphicon-th-list"></span> Thể loại (<span style="color: red;">*</span>)</h3>
				</div>
				<div class="panel-body" title="Thể loại" data-toggle="tooltip" >
					@foreach($categories as $category)
					<div class="col-md-12">                                    
						<label class="check">
							<input type="radio" class="iradio" name="category_id" value="{{$category->id}}" @if($post->category_id == $category->id) checked @endif/> {{$category->name}}
						</label>
					</div>
					@endforeach
					@if($errors->has('category_id'))
					<p style="color: red;">
						{{$errors->first('category_id')}}
					</p>
					@endif
				</div>
			</div>
			<!-- END PANEL WITH REFRESH CALLBACKS -->

			<!-- START PANEL WITH REFRESH CALLBACKS -->
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title" style="color: blue;font-size: 15px;font-weight: bold;"><span class="glyphicon glyphicon-tags"></span> Tags (<span style="color: red;">*</span>)</h3>
				</div>
				<div class="panel-body" title="Thẻ tags" data-toggle="tooltip" >
					<div class="form-group">
						<div class="col-md-12 post_tags_base">
							<select multiple name="tags[]" data-role="tagsinput" size="100%">
								@foreach($post_tags as $post_tag) 
									<option value="{{$post_tag->name}}">{{$post_tag->name}}</option>
								@endforeach
							</select>
							<input type="hidden" name="delete_tags" id="delete_tags" value=""/>
							@if($errors->has('tags'))
							<p style="color: red;">
								{{$errors->first('tags')}}
							</p>
							@endif
						</div>
					</div> 
				</div>
			</div>
			<!-- END PANEL WITH REFRESH CALLBACKS -->
		</div>
		</form>
	</div>
</div>
<!-- END PAGE CONTENT WRAPPER -->                                    

@endsection

@section('footer')
<!-- THIS PAGE PLUGINS -->
<script type='text/javascript' src='{{asset('')}}admin_assets/js/plugins/icheck/icheck.min.js'></script>
<script type="text/javascript" src="{{asset('')}}admin_assets/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
<script type="text/javascript" src="{{asset('')}}admin_assets/js/plugins/scrolltotop/scrolltopcontrol.js"></script>

<script type='text/javascript' src='{{asset('')}}admin_assets/js/plugins/bootstrap/bootstrap-datepicker.js'></script>        
<script type='text/javascript' src='{{asset('')}}admin_assets/js/plugins/bootstrap/bootstrap-select.js'></script>        

<script type='text/javascript' src='{{asset('')}}admin_assets/js/plugins/validationengine/languages/jquery.validationEngine-en.js'></script>
<script type='text/javascript' src='{{asset('')}}admin_assets/js/plugins/validationengine/jquery.validationEngine.js'></script>        

<script type='text/javascript' src='{{asset('')}}admin_assets/js/plugins/jquery-validation/jquery.validate.js'></script>                

<script type='text/javascript' src='{{asset('')}}admin_assets/js/plugins/maskedinput/jquery.maskedinput.min.js'></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>

<script src="https://cdn.ckeditor.com/4.11.1/standard/ckeditor.js"></script>

<script type="text/javascript" src="{{asset('')}}admin_assets/js/plugins/dropzone/dropzone.min.js"></script>
<script type="text/javascript" src="{{asset('')}}admin_assets/js/plugins/fileinput/fileinput.min.js"></script>        
<script type="text/javascript" src="{{asset('')}}admin_assets/js/plugins/filetree/jqueryFileTree.js"></script>


{{-- <script type="text/javascript" charset="utf-8">
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$(document).ready(function () {
		$('#form_validate').submit(function(event){
			event.preventDefault();
			$.ajax({
				type: 'post',
				url: '{{route('admin-posts-store')}}',
				data: {
					title: $('#post_title').val(),

				}
				success: function (response) {
					alert("hello")
				},
				error: function (jqXHR, textStatus, errorThrown) {
					//xử lý lỗi tại đây
				}
			})
		})
	})
</script> --}}
<script type="text/javascript">
	// Replace the <textarea id="editor1"> with a CKEditor
    //instance, using default configuration.
    $(document).ready(function() {
    	CKEDITOR.replace( 'content' );
    	$('button.kv-fileinput-upload').remove();
    	$('.file-preview-thumbnails').append('<div class="file-preview-frame"><img style="width: auto;height: 160px;" src="{{asset('storage')}}/{{$post->thumbnail}}"/></div>');
    	$('.fileinput-remove-button').click(function(){
    		$('.file-preview-thumbnails').append('<div class="file-preview-frame"><img style="width: auto;height: 160px;" src="{{asset('storage')}}/{{$post->thumbnail}}"/></div>');
    		$('.file-preview-frame').change(function(){
    			$('this').append('<div class="file-preview-frame"><img style="width: auto;height: 160px;" src="{{asset('storage')}}/{{$post->thumbnail}}"/></div>');
    		})
    	})
    	$('.label-info>span').addClass('button_remove');
    	var delete_tags = [];
    	$('.bootstrap-tagsinput').each(function(){
    		$('span.button_remove').on('click', function(event) {
    			delete_tags[delete_tags.length]=$(this).parent('.label-info').text();
    			$('#delete_tags').attr('value', delete_tags);
    		});
    	})
    });

</script>
<!-- END PAGE PLUGINS -->
@endsection