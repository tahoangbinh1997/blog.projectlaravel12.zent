@extends('layouts.admin-temp')

@section('posts-active')
    active
@endsection

@section('posts')
    active
@endsection

@section('content')

	<!-- START BREADCRUMB -->
	<ul class="breadcrumb">
		<li><a href="{{asset('')}}admin/home">Home</a></li>
		<li><a href="{{asset('')}}admin/home/manager-posts">Quản lý bài viết</a></li>
		<li class="active">Chi tiết bài viết</li>
	</ul>

	<!-- END BREADCRUMB -->

	<!-- PAGE TITLE -->
	<div class="page-title">                    
		<h2><span class="fa fa-arrow-circle-o-left"></span> Chi tiết bài viết</h2>
	</div>
	<!-- END PAGE TITLE -->                

	<!-- PAGE CONTENT WRAPPER -->
	<div class="page-content-wrap">

		<div class="row">
			<div class="col-md-9">

				<div class="panel panel-default">
					<div class="panel-body posts">

						<div class="post-item">
							<div class="post-title">
								{{$post->title}}
							</div>
							<div class="post-date">
								<span class="fa fa-calendar"></span>
								 @php
                                    $date = new DateTime($post->created_at); // tạo biến mới để đổi kiểu thời gian mặc định của csdl
                                    $month_num = $date->format('m'); //lấy ra tháng
                                    $convert_month = DateTime::createFromFormat('!m',$month_num); //convert tháng sang kiểu chữ
                                 @endphp
                                 {{$convert_month->format('F')}} {{$date->format('d')}}, {{$date->format('Y')}} / 
                                  <a href="#">
                                  	@php $dem = 0; @endphp
                                  	@foreach($comment_counts as $counts)
                                  	@if($post->id == $counts->post_id)
                                  	@php $dem++; @endphp
                                  	@endif
                                  	@endforeach
                                  	{{$dem}}
                                  Comments</a> / 
                                  <a href="pages-profile.html">
                                  	by {{$user->name}}
                                  </a></div>
							<div class="post-text">                                            
								<p><strong>{{$post->title}}</strong>, {{$post->description}}</p>
								<img src="{{asset('storage')}}/{{$post->thumbnail}}" class="img-text post-image"/>
								{!!$post->content!!}
								<h4>Bài viết do {{$user->name}} viết</h4>
								<ul>
									@foreach($all_posts as $all_post)
										@if($all_post->user_id == $user->id)
											<li><a href="{{asset('')}}/admin/home/manager-posts/detail/{{$all_post->id}}">{{$all_post->title}}</a></li>
										@endif
									@endforeach
								</ul>
							</div>
							<div class="post-row">
								<div class="post-info">
									<span class="fa fa-thumbs-up"></span> {{$post->like}} - <span class="fa fa-thumbs-down"></span> {{$post->dislike}} - <span class="fa fa-eye"></span> {{$post->view_count}}                                                
								</div>
							</div>
						</div>                                            

						<h3 class="push-down-20">Comments</h3>
						<ul class="media-list">
							@foreach($post_comments as $post_comment)
							<li class="media">
								<a class="pull-left" href="#">
									<img class="media-object img-text" src="{{asset('storage')}}/{{$post_comment->comments_pic}}" alt="Dmitry Ivaniuk" width="64">
								</a>
								<div class="media-body">
									<h4 class="media-heading">{{$post_comment->name}}</h4>
									<p>{{$post_comment->message}}</p>
									<p class="text-muted">
										@php
	                                    $date = new DateTime($post->created_at); // tạo biến mới để đổi kiểu thời gian mặc định của csdl
	                                    $month_num = $date->format('m'); //lấy ra tháng
	                                    $convert_month = DateTime::createFromFormat('!m',$month_num); //convert tháng sang kiểu chữ
	                                    @endphp
	                                    {{$convert_month->format('F')}} {{$date->format('d')}}, {{$date->format('Y')}}, {{$date->format('H:i')}}
									</p>                                                                                          
								</div>                                            
							</li>
							@endforeach
						</ul>                                    
					</div>
				</div>

			</div>
			<div class="col-md-3">

				<div class="panel panel-default">
					<div class="panel-body">
						<h3>Thể loại</h3>
						<div class="links">
							<a href="#">{{$category->name}} <span class="label label-default">{{$category_count}}</span></a>
						</div>
					</div>
				</div>

				<div class="panel panel-default">
					<div class="panel-body">
						<h3>Bài viết cùng thể loại</h3>
						<div class="links small">
							@foreach($recent_posts as $recent_post)
								<a href="{{route('admin-posts-show',$recent_post->id)}}">{{$recent_post->title}}</a>
							@endforeach
						</div>
					</div>
				</div>

				<div class="panel panel-default">
					<div class="panel-body">
						<h3>Tags</h3>
						<ul class="list-tags push-up-10">
							@foreach($post_tags as $post_tag)
								<li><a href="#"><span class="fa fa-tag"></span> {{$post_tag->name}}</a></li>
							@endforeach
						</ul>
					</div>
				</div>                            

			</div>
		</div>

	</div>
	<!-- END PAGE CONTENT WRAPPER -->                       
@endsection

@section('footer')
<!-- START THIS PAGE PLUGINS-->        
	<script type='text/javascript' src='{{asset('')}}admin_assets/js/plugins/icheck/icheck.min.js'></script>
	<script type="text/javascript" src="{{asset('')}}admin_assets/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>                
<!-- END THIS PAGE PLUGINS-->        
@endsection