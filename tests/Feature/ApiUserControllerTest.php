<?php

namespace Tests\Feature;

use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class ApiUserControllerTest.
 *
 * @package Tests\Feature
 */
class ApiUserControllerTest extends TestCase
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
     * Can list users.
     *
     * @test
     */
    public function can_list_users()
    {
        factory(User::class,3)->create();

        $user = factory(User::class)->create();
        $this->actingAs($user,'api');

        $response = $this->json('GET', '/api/v1/users');

        //        json_encode($response->getContent())

        $response->assertSuccessful();

        $response->assertJsonStructure([[
          'id',
          'name',
          'created_at',
          'updated_at'
        ]]);
    }

    /**
     * Can show an user.
     *
     * @test
     */
    public function can_show_an_user()
    {
        $user = factory(User::class)->create();

        $loggedUser = factory(User::class)->create();
        $this->actingAs($loggedUser,'api');

        $response = $this->json('GET', '/api/v1/users/' . $user->id);

        $response->assertSuccessful();

        $response->assertJson([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            //TODO password
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at
        ]);
    }

    /**
     * Cannot add user if not logged.
     *
     * @test
     */
    public function cannot_add_user_if_not_logged()
    {
        $faker = Factory::create();

        $response = $this->json('POST', '/api/v1/users', [
            'name' => $name = $faker->word
        ]);

        $response->assertStatus(401);
    }

    /**
     * Cannot add user if no name provided
     *
     * @test
     */
    public function cannot_add_user_if_no_name_provided()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user,'api');

        $response = $this->json('POST', '/api/v1/users');

        $response->assertStatus(422);
    }

    /**
     * Can add an user.
     *
     * @test
     */
    public function can_add_a_user()
    {
        $faker = Factory::create();
        $user = factory(User::class)->create();

        $this->actingAs($user,'api');

        $response = $this->json('POST', '/api/v1/users', [
            'name' => $name = $faker->word
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('users', [
           'name' => $name
        ]);

        $response->assertJson([
            'name' => $name
        ]);
    }

    /**
     * Can delete an user.
     *
     * @test
     */
    public function can_delete_user()
    {
        $user = factory(User::class)->create();
        $user = factory(User::class)->create();

        $this->actingAs($user,'api');

        $response = $this->json('DELETE','/api/v1/users/' . $user->id);

        $response->assertSuccessful();

        $this->assertDatabaseMissing('users',[
           'id' =>  $user->id
        ]);

        $response->assertJson([
            'id' => $user->id,
            'name' => $user->name
        ]);
    }

    /**
     * Cannot delete unexisting user.
     *
     * @test
     */
    public function cannot_delete_unexisting_user()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user,'api');

        $response = $this->json('DELETE','/api/v1/users/1');

        $response->assertStatus(404);
    }

    /**
     * Can edit an user.
     *
     * @test
     */
    public function can_edit_user()
    {
        // PREPARE
        $user = factory(User::class)->create();

        $user = factory(User::class)->create();
        $this->actingAs($user,'api');

        // EXECUTE
        $response = $this->json('PUT', '/api/v1/users/' . $user->id, [
            'name' => $newName = 'NOU NOM'
        ]);

        // ASSERT
        $response->assertSuccessful();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $newName
        ]);

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
            'name' => $user->name,
        ]);

        $response->assertJson([
            'id' => $user->id,
            'name' => $newName
        ]);
    }

}