<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function show(Event $event)
    {
        if ($event->series->splits) {
            return $this->showSplits($event);
        }

        return view('event.show')->with([
            'event' => $event->load('eventEntries')
        ]);
    }

    protected function showSplits($event)
    {
        $entries = $event->eventEntries->groupBy('split');

        return view('event.show-splits')->with([
            'event' => $event->load('eventEntries'),
            'entries' => $entries
        ]);
    }
}
