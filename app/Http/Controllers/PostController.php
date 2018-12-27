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


class PostController extends Controller
{
    public function index(){
    	return view('post');
    }

    public function show($id)
    {
        $post=Post::find($id);
        $tag=Post::find($id)->tags;
        $categories = Category::get();
        $category=Post::find($id)->category;
        return response()->json(['data'=>$post,'data1'=>$category,'data2'=>$tag,'data3'=>$categories],200); // 200 là mã lỗi
    }

    public function edit($id)
    {
        $post=Post::find($id);
        $tag=Post::find($id)->tags;
        $categories = Category::get();
        $category=Post::find($id)->category;
        return response()->json(['data'=>$post,'data1'=>$category,'data2'=>$tag,'data3'=>$categories],200); // 200 là mã lỗi
    }

    public function getListPost(Request $request){
        return Datatables::of(Post::query(),Category::query())->addColumn('action',function($post){
            return '
            <button type="button" data-url="'. route('post.show',$post->id) .'"​ class="btn btn-xs btn-primary btn-detail" data-toggle="modal" data-target="#scrollmodal-show">
            <i class="fa fa-table"></i>
            </button>
            <a href="#delete-'.$post->id.'" class="btn btn-xs btn-warning"><i class="fa fa-trash-o"></i></a>
            <button type="button" data-url="'. route('post.edit',$post->id) .'"​ class="btn btn-xs btn-primary btn-update" data-toggle="modal" data-target="#scrollmodal-edit">
            <i class="fa fa-edit"></i>
            </button>';
        })
        ->editColumn('thumbnail', function(Post $post) {
            return '<img width="150px" height="150px" src="../storage/images/'.$post->thumbnail.'" alt=""/>';
        })
        ->addColumn('category_name', function(Post $post){
            return $post->category->name;
        })
        ->addColumn('tag_name', function(Post $post){
            $tags=$post->tags;
            $chuoi = array();
            foreach ($tags as $tag) {
                $chuoi[] = $tag->name;
            }
            return $chuoi;
        })
        ->rawColumns(['thumbnail', 'action','description','content','category_name','tag_name'])->make(true);
    }

    public function update(Request $request,$id){
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $post=Post::find($id)->update($request->all());
        return response()->json(['data'=>$post],200);
    }
}
