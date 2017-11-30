<?php

namespace Tests\Feature;

use Acacha\Events\Models\Event;
use Illuminate\Support\Facades\Artisan;
use Mockery;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class EditEventCommandTest.
 *
 * @package Tests\Feature
 */
class EditEventCommandTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Edit event.
     *
     * @test
     */
    public function edit_event()
    {
        $event = factory(Event::class)->create();
        $this->artisan('event:edit', ['id' => $event->id, 'name' => 'Pool party','user_id' => $event->user_id,'description' => 'with cool girls']);

        $resultAsText = Artisan::output();

        $this->assertDatabaseHas('events', [
           'id' => $event->id,
           'name' => 'Pool party',
           'user_id' => $event->user_id,
           'description' => 'with cool girls',
        ]);

        $this->assertDatabaseMissing('events', [
            'id' => $event->id,
            'name' => $event->name,
            'user_id' =>  $event->user_id,
            'description' => $event->description,
        ]);

        $this->assertContains('Event has been edited succesfully', $resultAsText);

    }

    /**
     * Edit event with wizard.
     *
     * @test
     */
    public function edit_event_with_wizard()
    {
        $command = Mockery::mock('Acacha\Events\Console\Commands\EditEventCommand[ask,choice]');
        $event = factory(Event::class)->create();

        $command->shouldReceive('choice')
            ->once()
            ->with('Event id?',[ 0 => $event->name])
            ->andReturn($event->name);
        $command->shouldReceive('ask')
            ->once()
            ->with('Event name?')
            ->andReturn('Pool party');

        $command->shouldReceive('ask')
            ->once()
            ->with('Event description?')
            ->andReturn('with cool girls');

        $command->shouldReceive('ask')
            ->once()
            ->with('User id?')
            ->andReturn($event->user_id);

        $this->app['Illuminate\Contracts\Console\Kernel']->registerCommand($command);

        $this->artisan('event:edit');

        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'name' => 'Pool party',
            'user_id' => $event->user_id,
            'description' => 'with cool girls',
        ]);

        $this->assertDatabaseMissing('events', [
            'id' => $event->id,
            'name' => $event->name,
            'user_id' => $event->user_id,
            'description' => $event->description,
        ]);

        $resultAsText = Artisan::output();
        $this->assertContains('Event has been edited succesfully', $resultAsText);
    }


}
