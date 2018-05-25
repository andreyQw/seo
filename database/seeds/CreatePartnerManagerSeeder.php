<?php

use Illuminate\Database\Seeder;
use App\PartnerManager;

class CreatePartnerManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subs = new PartnerManager();
        $subs->user_id = 11;
        $subs->save();

    }
}
