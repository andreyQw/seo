<?php

use Illuminate\Database\Seeder;
use App\Event;

class NewsFeedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        (new Event(['type' => 'order', 'title' => 'New Order']))->save();
        (new Event(['type' => 'project', 'title' => 'New Project Added']))->save();
        (new Event(['type' => 'production_doc', 'title' => 'Doc Uploaded']))->save();
        (new Event(['type' => 'user', 'title' => 'New User Added']))->save();
        (new Event(['type' => 'bio', 'title' => 'Bio Confirmed']))->save();
        (new Event(['type' => 'anchor', 'title' => 'Anchors Confirmed']))->save();
        (new Event(['type' => 'production_topic_approved', 'title' => 'Topic Approved']))->save();
        (new Event(['type' => 'production_content_written', 'title' => 'Content Written']))->save();
        (new Event(['type' => 'production_content_edited', 'title' => 'Content Edited']))->save();
        (new Event(['type' => 'production_content_personalized', 'title' => 'Content Personalization']))->save();
        (new Event(['type' => 'production_live', 'title' => 'Placement Live']))->save();

    }
}
