<?php

namespace App\Http\Controllers;

use App\Models\Mvim;
use Illuminate\Http\Request;

class MvimController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $all = Mvim::all();
        $cols = ['動畫圖片', '顯示', '刪除', '操作'];
        $rows = [];

        foreach ($all as $a) {
            $tmp = [
                [
                    'tag' => 'embed',
                    'src' => $a->img,
                    'style' => 'width:120px;height:80px;'
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

        $this->view['header'] = '動畫圖片管理';
        $this->view['module'] = 'Mvim';
        $this->view['cols'] = $cols;
        $this->view['rows'] = $rows;
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
            'action' => '/admin/mvim',
            'modal_header' => '新增動畫圖片',
            'modal_body' => [
                [
                    'label' => '動畫圖片',
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
            $mvim = new Mvim();

            $filename = $request->file('img')->getClientOriginalName();
            $request->file('img')->storeAs('public', $filename);

            $mvim->img = $filename;
            $mvim->save();
        }
        return redirect('/admin/mvim');
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
        $mvim = Mvim::find($id);

        $view = [
            'action' => '/admin/mvim/' . $id,
            'method' => 'patch',
            'modal_header' => '編輯動畫圖片',
            'modal_body' => [
                [
                    'label' => '目前動畫圖片',
                    'tag' => 'embed',
                    'src' => $mvim->img,
                    'style' => 'width:120px;heigth:80px'
                ],
                [
                    'label' => '更換動畫圖片',
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
        $mvim = Mvim::find($id);

        if ($request->hasFile('img') && $request->file('img')->isValid()) {
            $request->file('img')->storeAs('public', $request->file('img')->getClientOriginalName());
            $mvim->img = $request->file('img')->getClientOriginalName();
        }

        $mvim->save();

        return redirect('/admin/mvim');
    }

    /**
     * 改變資料的顯示狀態
     */
    public function display($id)
    {
        $mvim = Mvim::find($id);

        $mvim->sh = ($mvim->sh + 1) % 2;

        $mvim->save();
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
        Mvim::destroy($id);
    }
}
