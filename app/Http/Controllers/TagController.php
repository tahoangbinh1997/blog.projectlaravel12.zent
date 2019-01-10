<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Validator;
use App\Http\Requests\PostRequest;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Event;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = \App\Tag::get();

        return view('admin.tags.list',compact('tags'));
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
        if (isset($request->tag_add_submit)) {
            $validate = Validator::make(
                request()->all(),
                [
                    'name' => 'required|unique:tags,name|min:4|max:15'
                ],

                [
                    'unique' => ':attribute không được trùng với các tag khác',
                    'required' => ':attribute không được để trống',
                    'min' => ':attribute không được nhỏ hơn :min',
                    'max' => ':attribute không được lớn hơn :max'
                ],

                [
                    'name' => 'Tên thẻ tag'
                ]

            );

            if ($validate->fails()) {
                return response()->json(['errors'=>$validate->errors()]);
            }else {
                $tag_add=\App\Tag::create([
                    'name'=>$request->name,
                    'slug'=>str_slug($request->name)
                ]);
                return response()->json([
                    'data'=>$tag_add,
                    'create_success'=>'Thêm mới thẻ tag thành công!!!'
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
        $tag_detail = \App\Tag::find($id);
        return response()->json([
            'data'=>$tag_detail,
            'detail_success'=>'Bạn vừa chọn vào tag: '.$tag_detail->name,
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
        $tag_edit = \App\Tag::find($id);
        return response()->json([
            'data'=>$tag_edit,
            'edit_display'=>'Bạn vừa chọn thành công tag: '.$tag_edit->name,
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
        if (isset($request->tag_edit_submit)) {
            $validate = Validator::make(
                request()->all(),
                [
                    'name' => [
                        'required',
                        Rule::unique('tags')->ignore($id),
                        'min:4',
                        'max:15'
                    ]
                ],

                [
                    'unique' => ':attribute không được trùng với các tag khác',
                    'required' => ':attribute không được để trống',
                    'min' => ':attribute không được nhỏ hơn :min',
                    'max' => ':attribute không được lớn hơn :max'
                ],

                [
                    'name' => 'Tên thẻ tag'
                ]

            );

            if ($validate->fails()) {
                return response()->json(['errors'=>$validate->errors()]);
            }else {
                $tag_edit=\App\Tag::find($id)->update([
                    'name'=>$request->name,
                    'slug'=>str_slug($request->name)
                ]);
                return response()->json([
                    'data'=>$tag_edit,
                    'update_success'=>'Cập nhật thẻ tag thành công!!!'
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
        \App\Tag::find($id)->delete();
        $delete_tag_rela=\App\PostTag::where([
            ['tag_id','=',$id],
        ])->get();
        if (isset($delete_tag_rela)) {
            for ($i=0; $i < count($delete_tag_rela); $i++) { 
                $delete_tag_rela[$i]->delete();
            }
        }
        return response()->json([
            'delete_success'=>'Xóa thẻ tag thành công!!!'
        ]);
    }
}
