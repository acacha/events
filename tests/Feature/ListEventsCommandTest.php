<?php

namespace Tests\Feature;

use Acacha\Events\Models\Event;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class ListTaskCommandTest.
 *
 * @package Tests\Feature
 */
class ListEventsCommandTest extends TestCase
{
    use RefreshDatabase;

    /**
     * List event.
     *
     * @test
     */
    public function list_event()
    {
        $events = factory(Event::class,3)->create();
        $this->artisan('event:list');

        $resultAsText = Artisan::output();


        foreach ($events as $event) {
            $this->assertContains( $event->name, $resultAsText);
            $this->assertContains( (String) $event->user_id, $resultAsText);
            $this->assertContains( $event->user->name, $resultAsText);
            $this->assertContains( $event->description, $resultAsText);
        }
    }
}
