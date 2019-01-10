<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Post;
use App\Tag;
use App\PostTag;
use App\Category;
use Validator;
use App\Http\Requests\PostRequest;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Event;


class PostController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function admin_posts(){
        $posts = \App\Post::where([
            ['post_status','=',1],
            ['delete_at','=',0]
        ])->get();
        $categories = \App\Category::get();
        return view('admin.posts.list',compact('posts','categories'));
    }

    public function admin_trash_posts(){
        $posts = \App\Post::where([
            ['post_status','=',0],
            ['delete_at','=',0]
        ])->get();
        $categories = \App\Category::get();
        return view('admin.posts.trash_posts.list',compact('posts','categories'));
    }

    public function admin_delete_posts(){
        $posts = \App\Post::where([
            ['delete_at','=',1],
            ['post_status','=',1]
        ])->get();
        $categories = \App\Category::get();
        return view('admin.posts.delete_posts.list',compact('posts','categories'));
    }

    public function create() {
        $categories=\App\Category::get();
        return view('admin.posts.create',compact('categories'));
    }

    public function store(Request $request) {
        if (isset($_POST['submit_create'])) {
            $validate = Validator::make(
                request()->all(),
                [
                    'title' => 'required|unique:posts,title|min:8|max:255',
                    'description' => 'required|min:8|max:255',
                    'thumbnail' => 'required|image|mimes:jpeg,jpg,png',
                    'content' => 'required',
                    'category_id' => 'required',
                    'post_status' => 'required',
                    'tags' => 'required|array|between:1,7'
                ],

                [
                    'unique' => ':attribute không được trùng với các bài viết khác',
                    'required' => ':attribute không được để trống',
                    'min' => ':attribute không được nhỏ hơn :min',
                    'max' => ':attribute không được lớn hơn :max',
                    'between' => ':attribute chỉ được nằm trong khoảng từ :min đến :max tag',
                    'image' => ':attribute phải là ảnh',
                    'mimes' => ':attribute phải là ảnh có đuôi :mimes'
                ],

                [
                    'title' => 'Tiêu đề bài viết',
                    'description' => 'Mô tả bài viết',
                    'thumbnail' => 'Ảnh bài viết',
                    'content' => 'Nội dung bài viết',
                    'category_id' => 'Thể loại',
                    'post_status' => 'Trạng thái bài viết',
                    'tags' => 'Thẻ tags'
                ]

            );

            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate);
            }
        }
        if (strcmp($request->post_status, 'Publish') == 0) {
            $path = request()->thumbnail->storeAs('images',request()->thumbnail->getClientOriginalName());
            $create_post=\App\Post::create([
                'title' => $request->title,
                'thumbnail' => $path,
                'post_status' => 1,
                'delete_at' => 0,
                'slug' => str_slug($request->title),
                'description' => $request->description,
                'content' => $request->content,
                'category_id' => $request->category_id,
                'user_id' => auth()->id()
            ]);
        }else if (strcmp($request->post_status, 'Trash') == 0) {
            $path = request()->thumbnail->storeAs('images',request()->thumbnail->getClientOriginalName());
            $create_post=\App\Post::create([
                'title' => $request->title,
                'thumbnail' => $path,
                'post_status' => 0,
                'delete_at' => 0,
                'slug' => str_slug($request->title),
                'description' => $request->description,
                'content' => $request->content,
                'category_id' => $request->category_id,
                'user_id' => auth()->id()
            ]);
        }
        for ($i=0; $i < count($request->tags); $i++) { 
            $check_tag = \App\Tag::where('name',$request->tags[$i])->first();
            if ($check_tag != NULL) {
                \App\PostTag::create([
                    'post_id'=>$create_post->id,
                    'tag_id'=>$check_tag->id
                ]);
            } else {
                $create_tag = \App\Tag::create([
                    'name'=> $request->tags[$i],
                    'slug'=> str_slug($request->tags[$i])
                ]);
                \App\PostTag::create([
                    'post_id'=> $create_post->id,
                    'tag_id'=> $create_tag->id
                ]);
            }
        }
        return redirect()->route('admin-posts')->with('create_success','Thêm mới bài viết thành công!');
    }

    public function show($id)
    {
        $post=\App\Post::where([
            ['post_status','=',1],
            ['delete_at','=',0]
        ])->find($id);
        if (!isset($post)) {
            return redirect()->back()->with('detail_show_error','Bài viết bạn vừa chọn có không tồn tại hoặc có thể đã bị xóa');
        }
        $all_posts=\App\Post::get();
        $post_tags=\App\Post::find($id)->tags;
        $category=\App\Post::find($id)->category;
        $category_count=count(\App\Category::find($post->category_id)->posts);
        $user=\App\Post::find($id)->user;
        $post_comments=\App\Post::find($id)->comments;
        $recent_posts=\App\Post::where([ //hiện thì các bài viết liên quan được phép hiển thị lên hệ thống
            ['delete_at','=',0],
            ['post_status','=',1],
            ['category_id','=',$category->id],
        ])->get();
        return view('admin.posts.detail',compact('post','all_posts','post_tags','category','category_count','user','post_comments','recent_posts'));
    }

    public function delete_post_show($id)
    {
        $post=\App\Post::where([
            ['delete_at','=',1],
            ['post_status','=',1],
            ['id','=',$id]
        ])->firstOrFail();
        if (!isset($post)) {
            return redirect()->back()->with('detail_show_error','Bài viết bạn vừa chọn có không tồn tại hoặc có thể đã bị xóa');
        }
        $all_posts=\App\Post::get();
        $post_tags=\App\Post::find($id)->tags;
        $category=\App\Post::find($id)->category;
        $category_count=count(\App\Category::find($post->category_id)->posts);
        $user=\App\Post::find($id)->user;
        $post_comments=\App\Post::find($id)->comments;
        $recent_posts = \App\Post::where([ //hiện thì các bài viết liên quan nhưng lại bị xóa
            ['delete_at','=',1],
            ['post_status','=',1],
            ['category_id','=',$category->id],
        ])->get();
        return view('admin.posts.delete_posts.detail',compact('post','all_posts','post_tags','category','category_count','user','post_comments','recent_posts'));
    }

    public function delete_post_real_delete($id, Request $request) {
        $post_real_delete=\App\Post::where([
            ['post_status','=',1],
            ['delete_at','=',1],
            ['id','=',$id]
        ])->first();
        if (isset($post_real_delete)) {
            $post_real_delete_rela_tags=\App\PostTag::where([
                ['post_id','=',$id],
            ])->get();
            if (isset($post_real_delete_rela_tags)) {
                for ($i=0; $i < count($post_real_delete_rela_tags); $i++) { 
                    $post_real_delete_rela_tags[$i]->delete();
                }
            }
            $post_real_delete->delete();

            return response()->json([
                'real_delete_success'=>'Xóa bài viết thành công, bài viết đã bị xóa hẳn khỏi cơ sở dữ liệu!'
            ]);
        }
    }

    public function trash_post_show($id)
    {
        $post=\App\Post::where([
            ['delete_at','=',0],   //chưa bị delete
            ['post_status','=',0], //bài trash
            ['id','=',$id]
        ])->firstOrFail();
        if (!isset($post)) {
            return redirect()->back()->with('detail_show_error','Bài viết bạn vừa chọn có không tồn tại hoặc có thể đã bị xóa');
        }
        $all_posts=\App\Post::get();
        $post_tags=\App\Post::find($id)->tags;
        $category=\App\Post::find($id)->category;
        $category_count=count(\App\Category::find($post->category_id)->posts);
        $user=\App\Post::find($id)->user;
        $post_comments=\App\Post::find($id)->comments;
        $recent_posts = \App\Post::where([ //hiện thì các bài viết liên quan nhưng lại bị xóa
            ['delete_at','=',0],
            ['post_status','=',0],
            ['category_id','=',$category->id],
        ])->get();
        return view('admin.posts.trash_posts.detail',compact('post','all_posts','post_tags','category','category_count','user','post_comments','recent_posts'));
    }

    public function trash_post_edit($id)
    {
        $post=\App\Post::where([
            ['post_status','=',0],
            ['delete_at','=',0]
        ])->find($id);
        if (!isset($post)) {
            return redirect()->back()->with('detail_show_error','Bài viết bạn vừa chọn có không tồn tại hoặc có thể đã bị xóa');
        }
        $post_tags=\App\Post::find($id)->tags;
        $categories = \App\Category::get();
        $category=\App\Post::find($id)->category;
        return view('admin.posts.trash_posts.edit',compact('post','post_tags','categories','category'));
    }

    public function trash_post_update($id, Request $request)
    {
        if (isset($_POST['trash_post_submit_update'])) {
            $validate = Validator::make( //kiểm tra điều kiện kia cập nhật thông tin bài viết
                request()->all(),
                [
                    'title' => [
                        'required',
                        Rule::unique('posts')->ignore($id),
                        'min:8',
                        'max:255'
                    ],
                    'thumbnail' => 'image|mimes:jpeg,bmp,png',
                    'description' => 'required',
                    'content' => 'required',
                    'category_id' => 'required',
                    'tags' => 'required|array|between:1,8'
                ],

                [
                    'unique' => ':attribute không được trùng với các bài viết khác',
                    'required' => ':attribute không được để trống',
                    'min' => ':attribute không được nhỏ hơn :min',
                    'max' => ':attribute không được lớn hơn :max',
                    'between' => ':attribute chỉ được nằm trong khoảng từ :min đến :max tag',
                    'image' => ':attribute phải là ảnh',
                    'mimes' => ':attribute phải là ảnh có đuôi jpeg,bmp,png'
                ],

                [
                    'title' => 'Tiêu đề bài viết',
                    'description' => 'Mô tả bài viết',
                    'thumbnail' => 'Ảnh bài viết',
                    'content' => 'Nội dung bài viết',
                    'category_id' => 'Thể loại',
                    'tags' => 'Thẻ tags'
                ]

            );

            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate);
            }
        }

        if ($request->thumbnail != NULL) {
            $path = request()->thumbnail->storeAs('images',request()->thumbnail->getClientOriginalName());
                $update_post=\App\Post::find($id)->update([
                    'title' => $request->title,
                    'thumbnail' => $path,
                    'slug' => str_slug($request->title),
                    'description' => $request->description,
                    'content' => $request->content,
                    'category_id' => $request->category_id,
                    'user_id' => auth()->id()
                ]);
        }else {
            $update_post=\App\Post::find($id)->update([
                'title' => $request->title,
                'slug' => str_slug($request->title),
                'description' => $request->description,
                'content' => $request->content,
                'category_id' => $request->category_id,
                'user_id' => auth()->id()
            ]);
        }

        $current_post=\App\Post::find($id);
        $post_tags=\App\Post::find($id)->tags; //lấy ra những thẻ tag hiện tại có trong bài post
        $delete_tags = explode(',', $request->delete_tags);
        for ($i=0; $i < count($delete_tags); $i++) { 
            $check_tag_delete = $post_tags->where('name',$delete_tags[$i])->first();
            if ($check_tag_delete != NULL) {
                \App\PostTag::where([
                    ['post_id','=',$current_post->id],
                    ['tag_id','=',$check_tag_delete->id]
                ])->delete();
            }
        }
        for ($i=0; $i < count($request->tags); $i++) { 
            $check_tag_old = $post_tags->where('name',$request->tags[$i])->first(); //đoạn này là truy vấn vào biến mảng $post_tags để lấy ra bản ghi nếu như mảng tags truyền lên controller có dữ liệu giống với tên của thẻ tag cũ trong bài post đó
            if ($check_tag_old == NULL) { // nếu như không giống với tag cũ trong cơ sở dữ liệu
                $check_tag = \App\Tag::where('name',$request->tags[$i])->first();
                if ($check_tag == NULL) {
                    $create_tag = \App\Tag::create([
                        'name'=> $request->tags[$i],
                        'slug'=> str_slug($request->tags[$i])
                    ]);
                    \App\PostTag::create([
                        'post_id'=> $id,
                        'tag_id'=> $create_tag->id
                    ]);
                } else {
                    \App\PostTag::create([
                        'post_id'=> $id,
                        'tag_id'=> $check_tag->id
                    ]);
                }
            }
        }
        return redirect()->route('admin-trash-posts')->with('update_success','Cập nhật thông tin bài viết thành công!');
    }

    public function trash_post_publish($id,Request $request) 
    {
        if (isset($publish_success)) {
            unset($publish_success);
        }
        $post_delete=\App\Post::where([
            ['post_status','=',0],
            ['delete_at','=',0],
            ['id','=',$id]
        ]);
        if (isset($post_delete)) {
            $post_delete->update([
                'post_status'=>1
            ]);
            return response()->json([
                'publish_success'=>'Đẩy bài viết thành công, bài viết sẽ được đẩy vào mục bài viết chính!'
            ]);
        }
    }

    public function trash_post_real_delete($id, Request $request) 
    {
        $trash_post_real_delete=\App\Post::where([
            ['post_status','=',0],  //Bài Viết Trash
            ['delete_at','=',0],    //Bài Viết Chưa Bị Xóa
            ['id','=',$id]
        ])->first();
        if (isset($trash_post_real_delete)) {
            $trash_post_real_delete_rela_tags=\App\PostTag::where([
                ['post_id','=',$id],
            ])->get();
            if (isset($trash_post_real_delete_rela_tags)) {
                for ($i=0; $i < count($trash_post_real_delete_rela_tags); $i++) { 
                    $trash_post_real_delete_rela_tags[$i]->delete();
                }
            }
            $trash_post_real_delete->delete();

            return response()->json([
                'real_delete_success'=>'Xóa bài viết thành công, bài viết đã bị xóa hẳn khỏi cơ sở dữ liệu!'
            ]);
        }
    }

    public function edit($id)
    {
        $post=\App\Post::where([
            ['post_status','=',1],
            ['delete_at','=',0]
        ])->find($id);
        if (!isset($post)) {
            return redirect()->back()->with('detail_show_error','Bài viết bạn vừa chọn có không tồn tại hoặc có thể đã bị xóa');
        }
        $post_tags=\App\Post::find($id)->tags;
        $categories = \App\Category::get();
        $category=\App\Post::find($id)->category;
        return view('admin.posts.edit',compact('post','post_tags','categories','category'));
    }

    public function update($id, Request $request) {
        if (isset($_POST['submit_update'])) {
            $validate = Validator::make( //kiểm tra điều kiện kia cập nhật thông tin bài viết
                request()->all(),
                [
                    'title' => [
                        'required',
                        Rule::unique('posts')->ignore($id),
                        'min:8',
                        'max:255'
                    ],
                    'thumbnail' => 'image|mimes:jpeg,bmp,png',
                    'description' => 'required',
                    'content' => 'required',
                    'category_id' => 'required',
                    'post_status' => 'required',
                    'tags' => 'required|array|between:1,8'
                ],

                [
                    'unique' => ':attribute không được trùng với các bài viết khác',
                    'required' => ':attribute không được để trống',
                    'min' => ':attribute không được nhỏ hơn :min',
                    'max' => ':attribute không được lớn hơn :max',
                    'between' => ':attribute chỉ được nằm trong khoảng từ :min đến :max tag',
                    'image' => ':attribute phải là ảnh',
                    'mimes' => ':attribute phải là ảnh có đuôi jpeg,bmp,png'
                ],

                [
                    'title' => 'Tiêu đề bài viết',
                    'description' => 'Mô tả bài viết',
                    'thumbnail' => 'Ảnh bài viết',
                    'content' => 'Nội dung bài viết',
                    'category_id' => 'Thể loại',
                    'post_status' => 'Trạng thái bài viết',
                    'tags' => 'Thẻ tags'
                ]

            );

            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate);
            }
        }

        if ($request->thumbnail != NULL) {
            if (strcmp($request->post_status, 'Publish') == 0) {
                $path = request()->thumbnail->storeAs('images',request()->thumbnail->getClientOriginalName());
                $update_post=\App\Post::find($id)->update([
                    'title' => $request->title,
                    'thumbnail' => $path,
                    'post_status' => 1,
                    'delete_at' => 0,
                    'slug' => str_slug($request->title),
                    'description' => $request->description,
                    'content' => $request->content,
                    'category_id' => $request->category_id,
                    'user_id' => auth()->id()
                ]);
            }else if (strcmp($request->post_status, 'Trash') == 0) {
                $path = request()->thumbnail->storeAs('images',request()->thumbnail->getClientOriginalName());
                $update_post=\App\Post::find($id)->update([
                    'title' => $request->title,
                    'thumbnail' => $path,
                    'post_status' => 0,
                    'delete_at' => 0,
                    'slug' => str_slug($request->title),
                    'description' => $request->description,
                    'content' => $request->content,
                    'category_id' => $request->category_id,
                    'user_id' => auth()->id()
                ]);
            }
        }else {
            if (strcmp($request->post_status, 'Publish') == 0) {
                $update_post=\App\Post::find($id)->update([
                    'title' => $request->title,
                    'post_status' => 1,
                    'delete_at' => 0,
                    'slug' => str_slug($request->title),
                    'description' => $request->description,
                    'content' => $request->content,
                    'category_id' => $request->category_id,
                    'user_id' => auth()->id()
                ]);
            }else if (strcmp($request->post_status, 'Trash') == 0) {
                $update_post=\App\Post::find($id)->update([
                    'title' => $request->title,
                    'post_status' => 0,
                    'delete_at' => 0,
                    'slug' => str_slug($request->title),
                    'description' => $request->description,
                    'content' => $request->content,
                    'category_id' => $request->category_id,
                    'user_id' => auth()->id()
                ]);
            }
        }

        $current_post=\App\Post::find($id);
        $post_tags=\App\Post::find($id)->tags; //lấy ra những thẻ tag hiện tại có trong bài post
        $delete_tags = explode(',', $request->delete_tags);
        for ($i=0; $i < count($delete_tags); $i++) { 
            $check_tag_delete = $post_tags->where('name',$delete_tags[$i])->first();
            if ($check_tag_delete != NULL) {
                \App\PostTag::where([
                    ['post_id','=',$current_post->id],
                    ['tag_id','=',$check_tag_delete->id]
                ])->delete();
            }
        }
        for ($i=0; $i < count($request->tags); $i++) { 
            $check_tag_old = $post_tags->where('name',$request->tags[$i])->first(); //đoạn này là truy vấn vào biến mảng $post_tags để lấy ra bản ghi nếu như mảng tags truyền lên controller có dữ liệu giống với tên của thẻ tag cũ trong bài post đó
            if ($check_tag_old == NULL) { // nếu như không giống với tag cũ trong cơ sở dữ liệu
                $check_tag = \App\Tag::where('name',$request->tags[$i])->first();
                if ($check_tag == NULL) {
                    $create_tag = \App\Tag::create([
                        'name'=> $request->tags[$i],
                        'slug'=> str_slug($request->tags[$i])
                    ]);
                    \App\PostTag::create([
                        'post_id'=> $id,
                        'tag_id'=> $create_tag->id
                    ]);
                } else {
                    \App\PostTag::create([
                        'post_id'=> $id,
                        'tag_id'=> $check_tag->id
                    ]);
                }
            }
        }
        return redirect()->route('admin-posts')->with('update_success','Cập nhật thông tin bài viết thành công!');
    }

    public function delete($id, Request $request) {
        if (isset($delete_success)) {
            unset($delete_success);
        }
        $post_delete=\App\Post::where([
            ['post_status','=',1],
            ['delete_at','=',0],
            ['id','=',$id]
        ]);
        if (isset($post_delete)) {
            $post_delete->update([
                'delete_at'=>1
            ]);
            return response()->json([
                'delete_success'=>'Xóa bài viết thành công, bài viết sẽ được đẩy vào mục bài viết bị xóa!'
            ]);
        }
    }

    public function delete_post_upback($id, Request $request) {
        if (isset($upback_success)) {
            unset($upback_success);
        }
        $post_delete=\App\Post::where([
            ['delete_at','=',1],
            ['id','=',$id]
        ]);
        if (isset($post_delete)) {
            $post_delete->update([
                'delete_at'=>0
            ]);
            return response()->json([
                'upback_success'=>'Đẩy bài viết lên hệ thống thành công, vào phần Quản lý bài viết để xem!'
            ]);
        }
    }
    
}



















    // public function getListPost(Request $request){
    //     return Datatables::of(Post::query(),Category::query())->addColumn('action',function($post){
    //         return '
    //         <button type="button" data-url="'. route('post.show',$post->id) .'"​ class="btn btn-xs btn-primary btn-detail" data-toggle="modal" data-target="#scrollmodal-show">
    //         <i class="fa fa-table"></i>
    //         </button>
    //         <a href="#delete-'.$post->id.'" class="btn btn-xs btn-warning"><i class="fa fa-trash-o"></i></a>
    //         <button type="button" data-url="'. route('post.edit',$post->id) .'"​ class="btn btn-xs btn-primary btn-update" data-toggle="modal" data-target="#scrollmodal-edit">
    //         <i class="fa fa-edit"></i>
    //         </button>';
    //     })
    //     ->editColumn('thumbnail', function(Post $post) {
    //         return '<img width="150px" height="150px" src="../storage/images/'.$post->thumbnail.'" alt=""/>';
    //     })
    //     ->addColumn('category_name', function(Post $post){
    //         return $post->category->name;
    //     })
    //     ->addColumn('tag_name', function(Post $post){
    //         $tags=$post->tags;
    //         $chuoi = array();
    //         foreach ($tags as $tag) {
    //             $chuoi[] = $tag->name;
    //         }
    //         return $chuoi;
    //     })
    //     ->rawColumns(['thumbnail', 'action','description','content','category_name','tag_name'])->make(true);
    // }