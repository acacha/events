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
        initialize_events_permissions();
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
        $this->loginAsManager($user,'api');

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
        $this->loginAsManager($loggedUser,'api');

        $response = $this->json('GET', '/api/v1/users/' . $user->id);

        $response->assertSuccessful();

        $response->assertJson([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at
        ]);

        $response->assertJsonMissing([
            'password',
            'remember_token'
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
     * Cannot add user with already existing email
     *
     * @test
     */
    public function cannot_add_user_with_already_existing_email()
    {
        $user = factory(User::class)->create();
        $this->loginAsManager($user,'api');

        $response = $this->json('POST', '/api/v1/users',[
            'name' => 'Pepe',
            'email' => $user->email
        ]);

        $response->assertStatus(422);

        $response->assertJson([
            'message' => 'The given data was invalid.',
            'errors' => [
                'email' => [
                    0 => 'The email has already been taken.'
                ]
            ]
        ]);
    }

    /**
     * Cannot add user with invalid email
     *
     * @test
     */
    public function cannot_add_user_with_invalid_email()
    {
        $user = factory(User::class)->create();
        $this->loginAsManager($user,'api');

        $response = $this->json('POST', '/api/v1/users',[
            'name' => 'Pepe',
            'email' => 'asdasdsadasd'
        ]);

        $response->assertStatus(422);

        $response->assertJson([
            'message' => 'The given data was invalid.',
            'errors' => [
                'email' => [
                    0 => 'The email must be a valid email address.'
                ]
            ]
        ]);
    }

    /**
     * Cannot add user if no name provided
     *
     * @test
     */
    public function cannot_add_user_if_no_name_provided()
    {
        $user = factory(User::class)->create();
        $this->loginAsManager($user,'api');

        $response = $this->json('POST', '/api/v1/users');

        $response->assertStatus(422);

        $response->assertJson([
           'message' => 'The given data was invalid.',
           'errors' => [
                'name' => [
                    0 => 'The name field is required.'
                ],
                'email' => [
                    0 => 'The email field is required.'
                ]
            ]
        ]);
    }

    /**
     * Can add an user.
     *
     * @test
     */
    public function can_add_an_user()
    {
        $user = factory(User::class)->create();

        $this->loginAsManager($user,'api');

        $response = $this->json('POST', '/api/v1/users', [
            'name' => 'Sergi Tur Badenas',
            'email' => 'sergiturbadenas@gmail.com',
            'password' => '123456'
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('users', [
           'name' => 'Sergi Tur Badenas',
           'email' => 'sergiturbadenas@gmail.com',
        ]);

        $response->assertJson([
            'name' => 'Sergi Tur Badenas',
            'email' => 'sergiturbadenas@gmail.com',
        ]);

        $response->assertJsonMissing([
            'password',
            'remember_token'
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
        $otherUser = factory(User::class)->create();

        $this->loginAsManager($user,'api');


        $response = $this->json('DELETE','/api/v1/users/' . $otherUser->id);

        $response->assertSuccessful();

        $this->assertDatabaseMissing('users',[
           'id' =>  $otherUser->id
        ]);

        $response->assertJson([
            'id' => $otherUser->id,
            'name' => $otherUser->name
        ]);
    }

    /**
     * Login as events manager.
     *
     * @param $user
     */
    protected function loginAsManager($user, $driver = 'api')
    {
        $user->assignRole('users-manager');
        $this->actingAs($user,$driver);
    }

    /**
     * Cannot delete unexisting user.
     *
     * @test
     */
    public function cannot_delete_unexisting_user()
    {
        $user = factory(User::class)->create();

        $this->loginAsManager($user,'api');

        $response = $this->json('DELETE','/api/v1/users/2');

        $response->assertStatus(404);
    }

    /**
     * Can edit an user.
     *
     * @test
     */
    public function can_edit_user()
    {
        $user = factory(User::class)->create();
        $otherUser = factory(User::class)->create();

        $this->loginAsManager($user,'api');

        $response = $this->json('PUT', '/api/v1/users/' . $otherUser->id, [
            'name' => $newName = 'NOU NOM'
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('users', [
            'id' => $otherUser->id,
            'name' => $newName
        ]);

        $this->assertDatabaseMissing('users', [
            'id' => $otherUser->id,
            'name' => $otherUser->name,
        ]);

        $response->assertJson([
            'id' => $otherUser->id,
            'name' => $newName
        ]);
    }

}