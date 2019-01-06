@extends('layouts.admin-temp')

@section('header')
<meta name="csrf-token" content="{{ csrf_token() }}">
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
</style>
@endsection

@section('posts-active')
active
@endsection

@section('content')
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
	<li><a href="{{asset('')}}admin/home">Home</a></li>
	<li><a href="{{asset('')}}admin/home/manager-posts">Quản lý bài viết</a></li>
	<li class="active">Thêm mới bài viết</li>
</ul>

<!-- END BREADCRUMB -->

<!-- PAGE TITLE -->
<div class="page-title">                    
	<h2><span class="fa fa-arrow-circle-o-left"></span> Thêm Mới Bài Viết</h2>
</div>
<!-- END PAGE TITLE -->                

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
	<div class="row">
		<form method="POST" id="form_validate" action="{{route('admin-posts-store')}}" {{-- action="javascript:alert('Form #validate submited');" --}} class="form-horizontal">
			@csrf
		<div class="col-md-8">
			<div class="panel panel-default">
				<div class="panel-body post-info-important">
					<div class="row">
						<b>Tiêu đề (<span style="color: red;">*</span>)</b>
					</div>
					<div class="row">
						<div class="input-group">
							<div class="input-group-addon"><i class="glyphicon glyphicon-edit"></i></div>
							<input type="text" name="post_title" required id="post_title" class="validate[required] form-control" />
						</div>
					</div>
					<div class="row">
						<b>Tóm tắt (<span style="color: red;">*</span>)</b>
					</div>
					<div class="row">
						<textarea name="post_description" class="validate[required] form-control" id="post_description" rows="5" style="resize: none;"></textarea>
					</div>
					<div class="row">
						<b>Ảnh thumbnail (<span style="color: red;">*</span>)</b>
					</div>
					<div class="row">
						<input type="file" multiple class="file" name="thumbnail" data-preview-file-type="any"/>
					</div>
					<div class="row">
						<b>Nội dung (<span style="color: red;">*</span>)</b>
					</div>
					<div class="row post_content_base">
						<textarea name="post_content" class="validate[required] form-control" id="post_content" rows="10" cols="80">

						</textarea>
						
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<!-- START PANEL WITH REFRESH CALLBACKS -->
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title" style="color: blue;font-size: 15px;font-weight: bold;"><span class="glyphicon glyphicon-flag"></span> Trạng thái</h3>
				</div>
				<div class="panel-body">
					<select class="form-control select" data-live-search="true">
						<option>Publish</option>
						<option>Trash</option>
					</select>
				</div>
				<div class="panel-footer">
					<button class="btn btn-info pull-right" type="submit" style="font-size: 13px;font-weight: bold;">Lưu</button>
				</div>                                                                                          
			</div>
			<!-- END PANEL WITH REFRESH CALLBACKS -->

			<!-- START PANEL WITH REFRESH CALLBACKS -->
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title" style="color: blue;font-size: 15px;font-weight: bold;"><span class="glyphicon glyphicon-th-list"></span> Thể loại</h3>
				</div>
				<div class="panel-body">
					<div class="col-md-12">                                    
						<label class="check"><input type="radio" class="iradio" name="category_id" value="1" checked /> Lifestyle</label>
					</div>
					<div class="col-md-12">                                    
						<label class="check"><input type="radio" class="iradio" name="category_id" value="2" /> Travel</label>
					</div>
					<div class="col-md-12">                                    
						<label class="check"><input type="radio" class="iradio" name="category_id" value="3" /> Recipes</label>
					</div>
					<div class="col-md-12">                                    
						<label class="check"><input type="radio" class="iradio" name="category_id" value="4" /> Health</label>
					</div>
					<div class="col-md-12">                                    
						<label class="check"><input type="radio" class="iradio" name="category_id" value="5" /> Management</label>
					</div>
					<div class="col-md-12">                                    
						<label class="check"><input type="radio" class="iradio" name="category_id" value="6" /> Creativity</label>
					</div>
				</div>
			</div>
			<!-- END PANEL WITH REFRESH CALLBACKS -->

			<!-- START PANEL WITH REFRESH CALLBACKS -->
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title" style="color: blue;font-size: 15px;font-weight: bold;"><span class="glyphicon glyphicon-tags"></span> Tags</h3>
				</div>
				<div class="panel-body">
					
				</div>
			</div>
			<!-- END PANEL WITH REFRESH CALLBACKS -->
		</div>
		</form>
	</div>
</div>
<!-- END PAGE CONTENT WRAPPER -->                                    

<!-- START CONTENT FRAME -->
{{-- <div class="content-frame">


	<form method="POST" action="{{asset('')}}admin/home/manager-posts/store" class="form-horizontal" id="validate" action="javascript:alert('Form #validate submited');">
		<!-- START CONTENT FRAME TOP -->
		<div class="content-frame-top">                        
			<div class="page-title">                    
				<h2><span class="fa fa-arrow-circle-o-left"></span> Thêm Mới Bài Viết</h2>
			</div>                                      
			<div class="pull-right">
				<button class="btn btn-default content-frame-right-toggle"><span class="fa fa-bars"></span></button>
			</div>                        
		</div>
		<!-- END CONTENT FRAME TOP -->

		<!-- START CONTENT FRAME LEFT -->
		<div class="content-frame-right">
			<div class="panel panel-default">
				<div class="panel-body">
					<h3 class="push-up-0" style="color: blue;font-size: 16px;"><span class="glyphicon glyphicon-flag"></span> Trạng thái</h3>
					<select class="form-control select" data-live-search="true">
						<option>Publish</option>
						<option>Trash</option>
					</select>
					<button class="btn btn-info pull-right" type="submit" style="font-size: 13px;font-weight: bold;margin-top: 10px;">Lưu</button>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-body">
					<h3 class="push-up-0" style="color: blue;font-size: 16px;"><span class="glyphicon glyphicon-th-list"></span> Thể loại</h3>
				</div>
			</div>
		</div>
		<!-- END CONTENT FRAME LEFT -->

		<!-- START CONTENT FRAME BODY -->
		<div class="content-frame-body content-frame-body-left">
			<div class="panel panel-default">
				<div class="panel-body post-info-important">
					<div class="row">
						<b>Tiêu đề (<span style="color: red;">*</span>)</b>
					</div>
					<div class="row">
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-edit"></i></span>
							<input type="text" name="post_title" id="post_title" class="validate[required] form-control" />
						</div>
					</div>
					<div class="row">
						<b>Tóm tắt (<span style="color: red;">*</span>)</b>
					</div>
					<div class="row">
						<textarea name="post_description" class="validate[required] form-control" id="post_description" rows="5" style="resize: none;"></textarea>
					</div>
					<div class="row">
						<b>Nội dung (<span style="color: red;">*</span>)</b>
					</div>
					<div class="row">
						<textarea name="post_content" class="validate[required] form-control" id="post_content" rows="10" cols="80">

						</textarea>
						<div class="post_contentformError parentFormvalidate formError" style="opacity: 0.87; position: absolute; top: 510px; left: 0px; margin-top: 0px;"><div class="formErrorArrow formErrorArrowBottom"><div class="line1"><!-- --></div><div class="line2"><!-- --></div><div class="line3"><!-- --></div><div class="line4"><!-- --></div><div class="line5"><!-- --></div><div class="line6"><!-- --></div><div class="line7"><!-- --></div><div class="line8"><!-- --></div><div class="line9"><!-- --></div><div class="line10"><!-- --></div></div><div class="formErrorContent">* This field is required<br></div></div>
					</div>
				</div>
			</div>
		</div>
		<!-- END CONTENT FRAME BODY -->
	</form>
</div> --}}
<!-- END CONTENT FRAME -->

{{-- Đoạn vừa xóa sẽ được điền vào đây --}}
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

<script src="https://cdn.ckeditor.com/4.11.1/standard/ckeditor.js"></script>

<script type="text/javascript" src="{{asset('')}}admin_assets/js/plugins/dropzone/dropzone.min.js"></script>
<script type="text/javascript" src="{{asset('')}}admin_assets/js/plugins/fileinput/fileinput.min.js"></script>        
<script type="text/javascript" src="{{asset('')}}admin_assets/js/plugins/filetree/jqueryFileTree.js"></script>

<!-- START TEMPLATE -->
<script type="text/javascript" src="{{asset('')}}admin_assets/js/settings.js"></script>
<script type="text/javascript" src="{{asset('')}}admin_assets/js/plugins.js"></script>        
<script type="text/javascript" src="{{asset('')}}admin_assets/js/actions.js"></script>
<!-- END TEMPLATE -->
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
	$("#form_validate").validate({
		ignore: [],
		rules: {                                            
			'post_title': {
				required: true,
			},                                            
			'post_description': {
				required: true,
			},	                                            
			'post_content': {
				required: function() 
				{
					CKEDITOR.instances.post_content.updateElement();
				}
			},
			/* use below section if required to place the error*/
			errorPlacement: function(error, element) 
			{
				if (element.attr("name") == "post_content") 
				{
					error.insertBefore("#cke_1_bottom");
				} else {
					error.insertBefore(element);
				}
			}
		}                                        
	});                                    
	// Replace the <textarea id="editor1"> with a CKEditor
    //instance, using default configuration.
    $(document).ready(function() {
    	CKEDITOR.replace( 'post_content' );
    	// CKEDITOR.instances.post_content.on('blur', function() {
    	// 	if (CKEDITOR.instances.post_content.getData() == '') {
    	// 		$('.post_content_base>.post_contentformError').css({
    	// 			display: 'block',
    	// 			transition: '1s'
    	// 		});
    	// 	}else {
    	// 		$('.post_content_base>.post_contentformError').css({
    	// 			display: 'none',
    	// 			transition: '1s'
    	// 		});
    	// 	}
    	// });
    	$('button.kv-fileinput-upload').remove();
    		$('.file-preview-status').append('<p>Mời bạn chọn ảnh</p>');
    	$('.btn-file').click(function(){
    		$('.file-preview-status>p').remove();
    	})
    	$('.fileinput-remove-button').click(function(){
    		$('.file-preview-status').append('<p>Mời bạn chọn ảnh</p>');
    	})
    });

</script>
<!-- END PAGE PLUGINS -->
@endsection





<!-- PAGE CONTENT WRAPPER -->
{{-- <div class="page-content-wrap">                

	<div class="row">
		<div class="col-md-12">
			<form method="POST" action="{{asset('')}}admin/home/manager-posts/store" class="form-horizontal" id="validate" action="javascript:alert('Form #validate submited');">
				<div class="row">
					<div class="col-md-8 post-info-important" style="padding-left: 0px">
						<div class="row">
							<b>Tiêu đề (<span style="color: red;">*</span>)</b>
						</div>
						<div class="row">
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-edit"></i></span>
								<input type="text" name="post_title" id="post_title" class="validate[required] form-control" />
							</div>
						</div>
						<div class="row">
							<b>Tóm tắt (<span style="color: red;">*</span>)</b>
						</div>
						<div class="row">
							<textarea name="post_description" class="validate[required] form-control" id="post_description" rows="5" style="resize: none;"></textarea>
						</div>
						<div class="row">
							<b>Nội dung (<span style="color: red;">*</span>)</b>
						</div>
						<div class="row">
							<textarea name="post_content" class="validate[required] form-control" id="post_content" rows="10" cols="80">

							</textarea>
							<div class="post_contentformError parentFormvalidate formError" style="opacity: 0.87; position: absolute; top: 510px; left: 0px; margin-top: 0px;"><div class="formErrorArrow formErrorArrowBottom"><div class="line1"><!-- --></div><div class="line2"><!-- --></div><div class="line3"><!-- --></div><div class="line4"><!-- --></div><div class="line5"><!-- --></div><div class="line6"><!-- --></div><div class="line7"><!-- --></div><div class="line8"><!-- --></div><div class="line9"><!-- --></div><div class="line10"><!-- --></div></div><div class="formErrorContent">* This field is required<br></div></div>
						</div>
					</div>
					<div class="col-md-4" style="padding-right: 0px;">
						<div class="row">
							<!-- START PANEL WITH REFRESH CALLBACKS -->
							<div class="panel panel-primary">
								<div class="panel-heading">
									<h3 class="panel-title" style="color: blue;font-size: 16px;"><span class="glyphicon glyphicon-flag"></span> Trạng thái</h3>
								</div>
								<div class="panel-body">
									Refresh function has two event callbacks <code>shown</code> and <code>hidden</code>.
								</div>
								<div class="panel-footer">
									<button class="btn btn-success pull-right"><b>Lưu</b></button>
								</div>                                                                                          
							</div>
							<!-- END PANEL WITH REFRESH CALLBACKS -->
						</div>
					</div>
				</div>
			</form>

		</div>
	</div>
</div> --}}
<!-- END PAGE CONTENT WRAPPER -->