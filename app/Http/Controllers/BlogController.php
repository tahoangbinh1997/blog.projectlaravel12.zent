<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\CommentRequest;

use Validator;

use Illuminate\Support\Facades\Event;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $top_posts = \App\Post::where([
            ['post_status','=',1],
            ['delete_at','=',0]
        ])->orderBy('view_count','desc')->get();
        $posts = \App\Post::where([
            ['post_status','=',1],
            ['delete_at','=',0]
        ])->Paginate(6);
        $sum_posts = $posts->count();

        $categories = \App\Category::get();

        return view('index',compact('posts','categories','tags','top_posts','sum_posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $slug)
    {
        $post = \App\Post::where([
            ['post_status','=',1],
            ['delete_at','=',0],
            ['slug', $slug]
        ])->firstOrFail();
        $post->view_count = $post->view_count-1;
        $post->save();
        if (isset($_POST['submit'])) {
            $validate = Validator::make(
                $request->all(),
                [
                    'name' => 'required|min:5|max:255',
                    'email' => 'required|min:8|email',
                    'comments_pic' => 'required|',
                    'message' => 'required'
                ],

                [
                    'required' => ':attribute không được để trống',
                    'min' => ':attribute không được nhỏ hơn :min',
                    'max' => ':attribute không được lớn hơn :max',
                    'email' => ':attribute phải điền đúng định dạng'
                ],

                [
                    'name' => 'Họ Tên',
                    'email' => 'Email',
                    'comments_pic' => 'Ảnh',
                    'message' => 'Message'
                ]

            );

            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate);
            }
        }
        $path = request()->comments_pic->storeAs('images',request()->comments_pic->getClientOriginalName());
        \App\Comment::create([
            'name' => request('name'),
            'email' => request('email'),
            'comments_pic' => $path,
            'message' => request('message'),
            'user_id' => $post->id,
            'post_id' => $post->id
        ]);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$slug)
    {
        $post = \App\Post::where([
            ['post_status','=',1],
            ['delete_at','=',0],
            ['slug', $slug]
        ])->firstOrFail();
        $post->view_count = $post->view_count+1;
        if (!isset($_GET['no_view'])) {
            $post->save();
        }
        $category = \App\Post::find($post->id)->category;
        $next = \App\Post::where([
            ['post_status','=',1],
            ['delete_at','=',0],
            ['id', '>', $post->id]
        ])->orderBy('id')->first();
        $previous = \App\Post::where([
            ['post_status','=',1],
            ['delete_at','=',0],
            ['id', '<', $post->id]
        ])->orderBy('id','desc')->first();
        $maxpost = \App\Post::where([
            ['post_status','=',1],
            ['delete_at','=',0]
        ])->max('id');
        $minpost = \App\Post::where([
            ['post_status','=',1],
            ['delete_at','=',0]
        ])->min('id');
        $posts = \App\Post::where([
            ['post_status','=',1],
            ['delete_at','=',0]
        ])->get();
        $comments = \App\Post::find($post->id)->comments()->Paginate(3);
        $post_tags = \App\Post::find($post->id)->tags;
        $like_post_ip = \App\Like::where('ip_client', $request->ip())->first();
        $dislike_post_ip = \App\Dislike::where('ip_client', $request->ip())->first();
        if (isset($like_post_ip)) {
            $rela_post_like = \App\PostLike::where('post_id','=',$post->id)->where('like_id','=',$like_post_ip->id)->first();
            if (isset($dislike_post_ip)) {
                $rela_post_dislike = \App\PostDislike::where('post_id','=',$post->id)->where('dislike_id','=',$dislike_post_ip->id)->first();
            }
        }else {
            if (isset($dislike_post_ip)) {
                $rela_post_dislike = \App\PostDislike::where('post_id','=',$post->id)->where('dislike_id','=',$dislike_post_ip->id)->first();
            }
        }
        if (isset($rela_post_like)) {
            return view('detail.single-standard',compact('post','category','posts','next','previous','maxpost','minpost','comments','post_tags','rela_post_like'));
        }else if (isset($rela_post_dislike)) {
            return view('detail.single-standard',compact('post','category','posts','next','previous','maxpost','minpost','comments','post_tags','rela_post_dislike'));
        }else {
            return view('detail.single-standard',compact('post','category','posts','next','previous','maxpost','minpost','comments','post_tags'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function category($slug) {

        $category = \App\Category::where('slug', $slug)->firstOrFail();

        $category_posts = \App\Category::where('id', $category->id)->firstOrFail()->posts();

        $posts = $category_posts->where([ //nếu bài post có trường post_status = 0 (post rác) và delete_at = 1 (post đã bị xóa)
            ['post_status','=',1],
            ['delete_at','=',0]
        ])->Paginate(1);

        $sum_posts = $posts->count();

        $categories = \App\Category::get();

        return view('category.index',compact('posts','category','sum_posts','categories'));
    }

    public function tag($slug) {

        $post_tag = \App\Tag::where('slug',$slug)->firstOrFail();

        $tag_posts_all = \App\Tag::where('id', $post_tag->id)->firstOrFail()->posts();

        $tag_posts = $tag_posts_all->where([ //nếu bài post có trường post_status = 0 (post rác) và delete_at = 1 (post đã bị xóa)
            ['post_status','=',1],
            ['delete_at','=',0]
        ])->Paginate(2);

        $categories = \App\Category::get();

        return view('tag.post-tag',compact('post_tag','tag_posts','categories'));
    }

    public function search() {
        $q = $_GET['q'];
        $posts = \App\Post::where([ //nếu bài post có trường post_status = 0 (post rác) và delete_at = 1 (post đã bị xóa)
            ['post_status','=',1],
            ['delete_at','=',0],
            ['title', 'like', '%'.$q.'%']
        ])->Paginate(3);
        // dd($posts);
        $categories = \App\Category::get();
        return view('search.search',compact('posts','categories','q'));
    }

    public function like_posts(Request $request,$slug) {
        $ipClient = $request->getClientIp(); //lấy ra địa chỉ ip hiện tại
        $post = \App\Post::where('slug',$slug)->firstOrFail(); //lấy ra bài post hiện tại
        $ip_like = \App\Like::where('ip_client','=',$ipClient)->first(); //lấy ra địa chỉ ip đã like bài post đó dựa trên địa chỉ ip hiện tại
        $ip_dislike = \App\Dislike::where('ip_client','=',$ipClient)->first(); //lấy ra địa chỉ ip đã dislike bài post đó dựa trên địa chỉ ip hiện tại
        if ($ip_like == NULL) {
            $create = \App\Like::create([
                'ip_client' => $ipClient,
            ]); //tạo bản ghi chứa địa chỉ ip đã like đó
            \App\PostLike::create([
                'post_id' => $post->id,
                'like_id' => $create->id
            ]); //tạo mối quan hệ giữa bài post đã được like với địa chỉ ip đó
            $post->like = $post->like+1; //tăng số like của bản ghi đó lên +1
            $post->save();
            if ($ip_dislike != NULL) {
                $rela_post_dislike = \App\PostDislike::where('post_id','=',$post->id)->where('dislike_id','=',$ip_dislike->id)->first(); // lấy ra mối quan hệ của bài post đã dislike hiện tại và địa chỉ ip đó
                if ($rela_post_dislike != NULL) {
                    $rela_post_dislike->delete();
                }
                if (\App\PostDislike::where('dislike_id','=',$ip_dislike->id)->first() == NULL) { //nếu trong trường hợp địa chỉ ip đó đã không còn dislike bài viết nào nữa
                    $ip_dislike->delete(); // xóa luôn bản ghi của địa chỉ ip đã dislike đó
                }
                $post->dislike = $post->dislike-1; //giảm số dislike của bản ghi đó lên -1
                $post->save();
                return response()->json([
                    'post_res' => $post
                ]);
            }else {
                return response()->json([
                    'post_res' => $post
                ]);
            }
        } else {
            $rela_post_like = \App\PostLike::where('post_id','=',$post->id)->where('like_id','=',$ip_like->id)->first(); // lấy ra mối quan hệ của bài post đã like hiện tại và địa chỉ ip đó
            if ($rela_post_like == NULL) {
                \App\PostLike::create([
                    'post_id' => $post->id,
                    'like_id' => $ip_like->id
                ]); //tạo mối quan hệ giữa bài post đã được like với địa chỉ ip đó
                $post->like = $post->like+1; //tăng số like của bản ghi đó lên +1
                $post->save();
                return response()->json([
                    'post_res' => $post
                ]);
            } else {
                $rela_post_like->delete(); // xóa mối quan hệ của bài post đã được like đó với địa chỉ ip hiện tại
                if (\App\PostLike::where('like_id','=',$ip_like->id)->first() == NULL) { //nếu trong trường hợp địa chỉ ip đó đã không còn like bài viết nào nữa
                    $ip_like->delete(); // xóa luôn bản ghi của địa chỉ ip đã like đó
                }
                $post->like = $post->like-1; //giảm số like của bản ghi đó lên -1
                $post->save();
                return response()->json([
                    'post_res' => $post
                ]);
            }
        }
    }

    public function dislike_posts(Request $request,$slug) {
        $ipClient = $request->getClientIp(); //lấy ra địa chỉ ip hiện tại
        $post = \App\Post::where('slug',$slug)->firstOrFail(); //lấy ra bài post hiện tại
        $ip_like = \App\Like::where('ip_client','=',$ipClient)->first(); //lấy ra địa chỉ ip đã like bài post đó dựa trên địa chỉ ip hiện tại
        $ip_dislike = \App\Dislike::where('ip_client','=',$ipClient)->first(); //lấy ra địa chỉ ip đã dislike bài post đó dựa trên địa chỉ ip hiện tại
        if ($ip_dislike == NULL) {
            $create = \App\Dislike::create([
                'ip_client' => $ipClient,
            ]); //tạo bản ghi chứa địa chỉ ip đã dislike đó
            \App\PostDislike::create([
                'post_id' => $post->id,
                'dislike_id' => $create->id
            ]); //tạo mối quan hệ giữa bài post đã được dislike với địa chỉ ip đó
            $post->dislike = $post->dislike+1; //tăng số dislike của bản ghi đó lên +1
            $post->save();
            if ($ip_like != NULL) {
                $rela_post_like = \App\PostLike::where('post_id','=',$post->id)->where('like_id','=',$ip_like->id)->first(); // lấy ra mối quan hệ của bài post đã like hiện tại và địa chỉ ip đó
                if ($rela_post_like != NULL) {
                    $rela_post_like->delete();
                }
                if (\App\Postlike::where('like_id','=',$ip_like->id)->first() == NULL) { //nếu trong trường hợp địa chỉ ip đó đã không còn like bài viết nào nữa
                    $ip_like->delete(); // xóa luôn bản ghi của địa chỉ ip đã like đó
                }
                $post->like = $post->like-1; //giảm số like của bản ghi đó lên -1
                $post->save();
                return response()->json([
                    'post_res' => $post
                ]);
            }else {
                return response()->json([
                    'post_res' => $post
                ]);
            }
        } else {
            $rela_post_dislike = \App\PostDislike::where('post_id','=',$post->id)->where('dislike_id','=',$ip_dislike->id)->first(); // lấy ra mối quan hệ của bài post đã dislike hiện tại và địa chỉ ip đó
            if ($rela_post_dislike == NULL) {
                \App\PostDislike::create([
                    'post_id' => $post->id,
                    'dislike_id' => $ip_dislike->id
                ]); //tạo mối quan hệ giữa bài post đã được dislike với địa chỉ ip đó
                $post->dislike = $post->dislike+1; //tăng số dislike của bản ghi đó lên +1
                $post->save();
                return response()->json([
                    'post_res' => $post
                ]);
            } else {
                $rela_post_dislike->delete(); // xóa mối quan hệ của bài post đã được dislike đó với địa chỉ ip hiện tại
                if (\App\PostDislike::where('dislike_id','=',$ip_dislike->id)->first() == NULL) { //nếu trong trường hợp địa chỉ ip đó đã không còn dislike bài viết nào nữa
                    $ip_dislike->delete(); // xóa luôn bản ghi của địa chỉ ip đã dislike đó
                }
                $post->dislike = $post->dislike-1; //giảm số dislike của bản ghi đó lên -1
                $post->save();
                return response()->json([
                    'post_res' => $post
                ]);
            }
        }
    }
}
