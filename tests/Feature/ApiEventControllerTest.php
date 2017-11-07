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
     * @test
     */
    public function can_list_events()
    {
        $events = factory(Event::class,3)->create();

        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->json('GET', '/api/v1/events');

        $response->assertSuccessful();

//        $response->dump();

        $response->assertJsonStructure([[
          'id',
          'name',
          'created_at',
          'updated_at'
        ]]);
    }

    /**
     * @test
     */
    public function cannot_add_event_if_not_logged()
    {
        $faker = Factory::create();

        // EXECUTE
        $response = $this->json('POST', '/api/v1/events', [
            'name' => $name = $faker->word
        ]);

        // ASSERT
        $response->assertStatus(401);
    }

    /**
     * @test
     */
    public function cannot_add_event_if_no_name_provided()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        // EXECUTE
        $response = $this->json('POST', '/api/v1/events');

        // ASSERT
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function can_add_a_event()
    {
        // PREPARE
        $faker = Factory::create();
        $user = factory(User::class)->create();

        $this->actingAs($user);

        // EXECUTE
        $response = $this->json('POST', '/api/v1/events', [
            'name' => $name = $faker->word
        ]);

        // ASSERT
        $response->assertSuccessful();

        $this->assertDatabaseHas('events', [
           'name' => $name
        ]);

//        $response->dump();

        $response->assertJson([
            'name' => $name
        ]);
    }

    /**
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