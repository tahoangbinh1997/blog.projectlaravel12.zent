<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Validator;
use App\Http\Requests\PostRequest;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Event;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = \App\Category::get();

        return view('admin.categories.list',compact('categories'));
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
    public function store(Request $request)
    {
        // dd($request->description);
        if (isset($request->category_add_submit)) {
            $validate = Validator::make(
                request()->all(),
                [
                    'name' => 'required|unique:categories,name|min:4|max:15',
                    'description' => 'required'
                ],

                [
                    'unique' => ':attribute không được trùng với các tag khác',
                    'required' => ':attribute không được để trống',
                    'min' => ':attribute không được nhỏ hơn :min',
                    'max' => ':attribute không được lớn hơn :max'
                ],

                [
                    'name' => 'Tên thể loại',
                    'description' => 'Mô tả của thể loại'
                ]

            );

            if ($validate->fails()) {
                return response()->json(['errors'=>$validate->errors()]);
            }else {
                $category_add=\App\Category::create([
                    'name'=>$request->name,
                    'slug'=>str_slug($request->name),
                    'description'=>$request->description,
                ]);
                return response()->json([
                    'data'=>$category_add,
                    'create_success'=>'Thêm mới thể loại thành công!!!'
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category_detail = \App\Category::find($id);
        return response()->json([
            'data'=>$category_detail,
            'detail_success'=>'Bạn vừa chọn vào loại: '.$category_detail->name,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category_edit = \App\Category::find($id);
        return response()->json([
            'data'=>$category_edit,
            'edit_display'=>'Bạn vừa chọn thành công thể loại: '.$category_edit->name,
        ]);
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
        if (isset($request->category_edit_submit)) {
            $validate = Validator::make(
                request()->all(),
                [
                    'name' => [
                        'required',
                        Rule::unique('categories')->ignore($id),
                        'min:4',
                        'max:15'
                    ],
                    'description' => 'required'
                ],

                [
                    'unique' => ':attribute không được trùng với các tag khác',
                    'required' => ':attribute không được để trống',
                    'min' => ':attribute không được nhỏ hơn :min',
                    'max' => ':attribute không được lớn hơn :max'
                ],

                [
                    'name' => 'Tên thể loại',
                    'description' => 'Mô tả thể loại'
                ]

            );

            if ($validate->fails()) {
                return response()->json(['errors'=>$validate->errors()]);
            }else {
                $category_edit=\App\Category::find($id)->update([
                    'name'=>$request->name,
                    'slug'=>str_slug($request->name),
                    'description'=>$request->description
                ]);
                return response()->json([
                    'data'=>$category_edit,
                    'update_success'=>'Cập nhật thể loại thành công!!!'
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \App\Category::find($id)->delete();
        $delete_category_rela=\App\Post::where([
            ['category_id','=',$id],
        ])->get();
        if (isset($delete_category_rela)) {
            for ($i=0; $i < count($delete_category_rela); $i++) { 
                $delete_category_rela[$i]->delete();
            }
        }
        return response()->json([
            'delete_success'=>'Xóa thể loại thành công!!!'
        ]);
    }
}
