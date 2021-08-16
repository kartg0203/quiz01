<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends HomeController
{

    public function showLoginForm()
    {
        parent::sidBar();
        return view('login', $this->view);
    }

    public function login(Request $res)
    {

        $user = [
            'acc' => $res->input('acc'),
            'password' => $res->input('pw'),
        ];

        if (Auth::attempt($user)) {
            return ['error' => 'success'];
            // return redirect('/admin');
        } else {
            return ['error' => true, 'meg' => '帳號或密碼錯誤'];
            // return redirect('/login')->with('error', '帳號或密碼錯誤');
        }
        // $acc = $request->input('acc');
        // $pw = $request->input('pw');
        // $chk = Admin::where('acc', $acc)->where('pw', $pw)->count();
        // if($chk){
        //     return redirect('/admin');
        // }else{
        //     return redirect('/login')->with('error', '帳號或密碼錯誤');
        // }
        // dd($chk);
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/login');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $all = Admin::all();
        $cols = ['帳號', '刪除', '編輯'];
        $rows = [];

        foreach ($all as $a) {
            $tmp = [
                [
                    'tag' => '',
                    'text' => $a->acc,
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

        $this->view['header'] = '管理者帳號管理';
        $this->view['module'] = 'Admin';
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
            'action' => '/admin/admin',
            'modal_header' => '新增管理者標題',
            'modal_body' => [
                [
                    'label' => '管理者帳號',
                    'tag' => 'input',
                    'type' => 'text',
                    'name' => 'acc',
                ],
                [
                    'label' => '密碼',
                    'tag' => 'input',
                    'type' => 'password',
                    'name' => 'pw',
                ],
                [
                    'label' => '確認密碼',
                    'tag' => 'input',
                    'type' => 'password',
                    'name' => 'pw2'
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
        $admin = new Admin();

        $admin->acc = $request->input('acc');
        $admin->pw = Hash::make($request->input('pw'));
        $admin->save();

        return redirect('/admin/admin');
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
        $admin = Admin::find($id);

        $view = [
            'action' => '/admin/admin/' . $id,
            'method' => 'patch',
            'modal_header' => '修改管理者密密',
            'modal_body' => [
                [
                    'label' => '帳號',
                    'tag' => '',
                    'text' => $admin->acc,
                ],
                [
                    'label' => '密碼',
                    'tag' => 'input',
                    'type' => 'password',
                    'name' => 'pw',
                    'value' => $admin->pw,
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
        $admin = Admin::find($id);

        if ($admin->pw != $request->input('pw')) {
            $admin->pw = Hash::make($request->input('pw'));
        }

        $admin->save();

        return redirect('/admin/admin');
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
        Admin::destroy($id);
    }
}
