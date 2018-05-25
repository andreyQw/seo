<?php

namespace App\Components;

use App\Model\Project;
use App\Event;
use App\Feed;

class EventComponent
{

    public static function new_event(Project $project, $type, $id, $user_id = null)
    {

        $event = Event::where('type', $type)->first();

        $project->feeds()->save(new Feed(['event_id' => $event->id, 'table_id' => $id, 'user_id' => $user_id]));

    }

}