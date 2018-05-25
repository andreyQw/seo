<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Model\Product;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Categorie::create(['name' => 'TF']);

        $prod = new Product();
        $prod->title = 'Trust Flow 10+ placements';
        $prod->price = '120';
        $prod->sku = 'TF10+';
        $prod->status = 'show';
        $prod->deleted = 'existing';
        $prod->categorie()->associate(\App\Categorie::find(1));
        $prod->save();
    }
}
