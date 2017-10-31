<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class ApiEventsTest.
 *
 * @package Tests\Feature
 */
class ApiEventsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test example.
     *
     * @group todo
     *
     * @test
     */
    public function testObvious()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }


}
