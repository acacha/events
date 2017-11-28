<?php

namespace Acacha\Events\Http\Controllers;

use Acacha\Events\Http\Requests\UserStoreEvent;
use Acacha\Events\Models\Event;
use Auth;

/**
 * Class APIUserEventsController.
 *
 * @package App\Http\Controllers
 */
class APIUserEventsController extends Controller
{
    /**
     * Show list of events.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
        return Auth::user()->events;
    }

    /**
     * Store event for logged user.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function store(UserStoreEvent $request)
    {
        $event = Event::create($request->only(['name','user_id','description']));
        Auth::user()->events()->save($event);
        return $event;
    }

}
