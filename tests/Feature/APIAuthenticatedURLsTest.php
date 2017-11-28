<?php

namespace Tests\Feature;

use Acacha\Events\Models\Event;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class AuthenticatedURLSTest.
 *
 * @package Tests\Feature
 */
class AuthenticatedURLSTest extends TestCase
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
     * Authenticated URIs provider.
     *
     * @return array
     */
    public function authenticatedURIs()
    {
        return [
            ['get','/api/v1/events'],
            ['get','/api/v1/events/1'],
            ['post','/api/v1/events'],
            ['put','/api/v1/events/1'],
            ['delete','/api/v1/events/1'],
            ['get','/api/v1/users'],
            ['get','/api/v1/users/1'],
            ['post','/api/v1/users'],
            ['put','/api/v1/users/1'],
            ['delete','/api/v1/users/1'],

            ['get','/api/v1/user/events'],
        ];
    }

    /**
     * URI requires authenticated user.
     *
     * @test
     * @dataProvider authenticatedURIs
     */
    public function uri_requires_authenticated_user($method , $uri)
    {
        $response = $this->json($method, $uri);
        $response->assertStatus(401);
    }

}