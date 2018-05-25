<?php

use Illuminate\Database\Seeder;
use App\Editor;

class CreateEditorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subs = new Editor();
        $subs->user_id = 6;
        $subs->save();

        $subs = new Editor();
        $subs->user_id = 7;
        $subs->save();

    }
}
