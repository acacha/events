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

    /**
     * @test
     */
    public function create_new_event()
    {
        $this->artisan('event:create', ['name' => 'Pool party','description' => 'with cool girls']);

        $resultAsText = Artisan::output();

        $this->assertDatabaseHas('events', [
           'name' => 'Pool party',
           'description' => 'with cool girls',
        ]);

        $this->assertContains('Event has been added to database succesfully', $resultAsText);

    }

    public function testItAsksForAEventNameAndThenCreatesNewEvent()
    {
        $command = Mockery::mock('Acacha\Events\Console\Commands\CreateEventCommand[ask]');

        $command->shouldReceive('ask')
            ->once()
            ->with('Event name?')
            ->andReturn('Pool party');

        $command->shouldReceive('ask')
            ->once()
            ->with('Event description?')
            ->andReturn('with cool girls');

        $this->app['Illuminate\Contracts\Console\Kernel']->registerCommand($command);

        $this->artisan('event:create');

        $this->assertDatabaseHas('events', [
            'name' => 'Pool party',
            'description' => 'with cool girls',
        ]);

        $resultAsText = Artisan::output();
        $this->assertContains('Event has been added to database succesfully', $resultAsText);
    }


}
