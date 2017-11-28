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
        initialize_events_permissions();
//        $this->withoutExceptionHandling();
    }

    /**
     * Can list events.
     *
     * @test
     */
    public function can_list_events()
    {
        factory(Event::class,3)->create();

        $user = factory(User::class)->create();
        $this->loginAsManager($user,'api');

        $response = $this->json('GET', '/api/v1/events');

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
     * Can show an event.
     *
     * @test
     */
    public function can_show_an_event()
    {
        $event = factory(Event::class)->create();

        $user = factory(User::class)->create();
        $this->loginAsManager($user,'api');

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
     * Cannot add event if no name provided
     *
     * @test
     */
    public function cannot_add_event_if_no_name_provided()
    {
        $user = factory(User::class)->create();
        $this->loginAsManager($user,'api');

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
        $otherUser = factory(User::class)->create();

        $this->loginAsManager($user,'api');

        $response = $this->json('POST', '/api/v1/events', [
            'name' => $name = $faker->word,
            'description' => $description = $faker->sentence,
            'user_id' => $otherUser->id
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('events', [
           'name' => $name,
           'description' => $description,
           'user_id' => $otherUser->id
        ]);

        $response->assertJson([
            'name' => $name,
            'description' => $description,
            'user_id' => $otherUser->id
        ]);
    }

    /**
     * Can edit an event.
     *
     * @test
     */
    public function can_edit_event()
    {
        $event = factory(Event::class)->create();

        $user = factory(User::class)->create();
        $this->loginAsManager($user,'api');

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
     * Can delete an event.
     *
     * @test
     */
    public function can_delete_event()
    {
        $event = factory(Event::class)->create();
        $user = factory(User::class)->create();

        $this->loginAsManager($user,'api');

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

        $this->loginAsManager($user,'api');

        $response = $this->json('DELETE','/api/v1/events/1');

        $response->assertStatus(404);
    }

    /**
     * Login as events manager.
     *
     * @param $user
     */
    protected function loginAsManager($user, $driver = 'api')
    {
        $user->assignRole('events-manager');
        $this->actingAs($user,$driver);
    }

}