<?php

namespace Tests\Feature;

use Acacha\Events\Models\Event;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class EventsTest.
 *
 * @package Tests\Feature
 */
class EventsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
//        $this->withoutExceptionHandling();
    }

    /**
     * @group failing
     *
     * @test
     */
    public function testShowAllEvents()
    {

        // 1) Preparo el test
        $events = factory(Event::class,50)->create();
        // 2) Executo el codi que vull provar
        $response = $this->get('/events');

        // 3) Comprovo: assert
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
     */
    public function testShowAnEvent()
    {
//        $this->withoutExceptionHandling();
        $event = factory(Event::class)->create();
        $response = $this->get('/events/' . $event->id);
        // Comprovo
        $response->assertStatus(200);
        $response->assertSuccessful();
        $response->assertViewIs('events::show_event');
        $response->assertViewHas('event');

        $response->assertSeeText('Event:');
        $response->assertSeeText($event->name);
        $response->assertSeeText($event->description);

    }

    /**
     * @group todo1
     */
    public function testNotShowAnEvent()
    {

        // Executo
        $response = $this->get('/events/9999999');
        // Comprovo
        $response->assertStatus(404);

    }

    public function testShowCreateEventForm()
    {
        // Preparo
        // Executo
        $response = $this->get('/events/create');
        // Comprovo
        $response->assertStatus(200);
        $response->assertViewIs('events::create_event');
        $response->assertSeeText('Create Event');
    }

    public function testShowEditEventForm()
    {
        // Preparo
        $event = factory(Event::class)->create();

        // Executo
        $response = $this->get('/events/edit/' . $event->id);
        // Comprovo
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
        $response = $this->post('/events',[
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
        $response = $this->put('/events/' . $event->id,[
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
        $response = $this->call('DELETE','/events/' . $event->id);

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
