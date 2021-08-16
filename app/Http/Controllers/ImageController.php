<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $all = Image::all();
        $all = Image::paginate(3);
        $cols = ['校園印象圖片', '顯示', '刪除', '操作'];
        $rows = [];

        foreach ($all as $a) {
            $tmp = [
                [
                    'tag' => 'img',
                    'src' => $a->img,
                    'style' => 'width:100px;height:68px;'
                ],
                [
                    'tag' => 'button',
                    'type' => 'button',
                    'btn_color' => 'btn-success',
                    'btn_action' => 'show',
                    'id' => $a->id,
                    'text' => ($a->sh == 1) ? '顯示' : '隱藏',
                ],
                [
                    'tag' => 'button',
                    'type' => 'button',
                    'btn_color' => 'btn-danger',
                    'btn_action' => 'delete',
                    'id' => $a->id,
                    'text' => '刪除',
                ],
                [
                    'tag' => 'button',
                    'type' => 'button',
                    'btn_color' => 'btn-info',
                    'btn_action' => 'edit',
                    'id' => $a->id,
                    'text' => '編輯',
                ]
            ];
            $rows[] = $tmp;
        }
        // dd($rows);
        $this->view['header'] = '校園映像圖片管理';
        $this->view['module'] = 'Image';
        $this->view['cols'] = $cols;
        $this->view['rows'] = $rows;
        $this->view['paginate'] = $all->links();
        // dd($all);
        return view('backend.module', $this->view);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $view = [
            'action' => '/admin/image',
            'modal_header' => '新增校園映像圖片',
            'modal_body' => [
                [
                    'label' => '校園映像圖片',
                    'tag' => 'input',
                    'type' => 'file',
                    'name' => 'img',
                ],
            ],
        ];
        return view('/modals/base_modal', $view);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // dd($request);
        if ($request->hasFile('img') && $request->file('img')->isValid()) {
            $image = new Image();

            $filename = $request->file('img')->getClientOriginalName();
            $request->file('img')->storeAs('public', $filename);

            $image->img = $filename;
            $image->save();
        }
        return redirect('/admin/image');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $image = Image::find($id);

        $view = [
            'action' => '/admin/image/' . $id,
            'method' => 'patch',
            'modal_header' => '編輯校園圖片',
            'modal_body' => [
                [
                    'label' => '目前校園圖片',
                    'tag' => 'img',
                    'src' => $image->img,
                    'style' => 'width:100px;heigth:68px'
                ],
                [
                    'label' => '更換校園圖片',
                    'tag' => 'input',
                    'type' => 'file',
                    'name' => 'img',
                ],
            ],
        ];

        return view('modals.base_modal', $view);
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
        $image = Image::find($id);

        if ($request->hasFile('img') && $request->file('img')->isValid()) {
            $request->file('img')->storeAs('public', $request->file('img')->getClientOriginalName());
            $image->img = $request->file('img')->getClientOriginalName();
        }

        $image->save();

        return redirect('/admin/image');
    }

    /**
     * 改變資料的顯示狀態
     */
    public function display($id)
    {
        $image = Image::find($id);

        $image->sh = ($image->sh + 1)%2;

        $image->save();
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
        Image::destroy($id);
    }
}
