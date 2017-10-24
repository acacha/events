<?php

namespace Acacha\Events\Http\Controllers;

use Acacha\Events\Models\Event;
use Illuminate\Http\Request;

/**
 * Class EventController.
 *
 * @package Acacha\Events\Http\Controllers
 */
class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // CRUD -> Retrieve --> List
        // BREAD -> Browse Read Edit Add Delete
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

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        dd($event->name);
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        Event::destroy($event->id);
        return 'Deleted ok!';
    }
}
