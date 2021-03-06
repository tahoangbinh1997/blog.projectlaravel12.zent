{{-- kế thừa từ trang master --}}
@extends('layouts.master')

@section('header')
<title>Bài viết: {{$post->title}}</title>
{{-- <meta name="csrf-token" content="{{csrf_token()}}">​ --}}
@endsection

@section('style')
style="margin-top:90px;"
@endsection

@section('active-blog')
active
@endsection

@section('content')

<div class="col-md-12 col-lg-8 main-content" style="margin-top: 90px;">
    <h1 class="mb-4">{{$post->title}}</h1>
    <div class="post-meta">
        <a href="{{asset('')}}category/{{$category->slug}}">
            <span class="category">
                {{$category->name}}
            </span>
        </a>
        <span class="mr-2">
            @php
                $date = new DateTime($post->created_at); // tạo biến mới để đổi kiểu thời gian mặc định của csdl
                $month_num = $date->format('m'); //lấy ra tháng
                $convert_month = DateTime::createFromFormat('!m',$month_num); //convert tháng sang kiểu chữ
            @endphp
            {{$convert_month->format('F')}} {{$date->format('d')}}, {{$date->format('Y')}}
            </span> &bullet;
            <span class="ml-2"><span class="fa fa-comments"></span>
            @php $dem = 0; @endphp
            @foreach($comment_counts as $counts)
            @if($post->id == $counts->post_id)
            @php $dem++; @endphp {{-- mỗi lần tìm thấy 1 comment trong bài post thì biến đếm tăng lên 1 đơn vị --}}
            @endif
            @endforeach
            {{$dem}}
            <span class="ml-2"><span class="fa fa-thumbs-up"></span>
            <span id="post-like">{{$post->like}}</span>
            <span class="ml-2"><span class="fa fa-thumbs-down"></span>
            <span id="post-dislike">{{$post->dislike}}</span>
        </span>
        <form method="GET" style="float: right;" role="form" id="form-post-dislike" data-url="{{asset('')}}dislike/{{$post->slug}}">
            @csrf
            <button type="submit" class="btn">
                Dislike
            </button>
        </form>
        <form method="GET" style="float: right;margin-right: 10px;" role="form" id="form-post-like" data-url="{{asset('')}}like/{{$post->slug}}">
            @csrf
            <button type="submit" class="btn">
                Like
            </button>
        </form>
    </div>
    <div class="post-content-body">
      <div class="row mb-5">
          <div class="col-md-12 mb-4 element-animate">
            <img src="{{asset('storage')}}/{{$post->thumbnail}}" alt="Image placeholder" class="img-fluid">
        </div>
    </div>
    <content>{!!$post->content!!}</content>
    </div>


<div class="pt-5">
  <p>Categories:  <a href="{{asset('')}}category/{{$category->slug}}"><span class="category">{{$category->name}}</span></a></p>
  <p> Tags:
    @foreach($post_tags as $post_tag)
    <a href="{{asset('')}}tag/{{$post_tag->slug}}">#{{$post_tag->name}}</a> &bullet;
    @endforeach
</p>
</div>

<div class="pt-5">
    <ul style="padding-left: 0;">
        @if($post->id == $minpost)
        <li class="page-link" style="width: 50%;display: inline;border-radius: 5px;float: left;cursor: no-drop;"><a class="page-item"><span>Bài viết trước: Không còn bài đăng nào tồn tại </span></a></li>
        @else
        <li class="page-link" style="width: 50%;display: inline;border-radius: 5px;float: left;"><a href="{{$previous->slug}}" class="page-item"><span>Bài viết trước: {{$previous->title}}</span></a></li>
        @endif
        @if($post->id == $maxpost)
        <li class="page-link" style="width: 50%;display: inline;border-radius: 5px;float: right;cursor: no-drop;"><a class="page-item"><span>Bài viết sau: Không còn bài đăng nào tồn tại </span></a></li>
        @else
        <li class="page-link" style="width: 50%;display: inline;border-radius: 5px;float: right;"><a href="{{$next->slug}}" class="page-item"><span>Bài viết sau: {{$next->title}}</span></a></li>
        @endif
    </ul>
</div>


<div class="pt-5">
  <h3 class="mb-5">{{$comments->count()}} Comments</h3>
  <ul class="comment-list">
    @foreach($comments as $comment)
    <li class="comment">
      <div class="vcard">
        <img src="{{asset('storage')}}/{{$comment->comments_pic}}" alt="Image placeholder">
    </div>
    <div class="comment-body">
        <h3>{{$comment->name}}</h3>
        <div class="meta">
            @php
                $date = new DateTime($post->created_at); // tạo biến mới để đổi kiểu thời gian mặc định của csdl
                $month_num = $date->format('m'); //lấy ra tháng
                $convert_month = DateTime::createFromFormat('!m',$month_num); //convert tháng sang kiểu chữ
                @endphp
                {{$convert_month->format('F')}} {{$date->format('d')}}, {{$date->format('Y')}} at {{$date->format('H:i')}}
            </div>
            <p>{{$comment->message}}</p>
            <p><a href="#" class="reply">Reply</a></p>
        </div>
        <ul class="children">
            <li class="comment">
              <div class="vcard">
                <img src="{{asset('storage')}}/{{$comment->comments_pic}}" alt="Image placeholder">
            </div>
            <div class="comment-body">
                <h3>Jean Doe</h3>
                <div class="meta">January 9, 2018 at 2:21pm</div>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur quidem laborum necessitatibus, ipsam impedit vitae autem, eum officia, fugiat saepe enim sapiente iste iure! Quam voluptas earum impedit necessitatibus, nihil?</p>
                <p><a href="#" class="reply">Reply</a></p>
            </div>
        </li>
    </ul>
</li>
@endforeach
</ul>
</div>
<!-- END comment-list -->
<div class="pt-5">
    @if($comments->hasPages())
<?php
        $link_limit = 7; // maximum number of links (a little bit inaccurate, but will be ok for now)
        ?>
          <div class="col-md-12 text-center">
            <nav aria-label="Page navigation" class="text-center">
              <ul class="pagination">
                @if($comments->onFirstPage())
                <li class="page-item  active"><a class="page-link" style="color: white;cursor: no-drop;">Prev</a></li>
                @else
                <li class="page-item">
                    <a class="page-link" href="{{$comments->appends(['no_view'=>'no'])->previousPageUrl() }}">Prev</a>
                </li>
                @endif
                @for ($i = 1; $i <= $comments->lastPage(); $i++)
                <?php
                $half_total_links = floor($link_limit / 2);
                $from = $comments->currentPage() - $half_total_links;
                $to = $comments->currentPage() + $half_total_links;
                if ($comments->currentPage() < $half_total_links) {
                    $to += $half_total_links - $comments->currentPage();
                }
                if ($comments->lastPage() - $comments->currentPage() < $half_total_links) {
                    $from -= $half_total_links - ($comments->lastPage() - $comments->currentPage()) - 1;
                }
                ?>
                @if ($from < $i && $i < $to)
                <li class="page-item {{ ($comments->currentPage() == $i) ? 'active' : '' }}" style="{{ ($comments->currentPage() == $i) ? 'cursor: no-drop' : '' }}">
                   @if(($comments->currentPage() == $i))
                   <a class="page-link" style="{{ ($comments->currentPage() == $i) ? 'cursor: no-drop;color: white;' : '' }}">{{$i}}</a>
                   @else
                   <a class="page-link" href="{!!$comments->appends(['no_view'=>'no'])->url($i)!!}">{{ $i }}</a>
                @endif
            </li>
            @endif
            @endfor
            @if($comments->hasMorePages())
            <li class="page-item">
                @php
                if (isset($q)) {
                    @endphp
                    <a class="page-link" href="{{ $comments->appends(['q'=>$q])->nextPageUrl() }}">Next</a>
                    @php
                } else {
                    @endphp
                    <a class="page-link" href="{{ $comments->nextPageUrl() }}">Next</a>
                    @php
                }
                @endphp
            </li>
            @else
            <li class="page-item  active"><a class="page-link" style="color: white;cursor: no-drop;">Next</a></li>
            @endif
        </ul>
    </nav>
</div>
@endif
</div>

<div class="comment-form-wrap pt-5">
    <h3 class="mb-5">Leave a comment</h3>
    <form  name="contactForm" method="post" action="{{asset('')}}detail/{{$post->slug}}" autocomplete="off" class="p-5 bg-light" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Name *</label>
            <input type="text" class="form-control" name="name" placeholder="Your Name*" value="{{old('name')}}">
            @if($errors->has('name'))
            <p style="color: red;">
                {{$errors->first('name')}}
            </p>
            @endif
        </div>
        <div class="form-group">
            <label for="email">Email *</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="Your Email*" value="{{old('email')}}">
            @if($errors->has('email'))
            <p style="color: red;">
                {{$errors->first('email')}}
            </p>
            @endif
        </div>
        <div class="form-group">
            <label for="website">Thumbnail *</label>
            <input type="file" name="comments_pic" class="form-control" id="comments_pic" placeholder="Thumbnail" value="{{old('comment_pic')}}">
            @if($errors->has('comment_pic'))
            <p style="color: red;">
                {{$errors->first('comment_pic')}}
            </p>
            @endif
        </div>

        <div class="form-group">
            <label for="message">Message</label>
            <textarea name="message" id="message" cols="30" rows="10" class="form-control" placeholder="Your Message*">{{old('message')}}</textarea>
            @if($errors->has('message'))
            <p style="color: red;">
                {{$errors->first('message')}}
            </p>
            @endif
        </div>
        <div class="form-group">
            <button type="submit" name="submit" id="submit" class="btn btn-primary">Thêm bình luận</button>
        </div>

    </form>
</div>
</div>

@endsection

@section('footer')
<script type="text/javascript" charset="utf-8">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#form-post-like').on('submit', function(event) {
            event.preventDefault();
            var url = $(this).data('url');
            $.ajax({
                type: 'get',
                url: url,
                success: function(response) {
                    if ($('#form-post-like button').hasClass('btn-primary')) {
                        $('#form-post-like button').removeClass('btn-primary');
                    } else {
                        $('#form-post-like button').addClass('btn-primary');
                        $('#form-post-dislike button').removeClass('btn-warning');
                    }
                    $('#post-like').text(response.post_res.like);
                    $('#post-dislike').text(response.post_res.dislike);
                },
                error: function (error) {

                }
            })
        });
        @if(isset($rela_post_like))
            $('#form-post-like button').addClass('btn-primary');
        @endif
    });

    $(document).ready(function() {
        $('#form-post-dislike').on('submit', function(event) {
            event.preventDefault();
            var url = $(this).data('url');
            $.ajax({
                type: 'get',
                url: url,
                success: function(response) {
                    if ($('#form-post-dislike button').hasClass('btn-warning')) {
                        $('#form-post-dislike button').removeClass('btn-warning');
                    } else {
                        $('#form-post-dislike button').addClass('btn-warning');
                        $('#form-post-like button').removeClass('btn-primary');
                    }
                    $('#post-like').text(response.post_res.like);
                    $('#post-dislike').text(response.post_res.dislike);
                },
                error: function (error) {

                }
            })
        });
        @if(isset($rela_post_dislike))
            $('#form-post-dislike button').addClass('btn-warning');
        @endif
    });
</script>
@endsection