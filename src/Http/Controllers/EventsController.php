<?php

namespace Acacha\Events\Http\Controllers;

use Acacha\Events\Models\Event;
use Illuminate\Http\Request;
use Redirect;
use Session;

/**
 * Class EventsController.
 *
 * @package Acacha\Events\Http\Controllers
 */
class EventsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::all();
        return view('events::list_events',compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('events::create_event');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Event::create($request->only(['name','description']));

        Session::flash('status', 'Created ok!');

        return Redirect::to('/events_php/create');

    }

    /**
     * Display the specified resource.
     *
     * @param Event $event
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Event $event)
    {
        return view('events::show_event',compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Event $event
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Event $event)
    {
        return view('events::edit_event',['event' => $event]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Event $event
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Event $event)
    {
        $event->update($request->only(['name','description']));

        Session::flash('status', 'Edited ok!');
        return Redirect::to('/events_php/edit/' . $event->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Event $event
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Event $event)
    {
        $event->delete();
        Session::flash('status', 'Event was deleted successful!');
        return Redirect::to('/events_php');
    }
}
