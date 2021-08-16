<?php

namespace Database\Seeders;

use App\Models\Total;
use Illuminate\Database\Seeder;

class TotalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Total::create(['total'=>0]);
    }
}
