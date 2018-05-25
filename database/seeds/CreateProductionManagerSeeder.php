<?php

use Illuminate\Database\Seeder;
use App\ProductionManager;

class CreateProductionManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subs = new ProductionManager();
        $subs->user_id = 10;
        $subs->save();
    }
}
