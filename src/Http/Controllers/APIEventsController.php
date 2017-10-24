<?php

namespace Acacha\Events\Http\Controllers;

use Acacha\Events\Models\Event;
use Illuminate\Http\Request;

/**
 * Class APIEventsController.
 * 
 * @package App\Http\Controllers
 */
class APIEventsController extends Controller
{
    public function index()
    {
        return Event::all();
    }

    public function show(Event $event)
    {
        return $event;
    }
}
