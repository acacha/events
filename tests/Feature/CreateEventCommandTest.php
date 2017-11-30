<?php

namespace Tests\Feature;

use App\User;
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
     * Create new event.
     *
     * @test
     */
    public function create_new_event()
    {
        $user = factory(User::class)->create();
        $this->artisan('event:create', ['name' => 'Pool party','user_id' => $user->id,'description' => 'with cool girls']);

        $resultAsText = Artisan::output();

        $this->assertDatabaseHas('events', [
           'name' => 'Pool party',
            'user_id' => $user->id,
           'description' => 'with cool girls',
        ]);

        $this->assertContains('Event has been added to database succesfully', $resultAsText);

    }

    /**
     * Create new event with wizard.
     *
     * @test
     */
    public function create_new_event_with_wizard()
    {
        $command = Mockery::mock('Acacha\Events\Console\Commands\CreateEventCommand[ask]');
        $user = factory(User::class)->create();
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
            ->andReturn($user->id);

        $this->app['Illuminate\Contracts\Console\Kernel']->registerCommand($command);

        $this->artisan('event:create');

        $this->assertDatabaseHas('events', [
            'name' => 'Pool party',
            'user_id' => $user->id,
            'description' => 'with cool girls',
        ]);

        $resultAsText = Artisan::output();
        $this->assertContains('Event has been added to database succesfully', $resultAsText);
    }


}
