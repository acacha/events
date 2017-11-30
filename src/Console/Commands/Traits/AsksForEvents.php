<?php

namespace Acacha\Events\Console\Commands;

use Acacha\Events\Models\Event;

/**
 * Trait AsksForEvents.
 *
 * @package Acacha\Events\Console\Commands
 */
trait AsksForEvents
{
    /**
     * Ask for events.
     *
     * @return mixed
     */
    protected function askForEvents()
    {
        $events = Event::all();
        $event_names = $events->pluck('name')->toArray();
        $event_name = $this->choice('Event id?',$event_names);
        return $events->where('name',$event_name)->first()->id;
    }
}