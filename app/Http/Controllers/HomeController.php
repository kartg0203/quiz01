<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Mvim;
use App\Models\News;
use App\Models\SubMenu;
use App\Models\Total;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $this->sidBar();

        // $mvims = Mvim::select('id', 'img')->where('sh', 1)->get()->map(function ($val, $idx) {
        //     $val->show = ($idx == 0) ? true : false;
        //     $val->img = asset('storage/' . $val->img);

        //     return $val;
        // });
        // $news = News::select('id', 'text')->where('sh', 1)->get()->filter(function ($val, $idx) {
        //     if ($idx > 4) {
        //         $this->view['news']['more'] = ['show' => true, 'href' => '/news'];
        //     } else {
        //         $val->short = mb_substr(str_replace("\r\n", " ", $val->text), 0, 25) . "...";
        //         $val->text = str_replace("\r\n", "", nl2br($val->text));
        //         $val->show = false;
        //         $this->view['news']['more'] = ['show' => false];
        //         return $val;
        //     }
        // });

        // // dd($ad);

        // $this->view['mvims'] = $mvims;
        // $this->view['news']['data'] = $news;

        return view('main', $this->home());
    }

    public function home()
    {
        $this->sidBar();

        $mvims = Mvim::select('id', 'img')->where('sh', 1)->get()->map(function ($val, $idx) {
            $val->show = ($idx == 0) ? true : false;
            $val->img = asset('storage/' . $val->img);

            return $val;
        });
        $news = News::select('id', 'text')->where('sh', 1)->get()->filter(function ($val, $idx) {
            if ($idx > 4) {
                $this->view['news']['more'] = ['show' => true, 'href' => '/news'];
            } else {
                $val->short = mb_substr(str_replace("\r\n", " ", $val->text), 0, 25) . "...";
                $val->text = str_replace("\r\n", "", nl2br($val->text));
                $val->show = false;
                $this->view['news']['more'] = ['show' => false];
                return $val;
            }
        });
        // dd($ad);

        $this->view['mvims'] = $mvims;
        $this->view['news']['data'] = $news;
        if (Auth::check()) {
            $this->view['auth'] = [
                'href' => '/admin',
                'class' => 'btn-success',
                'text' => '返回管理',
                'user' => Auth::user()->acc,
            ];
        } else {
            $this->view['auth'] = [
                'href' => '/login',
                'class' => 'btn-primary',
                'text' => '管理登入',
                'user' => '訪客',
            ];
        }


        return $this->view;
    }

    protected function sidBar()
    {
        $menus = Menu::select('id', 'text', 'href')->where('sh', 1)->get();
        $images = Image::select('id', 'img')->where('sh', 1)->get()->map(function ($val, $idx) {
            // dd($val->img);
            $val->img = asset('storage/' . $val->img);
            if ($idx < 3) {
                $val->show = true;
            } else {
                $val->show = false;
            }

            return $val;
        });
        $ads = implode("　", Ad::where('sh', 1)->get()->pluck('text')->all());

        foreach ($menus as $key => $menu) {
            // $sub = SubMenu::where('menu_id', $menu->id)->get();
            $sub = $menu->subs;
            $menu->subs = $sub;
            $menu->show = false;
            $menus[$key] = $menu;
        }

        if (Auth::user()) {
            $this->view['user'] = Auth::user();
        }

        // if(!session()->has('visiter')){
        //     $total = Total::first();
        //     $total->total++;
        //     $total->save();
        //     $this->view['total'] = $total->total;
        //     // 第一種寫法
        //     // session(['visiter'=>$total->total]);
        //     // 第二種寫法
        //     session()->put('visiter', $total->total);

        // }

        $this->view['menus'] = $menus;
        $this->view['images'] = ['data' => $images, 'page' => 0];
        $this->view['ads'] = $ads;
        $this->view['site'] = [
            'ads' => $ads,
            'title' => $this->view['title'],
            'total' => $this->view['total'],
            'bottom' => $this->view['bottom'],
        ];
        // dd($this->view);
    }
}
