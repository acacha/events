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
//        dd($request->input());
//        $event = new Event();
//        $event->name = $request->input()->name;
//        $event->description = $request->input()->description;
//        $event->save();

        Event::create($request->only(['name','description']));

        Session::flash('status', 'Created ok!');
//        return $event;
        return Redirect::to('/events/create');

//        Event::create([
//            'name' => $request->input()->name,
//            'description' => $request->input()->description,
//        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        return view('events::show_event',compact('event'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show1($id)
    {
//        dump($id);
//        dump( $event = Event::find($id));

//        if ($event == null) abort(404);
//        try {
//            $event = Event::findOrFail($id);
//        } catch(\Exception $e) {
//            abort(404);
//        }

        $event = Event::findOrFail($id);

//        dump($event->name);
//        https://laravel.com/docs/5.5/eloquent
//        return $event;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        return view('events::edit_event',['event' => $event]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
//        $event->name = $request->input('name');
//        $event->description = $request->input('description');
//        $event->save();
//        dd($request->only(['name','description']));
          $event->update($request->only(['name','description']));

        Session::flash('status', 'Edited ok!');
        return Redirect::to('/events/edit/' . $event->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $event->delete();
        Session::flash('status', 'Event was deleted successful!');
//        return $event;
        return Redirect::to('/events');
    }
}
