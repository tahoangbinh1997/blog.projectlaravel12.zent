

<!doctype html>
<html lang="en">
  <head>

    </head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300, 400,700" rel="stylesheet">

    <link rel="icon" type="image/png" href="{{asset('blog_assets/favicon.ico')}}"/>
    <link rel="stylesheet" href="{{asset('blog_assets/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('blog_assets/css/animate.css')}}">
    <link rel="stylesheet" href="{{asset('blog_assets/css/owl.carousel.min.css')}}">

    <link rel="stylesheet" href="{{asset('blog_assets/fonts/ionicons/css/ionicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('blog_assets/fonts/fontawesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('blog_assets/fonts/flaticon/font/flaticon.css')}}">

    <!-- Theme Style -->
    <link rel="stylesheet" href="{{asset('blog_assets/css/style.css')}}">
    <!-- link header -->
        @yield('header')
    {{-- end header --}}
  </head>
  <body>
    <header role="banner">
      <div class="top-bar">
        <div class="container">
          <div class="row">
            <div class="col-9 social">
              <a href="#"><span class="fa fa-twitter"></span></a>
              <a href="#"><span class="fa fa-facebook"></span></a>
              <a href="#"><span class="fa fa-instagram"></span></a>
              <a href="#"><span class="fa fa-youtube-play"></span></a>
              <a href="#"><span class="fa fa-vimeo"></span></a>
              <a href="#"><span class="fa fa-snapchat"></span></a>
            </div>
            <div class="col-3 search-top">
              <!-- <a href="#"><span class="fa fa-search"></span></a> -->
              <form action="{{asset('search')}}" method="GET" enctype="multipart/form-data" class="search-top-form">
                <span class="icon fa fa-search"></span>
                <input name="q" type="text" id="s" placeholder="Type keyword to search...">
              </form>
            </div>
          </div>
        </div>
      </div>

      <div class="container logo-wrap">
        <div class="row pt-5">
          <div class="col-12 text-center">
            <a class="absolute-toggle d-block d-md-none" data-toggle="collapse" href="#navbarMenu" role="button" aria-expanded="false" aria-controls="navbarMenu"><span class="burger-lines"></span></a>
            <h1 class="site-logo"><a href="{{asset('')}}">Tạ Hoàng Bình</a></h1>
          </div>
        </div>
      </div>
      
      <nav class="navbar navbar-expand-md  navbar-light bg-light">
        <div class="container">
          
         
          <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav mx-auto">
              <li class="nav-item">
                <a class="nav-link @yield('active-home')" href="{{asset('')}}">Trang chủ</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle @yield('active-blog')" id="dropdown04" style="cursor: pointer;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">BLOG</a>
                <div class="dropdown-menu" aria-labelledby="dropdown04">
                  <a class="dropdown-item" href="category.html">Asia</a>
                  <a class="dropdown-item" href="category.html">Europe</a>
                  <a class="dropdown-item" href="category.html">Dubai</a>
                  <a class="dropdown-item" href="category.html">Africa</a>
                  <a class="dropdown-item" href="category.html">South America</a>
                </div>

              </li>

              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle @yield('active-categories')" id="dropdown05" style="cursor: pointer;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Thể Loại</a>
                <div class="dropdown-menu" aria-labelledby="dropdown05">
                    @foreach($theloai as $category)
                        <a class="dropdown-item" href="{{asset('')}}category/{{$category->slug}}">{{$category->name}}</a>
                    @endforeach
                </div>

              </li>
              <li class="nav-item">
                <a class="nav-link @yield('active-about')" href="about.html">Giới thiệu</a>
              </li>
              <li class="nav-item">
                <a class="nav-link @yield('active-contact')" href="contact.html">Liên hệ</a>
              </li>
            </ul>
            
          </div>
        </div>
      </nav>
    </header>
    <!-- END header -->

    {{-- Slide_header --}}
    @yield('slide_header')
    {{-- End Slide_header --}}

    <section class="site-section py-sm">
      <div class="container">
        <!-- header_content -->
            @yield('header_content')
        <!-- END header_content -->
        <div class="row blog-entries">

          <!-- content -->
          @yield('content') 
          <!-- end content -->

          <!-- END main-content -->

          <div class="col-md-12 col-lg-4 sidebar" @yield('style')>
            <div class="sidebar-box search-form-wrap">
              <form action="{{asset('search')}}" method="GET" enctype="multipart/form-data" class="search-form">
                <div class="form-group">
                  <span class="icon fa fa-search"></span>
                  <input type="text" name="q" class="form-control" id="s" placeholder="Type a keyword and hit enter">
                </div>
              </form>
            </div>
            <!-- END sidebar-box -->
            <div class="sidebar-box">
              <div class="bio text-center">
                <img src="{{asset('storage/images/user_1.jpg')}}" alt="Image Placeholder" class="img-fluid">
                <div class="bio-body">
                  <h2>Tạ Hoàng Bình</h2>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Exercitationem facilis sunt repellendus excepturi beatae porro debitis voluptate nulla quo veniam fuga sit molestias minus.</p>
                  <p><a href="https://www.facebook.com/hoangbinh.ta" class="btn btn-primary btn-sm">Đến thăm fb</a></p>
                  <p class="social">
                    <a href="#" class="p-2"><span class="fa fa-facebook"></span></a>
                    <a href="#" class="p-2"><span class="fa fa-twitter"></span></a>
                    <a href="#" class="p-2"><span class="fa fa-instagram"></span></a>
                    <a href="#" class="p-2"><span class="fa fa-youtube-play"></span></a>
                  </p>
                </div>
              </div>
            </div>
            <!-- END sidebar-box -->  
            <div class="sidebar-box">
              <h3 class="heading">Popular Posts</h3>
              <div class="post-entry-sidebar">
                <ul>
                  @foreach($best_posts as $best_post)
                    <li>
                    <a href="{{asset('')}}detail/{{$best_post->slug}}">
                      <img src="{{asset('storage/images')}}/{{$best_post->thumbnail}}" alt="Image placeholder" class="mr-4">
                      <div class="text">
                        <h4>{{$best_post->title}}</h4>
                        <div class="post-meta">
                          <span class="mr-2">
                            @php
                                $date = new DateTime($best_post->created_at); // tạo biến mới để đổi kiểu thời gian mặc định của csdl
                                $month_num = $date->format('m'); //lấy ra tháng
                                $convert_month = DateTime::createFromFormat('!m',$month_num); //convert tháng sang kiểu chữ
                            @endphp
                                {{$convert_month->format('F')}} {{$date->format('d')}}, {{$date->format('Y')}}
                          </span><br>
                          <span class="ml-2"><span class="fa fa-comments"></span>
                            @php $dem = 0; @endphp
                            @foreach($comment_counts as $counts)
                                @if($best_post->id == $counts->post_id)
                                    @php $dem++; @endphp
                                @endif
                            @endforeach
                            {{$dem}}
                            <span class="ml-2"><span class="fa fa-thumbs-up"></span>
                            <span id="post-like">{{$best_post->like}}</span>
                            <span class="ml-2"><span class="fa fa-thumbs-down"></span>
                            <span id="post-dislike">{{$best_post->dislike}}</span>
                          </span>
                        </div>
                      </div>
                    </a>
                  </li>
                  @endforeach
                </ul>
              </div>
            </div>
            <!-- END sidebar-box -->

            <div class="sidebar-box">
              <h3 class="heading">Categories</h3>
              <ul class="categories">
                @foreach($theloai as $category)
                <li><a href="{{asset('')}}category/{{$category->slug}}">{{$category->name}}</a></li>
                @endforeach
              </ul>
            </div>
            <!-- END sidebar-box -->

            <div class="sidebar-box">
              <h3 class="heading">Tags</h3>
              <ul class="tags">
                @foreach($tags as $tag)
                <li><a href="{{asset('')}}tag/{{$tag->slug}}">{{$tag->name}}</a></li>
                @endforeach
              </ul>
            </div>
          </div>
          <!-- END sidebar -->

        </div>
      </div>
    </section>
  
    <footer class="site-footer">
      <div class="container">
        <div class="row mb-5">
          <div class="col-md-4">
            <h3>Paragraph</h3>
            <p>
              <img src="{{asset('storage/images/img_1.jpg')}}" alt="Image placeholder" class="img-fluid">
            </p>

            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nisi, accusantium optio unde perferendis eum illum voluptatibus dolore tempora, consequatur minus asperiores temporibus reprehenderit.</p>
          </div>
          <div class="col-md-6 ml-auto">
            <div class="row">
              <div class="col-md-7">
                <h3>Latest Post</h3>
                <div class="post-entry-sidebar">
                  <ul>
                    @foreach($last_posts as $last_post)
                        <li>
                          <a href="{{asset('')}}/detail/{{$last_post->slug}}">
                            <img src="{{asset('storage/images')}}/{{$last_post->thumbnail}}" alt="Image placeholder" class="mr-4">
                            <div class="text">
                              <h4>{{$last_post->title}}</h4>
                              <div class="post-meta">
                                <span class="mr-2">
                                    @php
                                        $date = new DateTime($last_post->created_at); // tạo biến mới để đổi kiểu thời gian mặc định của csdl
                                        $month_num = $date->format('m'); //lấy ra tháng
                                        $convert_month = DateTime::createFromFormat('!m',$month_num); //convert tháng sang kiểu chữ
                                    @endphp
                                        {{$convert_month->format('F')}} {{$date->format('d')}}, {{$date->format('Y')}}
                                </span> &bullet;
                                <span class="ml-2"><span class="fa fa-comments"></span>
                                    @php $dem = 0; @endphp
                                    @foreach($comment_counts as $counts)
                                    @if($last_post->id == $counts->post_id)
                                    @php $dem++; @endphp
                                    @endif
                                    @endforeach
                                    {{$dem}}
                                    <span class="ml-2"><span class="fa fa-thumbs-up"></span>
                                    <span id="post-like">{{$last_post->like}}</span>
                                    <span class="ml-2"><span class="fa fa-thumbs-down"></span>
                                    <span id="post-dislike">{{$last_post->dislike}}</span>
                                </span>
                              </div>
                            </div>
                          </a>
                        </li>
                    @endforeach
                  </ul>
                </div>
              </div>
              <div class="col-md-1"></div>
              
              <div class="col-md-4">

                <div class="mb-5">
                  <h3>Quick Links</h3>
                  <ul class="list-unstyled">
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Travel</a></li>
                    <li><a href="#">Adventure</a></li>
                    <li><a href="#">Courses</a></li>
                    <li><a href="#">Categories</a></li>
                  </ul>
                </div>
                
                <div class="mb-5">
                  <h3>Social</h3>
                  <ul class="list-unstyled footer-social">
                    <li><a href="#"><span class="fa fa-twitter"></span> Twitter</a></li>
                    <li><a href="#"><span class="fa fa-facebook"></span> Facebook</a></li>
                    <li><a href="#"><span class="fa fa-instagram"></span> Instagram</a></li>
                    <li><a href="#"><span class="fa fa-vimeo"></span> Vimeo</a></li>
                    <li><a href="#"><span class="fa fa-youtube-play"></span> Youtube</a></li>
                    <li><a href="#"><span class="fa fa-snapchat"></span> Snapshot</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        {{-- <div class="row">
          <div class="col-md-12">
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
          </div>
        </div> --}}
      </div>
    </footer>
    <!-- END footer -->
    
    <!-- loader -->
    <div id="loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#f4b214"/></svg></div>

    <script src="{{asset('blog_assets/js/jquery-3.2.1.min.js')}}"></script>
    <script src="{{asset('blog_assets/js/jquery-migrate-3.0.0.js')}}"></script>
    <script src="{{asset('blog_assets/js/popper.min.js')}}"></script>
    <script src="{{asset('blog_assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('blog_assets/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('blog_assets/js/jquery.waypoints.min.js')}}"></script>
    <script src="{{asset('blog_assets/js/jquery.stellar.min.js')}}"></script>
    @yield('footer')
    <script src="{{asset('blog_assets/js/main.js')}}"></script>
  </body>
</html>