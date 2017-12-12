<?php

namespace Tests\Feature;

use Acacha\Events\Models\Event;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class APIAttendedEventControllerTest.
 *
 * @package Tests\Feature
 */
class APIAttendedEventControllerTest extends TestCase
{
    use RefreshDatabase;

    const MANAGER = 'events-manager';

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
     * Login as events manager.
     *
     * @param $user
     */
    protected function loginAsManager($user, $driver = 'api')
    {
        $user->assignRole(self::MANAGER);
        $this->actingAs($user,$driver);
    }

    /**
     * Store.
     *
     * @test
     */
    public function store()
    {
        $user = factory(User::class)->create();
        $this->loginAsManager($user,'api');
        $event = factory(Event::class)->create();

        $response = $this->json('POST', '/api/v1/attended-events/' . $event->id);

        $response->assertSuccessful();

        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'name' => $event->name,
            'attend' => true,
            'description' => $event->description,
            'user_id' => $event->user->id
        ]);

        $response->assertJson([
            'id' => $event->id,
            'name' => $event->name,
            'attend' => true,
            'description' => $event->description,
            'user_id' => $event->user->id
        ]);
    }

    //Route::delete('/attended-events/{event}' ,    'APIAttendedEventsController@destroy');

    protected function destroy()
    {
        $user = factory(User::class)->create();
        $this->loginAsManager($user,'api');

        $event = factory(Event::class)->create();

        $response = $this->json('DELETE','/api/v1/attended-events/' . $event->id);

        $response->assertSuccessful();

        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'name' => $event->name,
            'attend' => false,
            'description' => $event->description,
            'user_id' => $event->user->id
        ]);

        $response->assertJson([
            'id' => $event->id,
            'name' => $event->name,
            'attend' => false,
            'description' => $event->description,
            'user_id' => $event->user->id
        ]);

        $response->assertJson([
            'id' => $event->id,
            'name' => $event->name
        ]);
    }

}