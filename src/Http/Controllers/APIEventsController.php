<?php

namespace Acacha\Events\Http\Controllers;

use Acacha\Events\Http\Requests\DestroyEvent;
use Acacha\Events\Http\Requests\ListEvents;
use Acacha\Events\Http\Requests\ShowEvent;
use Acacha\Events\Http\Requests\StoreEvent;
use Acacha\Events\Http\Requests\UpdateEvent;
use Acacha\Events\Models\Event;

/**
 * Class APIEventsController.
 * 
 * @package App\Http\Controllers
 */
class APIEventsController extends Controller
{
    /**
     * Show list of events.
     *
     * @param ListEvents $request
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index(ListEvents $request)
    {
        return Event::all();
    }

    /**
     * Show an event.
     *
     * @param ShowEvent $request
     * @param Event $event
     * @return Event
     */
    public function show(ShowEvent $request, Event $event)
    {
        return $event;
    }

    /**
     * Store an event.
     *
     * @param StoreEvent $request
     * @return mixed
     */
    public function store(StoreEvent $request)
    {
        return Event::create($request->only(['name','user_id','description']));
    }

    /**
     * Update an event.
     *
     * @param UpdateEvent $request
     * @param Event $event
     * @return Event
     */
    public function update(UpdateEvent $request , Event $event)
    {
        $event->update($request->only(['name','description']));
        return $event;
    }

    /**
     * Destroy an event.
     *
     * @param DestroyEvent $request
     * @param Event $event
     * @return Event
     */
    public function destroy(DestroyEvent $request, Event $event)
    {
        $event->delete();
        return $event;
    }

}
