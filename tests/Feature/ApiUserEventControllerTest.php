<?php

namespace Tests\Feature;

use Acacha\Events\Models\Event;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class ApiUserEventControllerTest.
 *
 * @package Tests\Feature
 */
class ApiUserEventControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Set up tests.
     */
    public function setUp()
    {
        parent::setUp();
        initialize_events_permissions();
//        $this->withoutExceptionHandling();
    }

    /**
     * User can see owned events.
     *
     * @test
     */
    public function user_can_see_owned_events() {
        $user = factory(User::class)->create();
        $this->actingAs($user,'api');

        factory(Event::class,3)->create([
            'user_id' => $user->id
        ]);

        $response = $this->json('GET','/api/v1/user/events');
        $response->assertSuccessful();

        $this->assertCount(3,json_decode($response->getContent()));
        $response->assertJsonStructure([[
            'id',
            'name',
            'user_id',
            'description',
            'created_at',
            'updated_at'
        ]]);
    }

    /**
     * User can see owned events.
     *
     * @test
     */
    public function user_can_create_owned_event() {
        $user = factory(User::class)->create();
        $this->actingAs($user,'api');

        $response = $this->json('POST','/api/v1/user/events',[
            'name' => 'Pool Party',
            'description' => 'So cool!',
            'user_id' => $user->id
        ]);
        $response->assertSuccessful();
    }

    /**
     * User can show owned event.
     *
     * @test
     */
    public function user_can_show_owned_event() {
        $event = factory(Event::class)->create();

        $this->actingAs($event->user,'api');

        $response = $this->json('GET', '/api/v1/events/' . $event->id);

        $response->assertSuccessful();

        $response->assertJson([
            'id' => $event->id,
            'name' => $event->name,
            'user_id' => $event->user_id,
            'created_at' => $event->created_at,
            'updated_at' => $event->updated_at
        ]);
    }

    /**
     * User can update owned event.
     *
     * @test
     */
    public function user_can_update_owned_event() {
        $event = factory(Event::class)->create();

        $this->actingAs($event->user,'api');

        $response = $this->json('PUT', '/api/v1/events/' . $event->id, [
            'name' => $newName = 'NOU NOM'
        ]);

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

    /**
     * User can destroy owned event.
     *
     * @test
     */
    public function user_can_destroy_owned_event() {
        $event = factory(Event::class)->create();

        $this->actingAs($event->user,'api');

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

}