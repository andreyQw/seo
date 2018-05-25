<?php

use Illuminate\Database\Seeder;
use App\Bsi;

class BSISeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bsi = new Bsi(['name' => '#f15d34']);
        $bsi->save();
        $bsi = new Bsi(['name' => '#eedc00']);
        $bsi->save();
        $bsi = new Bsi(['name' => '#00c974']);
        $bsi->save();
        $bsi = new Bsi(['name' => '#000000']);
        $bsi->save();
    }
}
