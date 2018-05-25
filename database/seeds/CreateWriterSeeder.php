<?php

use Illuminate\Database\Seeder;
use App\Writer;

class CreateWriterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subs = new Writer();
        $subs->user_id = 8;
        $subs->save();

        $subs = new Writer();
        $subs->user_id = 9;
        $subs->save();
    }
}
