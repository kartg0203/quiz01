<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Title;
use App\Models\Total;
use App\Models\Bottom;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $view = [];

    public function __construct()
    {
        $this->view['title'] = Title::select('id', 'img',  'text')->where('sh', 1)->first();
        $this->view['title']->img = asset('storage/'. $this->view['title']->img);

        $this->view['total'] = Total::first()->total;
        $this->view['bottom'] = Bottom::first()->bottom;

        if (!session()->has('visiter')) {
            $total = Total::first();
            $total->total++;
            $total->save();
            $this->view['total'] = $total->total;
            // 第一種寫法
            // session(['visiter'=>$total->total]);
            // 第二種寫法
            session()->put('visiter', $total->total);
        }
    }
}
