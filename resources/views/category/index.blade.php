{{-- kế thừa từ trang master --}}
@extends('layouts.master')

@section('header')
    <title>Thể loại: {{$category->name}}</title>
@endsection

@section('header_content')
    <div class="row" style="margin-top: 90px;">
          <div class="col-md-6">

            <h3>Thể loại: {{$category->name}}</h3>

          </div>
    </div>
@endsection

@section('active-categories')
    active
@endsection

@section('content')
    <div class="col-md-12 col-lg-8 main-content">
            <div class="row">
              @foreach($posts as $key => $post)
                @if($key <= $sum_posts/2)
                  <div class="col-md-6">
                    <div class="blog-entry element-animate" data-animate-effect="fadeIn">
                      <a href="{{asset('')}}detail/{{$post->slug}}"><img src="{{asset('storage/images')}}/{{$post->thumbnail}}" alt="Image placeholder"></a>
                      <div class="blog-content-body">
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
                          </span> <br>
                          <span class="ml-2"><span class="fa fa-comments"></span>
                            @php $dem = 0; @endphp
                            @foreach($comment_counts as $counts)
                            @if($post->id == $counts->post_id)
                            @php $dem++; @endphp
                            @endif
                            @endforeach
                            {{$dem}}
                            <span class="ml-2"><span class="fa fa-thumbs-up"></span>
                            <span id="post-like">{{$post->like}}</span>
                            <span class="ml-2"><span class="fa fa-thumbs-down"></span>
                            <span id="post-dislike">{{$post->dislike}}</span>
                          </span>
                        </div>
                        <a href="{{asset('')}}detail/{{$post->slug}}"><h2>{{$post->title}}</h2></a>
                        <span class="mr-2" style="color: black;">Đăng bởi: Tạ Hoàng Bình</span>
                      </div>
                    </div>
                  </div>
                  @else
                  @php break; @endphp
                @endif
              @endforeach
            </div>

            @if($posts->hasPages())
                <?php
                    $link_limit = 7; // maximum number of links (a little bit inaccurate, but will be ok for now)
                ?>
                <div class="row">
                  <div class="col-md-12 text-center">
                    <nav aria-label="Page navigation" class="text-center">
                      <ul class="pagination">
                        @if($posts->onFirstPage())
                        <li class="page-item  active"><a class="page-link" style="color: white;cursor: no-drop;">Prev</a></li>
                        @else
                        <li class="page-item">
                            @php
                            if (isset($q)) {
                                @endphp
                                <a class="page-link" href="{{$posts->appends(['q'=>$q])->previousPageUrl() }}">Prev</a>
                                @php
                            } else {
                                @endphp
                                <a class="page-link" href="{{$posts->previousPageUrl() }}">Prev</a>
                                @php
                            }
                            @endphp
                        </li>
                        @endif
                        @for ($i = 1; $i <= $posts->lastPage(); $i++)
                            <?php
                            $half_total_links = floor($link_limit / 2);
                            $from = $posts->currentPage() - $half_total_links;
                            $to = $posts->currentPage() + $half_total_links;
                            if ($posts->currentPage() < $half_total_links) {
                                $to += $half_total_links - $posts->currentPage();
                            }
                            if ($posts->lastPage() - $posts->currentPage() < $half_total_links) {
                                $from -= $half_total_links - ($posts->lastPage() - $posts->currentPage()) - 1;
                            }
                            ?>
                            @if ($from < $i && $i < $to)
                            <li class="page-item {{ ($posts->currentPage() == $i) ? 'active' : '' }}" style="{{ ($posts->currentPage() == $i) ? 'cursor: no-drop' : '' }}">
                             @if(($posts->currentPage() == $i))
                             <a class="page-link" style="{{ ($posts->currentPage() == $i) ? 'cursor: no-drop;color: white;' : '' }}">{{$i}}</a>
                             @else
                             @php
                             if (isset($q)) {
                                @endphp
                                <a class="page-link" href="{!!$posts->appends(['q'=>$q])->url($i)!!}">{{ $i }}</a>
                                @php
                            } else {
                                @endphp
                                <a class="page-link" href="{!!$posts->url($i)!!}">{{ $i }}</a>
                                @php
                            }
                            @endphp
                            @endif
                        </li>
                        @endif
                        @endfor
                        @if($posts->hasMorePages())
                        <li class="page-item">
                            @php
                            if (isset($q)) {
                                @endphp
                                <a class="page-link" href="{{ $posts->appends(['q'=>$q])->nextPageUrl() }}">Next</a>
                                @php
                            } else {
                                @endphp
                                <a class="page-link" href="{{ $posts->nextPageUrl() }}">Next</a>
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
                </div>
            @endif


            <div class="row mb-5 mt-5">

              <div class="col-md-12">
                <h2 class="mb-4">More Blog Posts</h2>
              </div>
        
              <div class="col-md-12">

                @foreach($posts as $key => $post)
                    @if($key > $sum_posts/2)
                        <div class="post-entry-horzontal">
                          <a href="{{asset('')}}detail/{{$post->slug}}">
                            <div class="image element-animate"  data-animate-effect="fadeIn" style="background-image: url({{asset('storage/images')}}/{{$post->thumbnail}});"></div>
                            <span class="text" style="display: block;">
                              <div class="post-meta">
                                <span style="z-index: 0;" class="category">
                                    {{$category->name}}
                                </span>
                                <span class="mr-2">
                                    @php
                                        $date = new DateTime($post->created_at); // tạo biến mới để đổi kiểu thời gian mặc định của csdl
                                        $month_num = $date->format('m'); //lấy ra tháng
                                        $convert_month = DateTime::createFromFormat('!m',$month_num); //convert tháng sang kiểu chữ
                                    @endphp
                                        {{$convert_month->format('F')}} {{$date->format('d')}}, {{$date->format('Y')}}
                                </span> &bullet;<br>
                                <span class="ml-2"><span class="fa fa-comments"></span>
                                  @php $dem = 0; @endphp
                                  @foreach($comment_counts as $counts)
                                  @if($post->id == $counts->post_id)
                                  @php $dem++; @endphp
                                  @endif
                                  @endforeach
                                  {{$dem}}
                                </span>
                              </div>
                              <h2>{{$post->title}}</h2><br>
                              <span class="mr-2" style="color: black;">Đăng bởi: Tạ Hoàng Bình</span>
                            </span>
                          </a>
                        </div>  
                    @endif
                <!-- END post -->
                @endforeach
                @if($posts->count() < 3)
                  <h4 style="margin-top: 50px;padding-left: 15px;">Quá ít bài viết ở trang hiện tại, không thể hiển thị thêm</h4>
                @endif
              </div>
            </div>
          </div>

          <!-- END main-content -->
@endsection