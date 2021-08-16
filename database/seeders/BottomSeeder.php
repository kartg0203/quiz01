<?php

namespace Database\Seeders;

use App\Models\Bottom;
use Illuminate\Database\Seeder;

class BottomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Bottom::create(['bottom'=>'科技大學版權所有']);
    }
}
