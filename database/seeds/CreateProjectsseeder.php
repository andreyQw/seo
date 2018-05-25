<?php

use Illuminate\Database\Seeder;
use App\Model\Project;

class CreateProjectsseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr_urls = ['www.no-bs.link', 'www.google.com', 'www.milk.com', 'www.hot.dog', 'www.why.but'];

        foreach ($arr_urls as $url){
            if($url == 'www.milk.com' || $url == 'www.hot.dog' || $url == 'www.why.but'){
                \App\Account::find(1)->projects()->create(['url' => $url]);
            }else{
                \App\Account::find(2)->projects()->create(['url' => $url]);
            }
        }
    }
}
