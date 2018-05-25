<?php

use Illuminate\Database\Seeder;
use App\Bsi;

class AliasBSISeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bs = Bsi::find(1);
        $bs->alias = 'red';
        $bs->save();
        $bs = Bsi::find(2);
        $bs->alias = 'yellow';
        $bs->save();
        $bs = Bsi::find(3);
        $bs->alias = 'green';
        $bs->save();
        $bs = Bsi::find(4);
        $bs->alias = 'black';
        $bs->save();
    }
}
