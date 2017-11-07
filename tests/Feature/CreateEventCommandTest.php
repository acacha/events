<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Mockery;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class CreateEventCommandTest.
 *
 * @package Tests\Feature
 */
class CreateEventCommandTest extends TestCase
{
    use RefreshDatabase;

    public function testItCreatesNewEvent()
    {
        $this->artisan('event:create', ['name' => 'Comprar pa']);

        $resultAsText = Artisan::output();

        $this->assertDatabaseHas('events', [
           'name' => 'Comprar pa'
        ]);

        // Receive "Event has been added to database succesfully."
//        $this->assertTrue(str_contains($resultAsText,'Event has been added to database succesfully'));
        $this->assertContains('Event has been added to database succesfully', $resultAsText);

    }

    public function testItAsksForAEventNameAndThenCreatesNewEvent()
    {
        $command = Mockery::mock('Acacha\Events\Console\Commands\CreateEventCommand[ask]');

        $command->shouldReceive('ask')
            ->once()
            ->with('Event name?')
            ->andReturn('Comprar llet');

        $this->app['Illuminate\Contracts\Console\Kernel']->registerCommand($command);

        $this->artisan('event:create');

        $this->assertDatabaseHas('events', [
            'name' => 'Comprar llet'
        ]);

        $resultAsText = Artisan::output();
        $this->assertContains('Event has been added to database succesfully', $resultAsText);
    }


}
