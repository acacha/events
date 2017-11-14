<?php

namespace Tests\Feature;

use Acacha\Events\Models\Event;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class EventsTest.
 *
 * @package Tests\Feature
 */
class EventsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    /**
     * List all events.
     *
     * @test
     */
    public function can_list_events()
    {
        $events = factory(Event::class,3)->create();

        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->get('/events_php');

        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('events::list_events');
        $events = Event::all();
        $response->assertViewHas('events',$events);

        foreach ($events as $event) {
            $response->assertSeeText($event->name);
            $response->assertSeeText($event->description);
        }
    }

    /**
     * Test show and event
     *
     * @test
     */
    public function can_show_an_event()
    {
        $event = factory(Event::class)->create();
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->get('/events_php/' . $event->id);

        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('events::show_event');
        $response->assertViewHas('event');

        $response->assertSeeText('Event:');
        $response->assertSeeText($event->name);
        $response->assertSeeText($event->description);

    }

    /**
     * Test show and event.
     *
     * @test
     */
    public function cannot_show_an_event()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->get('/events_php/9999999');

        $response->assertStatus(404);

    }

    /**
     * Show create event form.
     *
     * @test
     */
    public function show_create_event_form()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->get('/events_php/create');

        $response->assertStatus(200);
        $response->assertViewIs('events::create_event');
        $response->assertSeeText('Create Event');
    }

    /**
     * Show edit event form.
     * @test
     */
    public function show_edit_event_form()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $event = factory(Event::class)->create();

        $response = $this->get('/events_php/edit/' . $event->id);
        $response->assertStatus(200);
        $response->assertViewIs('events::edit_event');
        $response->assertSeeText('Edit Event');

        $response->assertSee($event->name);
        $response->assertSee($event->description);
    }

    public function testStoreEventForm()
    {
        // Preparo
        $event = factory(Event::class)->make();

//        $event = new Event();
//        $event->name = 'prova';
//        $event->description = 'asdasdasdasd';
//        $event->save();

        // Executo
        $response = $this->post('/events_php',[
            'name' => $event->name,
            'description' => $event->description,
        ]);
        // Comprovo

        $this->assertDatabaseHas('events',[
            'name' => $event->name,
            'description' => $event->description,
        ]);

        $response->assertRedirect('events/create');
//        $response->assertSeeText('Created ok!');

    }

    public function testUpdateEventForm()
    {
        // Preparo
        $event = factory(Event::class)->create();

        // Executo
        $newEvent = factory(Event::class)->make();
        $response = $this->put('/events_php/' . $event->id,[
            'name' => $newEvent->name,
            'description' => $newEvent->description,
        ]);

        $this->assertDatabaseHas('events',[
            'id' =>  $event->id,
            'name' => $newEvent->name,
            'description' => $newEvent->description,
        ]);

        $this->assertDatabaseMissing('events',[
            'id' =>  $event->id,
            'name' => $event->name,
            'description' => $event->description,
        ]);

        // Comprovo
        $response->assertRedirect('events/edit');
//        $response->assertSeeText('Edited ok!');


    }

    /**
     * @group caca1
     */
    public function testDeleteEvent()
    {
        // Preparo
        $event = factory(Event::class)->create();
        // Executo
        $response = $this->call('DELETE','/events_php/' . $event->id);

//        $response->dump();

        // Comprovo
        $this->assertDatabaseMissing('events',[
            'name' => $event->name,
            'description' => $event->description,
        ]);

//        $response->assertStatus(200);
        $response->assertRedirect('events');
        // TODO
//        $response->assertSeeText('Event was deleted successful');


    }
}
