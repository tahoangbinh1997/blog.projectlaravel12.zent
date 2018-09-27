<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\CommentRequest;

use Validator;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $top_posts = \App\Post::orderBy('view_count','desc')->get();
        $posts = \App\Post::Paginate(6);
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
        $post = \App\Post::where('slug', $slug)->firstOrFail();
        $post->view_count = $post->view_count-1;
        $post->save();
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        if (isset($_POST['submit'])) {
            $validate = Validator::make(
                $request->all(),
                [
                    'name' => 'required|min:5|max:255',
                    'email' => 'required|min:8|email',
                    'website' => 'required|',
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
                    'website' => 'Website',
                    'message' => 'Message'
                ]

            );

            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate);
            }
        }
        \App\Comment::create([
            'name' => request('name'),
            'email' => request('email'),
            'website' => request('website'),
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
        $post = \App\Post::where('slug', $slug)->firstOrFail();
        $post->view_count = $post->view_count+1;
        if (!isset($_GET['no_view'])) {
            $post->save();
        }
        $category = \App\Post::find($post->id)->category;
        $next = \App\Post::where('id', '>', $post->id)->orderBy('id')->first();
        $previous = \App\Post::where('id', '<', $post->id)->orderBy('id','desc')->first();
        $maxpost = \App\Post::max('id');
        $minpost = \App\Post::min('id');
        $posts = \App\Post::get();
        $comments = \App\Post::find($post->id)->comments()->Paginate(3);
        $post_tags = \App\Post::find($post->id)->tags;

        return view('detail.single-standard',compact('post','category','posts','next','previous','maxpost','minpost','comments','post_tags'));
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

        $posts = \App\Category::where('id', $category->id)->firstOrFail()->posts()->Paginate(1);

        $sum_posts = $posts->count();

        $categories = \App\Category::get();

        return view('category.index',compact('posts','category','sum_posts','categories'));
    }

    public function tag($slug) {

        $post_tag = \App\Tag::where('slug',$slug)->firstOrFail();

        $tag_posts = \App\Tag::where('id', $post_tag->id)->firstOrFail()->posts()->Paginate(2);

        $categories = \App\Category::get();

        return view('tag.post-tag',compact('post_tag','tag_posts','categories'));
    }

    public function search() {
        $q = $_GET['q'];
        $posts = \App\Post::where('title', 'like', '%'.$q.'%')->Paginate(3);
        // dd($posts);
        $categories = \App\Category::get();
        return view('search.search',compact('posts','categories','q'));
    }
}
