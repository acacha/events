<?php

namespace Tests\Feature;

use Acacha\Events\Models\Event;
use Illuminate\Support\Facades\Artisan;
use Mockery;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class DeleteEventCommandTest.
 *
 * @package Tests\Feature
 */
class DeleteEventCommandTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Show event.
     *
     * @test
     */
    public function delete_event()
    {
        $event = factory(Event::class)->create();
        $this->artisan('event:delete', ['id' => $event->id]);

        $resultAsText = Artisan::output();

        $this->assertDatabaseMissing('events', [
            'id' => $event->id,
            'name' => $event->name,
            'user_id' =>  $event->user_id,
            'description' => $event->description,
        ]);

        $this->assertContains('Event has been removed succesfully', $resultAsText);
    }

    /**
     * Show event with wizard.
     *
     * @test
     */
    public function delete_event_with_wizard()
    {
        $command = Mockery::mock('Acacha\Events\Console\Commands\DeleteEventCommand[ask,choice]');
        $event = factory(Event::class)->create();

        $command->shouldReceive('choice')
            ->once()
            ->with('Event id?',[ 0 => $event->name])
            ->andReturn($event->name);

        $this->app['Illuminate\Contracts\Console\Kernel']->registerCommand($command);

        $this->artisan('event:delete');

        $resultAsText = Artisan::output();

        $this->assertDatabaseMissing('events', [
            'id' => $event->id,
            'name' => $event->name,
            'user_id' =>  $event->user_id,
            'description' => $event->description,
        ]);

        $this->assertContains('Event has been removed succesfully', $resultAsText);
    }
}
