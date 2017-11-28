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

    public function user_can_show_owned_event() {

    }

    public function user_can_update_owned_event() {

    }

    public function user_can_destroy_owned_event() {

    }

    // TODO
//- Un usuari no pot veure, editar ni eliminar esdeveniment d'altres usuaris sinó té rol de manager


}