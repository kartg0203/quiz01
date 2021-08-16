<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends HomeController
{

    public function vue($route)
    {
        $more = [];
        switch ($route) {
            case "index":
                $news = News::select('id', 'text')->where('sh', 1)->get()->filter(function ($val, $idx) use (&$more) {
                    if ($idx > 4) {
                        $more = ['show' => true, 'href' => '/news'];
                    } else {
                        $val->short = mb_substr(str_replace("\r\n", " ", $val->text), 0, 25, "utf8") . "...";
                        $val->text = str_replace("\r\n", "", nl2br($val->text));
                        $val->show = false;
                        $more = ['show' => false];
                        return $val;
                    }
                });
                break;
            case "news":
                $news = News::select('id', 'text')->where('sh', 1)->get()->filter(function ($val, $idx) use (&$more) {
                    $val->short = mb_substr(str_replace("\r\n", " ", $val->text), 0, 25, "utf8") . "...";
                    $val->text = str_replace("\r\n", "", nl2br($val->text));
                    $val->show = false;
                    $more = ['show' => false];
                    return $val;
                });
                break;
        }
        // dd($more);
        $news = ['news' => $news, 'more' => $more];

        // dd($news);
        return $news;
    }

    public function list()
    {
        parent::sidBar();
        $this->view['news'] = News::where('sh', 1)->paginate(5);
        return view('news', $this->view);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $all = News::all();
        $all = News::paginate(4);
        $cols = ['最新消息內容', '顯示', '刪除', '編輯'];
        $rows = [];

        foreach ($all as $a) {
            $tmp = [
                [
                    'tag' => '',
                    'text' => mb_substr($a->text, 0, 30, 'utf8'),
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
        $this->view['header'] = '最新消息內容管理';
        $this->view['module'] = 'News';
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
            'action' => '/admin/news',
            'modal_header' => '新增新增最新消息',
            'modal_body' => [
                [
                    'label' => '標題區替代文字',
                    'tag' => 'textarea',
                    'style' => 'width:200px;height:100px;',
                    'name' => 'text',
                ]
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
        $news = new News();
        $news->text = $request->input('text');
        $news->save();

        return redirect('/admin/news');
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
        $news = News::find($id);

        $view = [
            'action' => '/admin/news/' . $id,
            'method' => 'patch',
            'modal_header' => '編輯最新消息內容',
            'modal_body' => [
                [
                    'label' => '最新消息內容',
                    'tag' => 'textarea',
                    'style' => 'width:200px;height:100px',
                    'name' => 'text',
                    'value' => $news->text,
                ]
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
        $news = News::find($id);

        if ($news->text != $request->input('text')) {
            $news->text = $request->input('text');
        }

        $news->save();

        return redirect('/admin/news');
    }

    /**
     * 改變資料的顯示狀態
     */
    public function display($id)
    {
        $news = News::find($id);

        $news->sh = ($news->sh + 1) % 2;


        $news->save();
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
        News::destroy($id);
    }
}
