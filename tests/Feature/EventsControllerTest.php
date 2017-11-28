<?php

namespace Tests\Feature;

use Acacha\Events\Models\Event;
use App\User;
use Illuminate\Support\Facades\View;
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

    /**
     * Set up.
     */
    public function setUp()
    {
        parent::setUp();
        initialize_events_permissions();
//        $this->withoutExceptionHandling();
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
        View::share('user',$user);
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
     * Test show and event.
     *
     * @test
     */
    public function can_show_an_event()
    {
        $event = factory(Event::class)->create();
        $user = factory(User::class)->create();
        View::share('user',$user);
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
        View::share('user',$user);
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
        View::share('user',$user);
        $this->actingAs($user);

        $response = $this->get('/events_php/create');

        $response->assertStatus(200);
        $response->assertViewIs('events::create_event');
        $response->assertSeeText('Create Event');
    }

    /**
     * Show edit event form.
     *
     * @test
     */
    public function show_edit_event_form()
    {
        $user = factory(User::class)->create();
        View::share('user',$user);
        $this->actingAs($user);

        $event = factory(Event::class)->create();

        $response = $this->get('/events_php/edit/' . $event->id);
        $response->assertStatus(200);
        $response->assertViewIs('events::edit_event');
        $response->assertSeeText('Edit Event');

        $response->assertSee($event->name);
        $response->assertSee($event->description);
    }

    /**
     * Test store event.
     * @test
     */
    public function store_event()
    {
        $user = factory(User::class)->create();
        View::share('user',$user);
        $this->actingAs($user);

        $event = factory(Event::class)->make();

        $response = $this->post('/events_php',[
            'name' => $event->name,
            'description' => $event->description,
        ]);

        $this->assertDatabaseHas('events',[
            'name' => $event->name,
            'description' => $event->description,
        ]);

        $response->assertRedirect('events_php/create');

    }

    /**
     * Update event.
     *
     * @test
     */
    public function update_event()
    {
        $user = factory(User::class)->create();
        View::share('user',$user);
        $this->actingAs($user);

        $event = factory(Event::class)->create();

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

        $response->assertRedirect('events_php/edit/' . $event->id);
    }

    /**
     * Delete event.
     *
     * @test
     */
    public function delete_event()
    {
        $user = factory(User::class)->create();
        View::share('user',$user);
        $this->actingAs($user);

        $event = factory(Event::class)->create();

        $response = $this->delete('/events_php/' . $event->id);

        $this->assertDatabaseMissing('events',[
            'name' => $event->name,
            'description' => $event->description,
        ]);

        $response->assertRedirect('events_php');

    }
}
