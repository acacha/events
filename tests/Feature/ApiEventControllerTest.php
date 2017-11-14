<?php

namespace Tests\Feature;

use Acacha\Events\Models\Event;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class ApiEventControllerTest.
 *
 * @package Tests\Feature
 */
class ApiEventControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Set up tests.
     */
    public function setUp()
    {
        parent::setUp();
//        $this->withoutExceptionHandling();
    }

    /**
     * Can list events.
     *
     * @test
     */
    public function can_list_events()
    {
        $events = factory(Event::class,3)->create();

        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->json('GET', '/api/v1/events');

        $response->assertSuccessful();

        $response->assertJsonStructure([[
          'id',
          'name',
          'created_at',
          'updated_at'
        ]]);
    }

    /**
     * Can show an event.
     *
     * @test
     */
    public function can_show_an_event()
    {
        $event = factory(Event::class)->create();

        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->json('GET', '/api/v1/events/' . $event->id);

        $response->assertSuccessful();

        $response->assertJson([
            'id' => $event->id,
            'name' => $event->name,
            'created_at' => $event->created_at,
            'updated_at' => $event->updated_at
        ]);
    }

    /**
     * Cannot add event if not logged.
     *
     * @test
     */
    public function cannot_add_event_if_not_logged()
    {
        $faker = Factory::create();

        $response = $this->json('POST', '/api/v1/events', [
            'name' => $name = $faker->word
        ]);

        $response->assertStatus(401);
    }

    /**
     * Cannot add event if no name provided
     *
     * @test
     */
    public function cannot_add_event_if_no_name_provided()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->json('POST', '/api/v1/events');

        $response->assertStatus(422);
    }

    /**
     * Can add an event.
     *
     * @test
     */
    public function can_add_a_event()
    {
        $faker = Factory::create();
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $response = $this->json('POST', '/api/v1/events', [
            'name' => $name = $faker->word
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('events', [
           'name' => $name
        ]);

        $response->assertJson([
            'name' => $name
        ]);
    }

    /**
     * Can delete an event.
     *
     * @test
     */
    public function can_delete_event()
    {
        $event = factory(Event::class)->create();
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $response = $this->json('DELETE','/api/v1/events/' . $event->id);

        $response->assertSuccessful();

        $this->assertDatabaseMissing('events',[
           'id' =>  $event->id
        ]);

        $response->assertJson([
            'id' => $event->id,
            'name' => $event->name
        ]);
    }

    /**
     * Cannot delete unexisting event.
     *
     * @test
     */
    public function cannot_delete_unexisting_event()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $response = $this->json('DELETE','/api/v1/events/1');

        $response->assertStatus(404);
    }

    /**
     * Can edit an event.
     *
     * @test
     */
    public function can_edit_event()
    {
        // PREPARE
        $event = factory(Event::class)->create();

        $user = factory(User::class)->create();
        $this->actingAs($user);

        // EXECUTE
        $response = $this->json('PUT', '/api/v1/events/' . $event->id, [
            'name' => $newName = 'NOU NOM'
        ]);

        // ASSERT
        $response->assertSuccessful();

        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'name' => $newName
        ]);

        $this->assertDatabaseMissing('events', [
            'id' => $event->id,
            'name' => $event->name,
        ]);

        $response->assertJson([
            'id' => $event->id,
            'name' => $newName
        ]);
    }

}