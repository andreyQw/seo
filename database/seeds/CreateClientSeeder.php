<?php

use Illuminate\Database\Seeder;
use App\Client;

class CreateClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $subs = new Client();
        $subs->user_id = 4;
        $subs->save();

        $subs = new Client();
        $subs->user_id = 5;
        $subs->save();

    }
}
