<?php

namespace Tests\Feature;

use Acacha\Events\Models\Event;
use App\User;
use Illuminate\Support\Facades\Artisan;
use Mockery;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class ShowEventCommandTest.
 *
 * @package Tests\Feature
 */
class ShowEventCommandTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Show event.
     *
     * @test
     */
    public function show_event()
    {
        $event = factory(Event::class)->create();
        $this->artisan('event:show', ['id' => $event->id]);

        $resultAsText = Artisan::output();

        $this->assertContains('Event:', $resultAsText);

        $this->assertContains("Name: ", $resultAsText);
        $this->assertContains( $event->name, $resultAsText);

        $this->assertContains("User id: ", $resultAsText);
        $this->assertContains( (String) $event->user_id, $resultAsText);

        $this->assertContains("User name: ", $resultAsText);
        $this->assertContains( $event->user->name, $resultAsText);

        $this->assertContains("Description: ", $resultAsText);
        $this->assertContains( $event->description, $resultAsText);

    }

    /**
     * Show event with wizard.
     *
     * @test
     */
    public function show_event_with_wizard()
    {
        $command = Mockery::mock('Acacha\Events\Console\Commands\ShowEventCommand[ask,choice]');
        $event = factory(Event::class)->create();

        $command->shouldReceive('choice')
            ->once()
            ->with('Event id?',[ 0 => $event->name])
            ->andReturn($event->name);

        $this->app['Illuminate\Contracts\Console\Kernel']->registerCommand($command);

        $this->artisan('event:show');

        $resultAsText = Artisan::output();

        $this->assertContains('Event:', $resultAsText);

        $this->assertContains("Name: ", $resultAsText);
        $this->assertContains( $event->name, $resultAsText);

        $this->assertContains("User id: ", $resultAsText);
        $this->assertContains( (String) $event->user_id, $resultAsText);

        $this->assertContains("User name: ", $resultAsText);
        $this->assertContains( $event->user->name, $resultAsText);

        $this->assertContains("Description: ", $resultAsText);
        $this->assertContains( $event->description, $resultAsText);
    }
}
