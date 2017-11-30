<?php

namespace Acacha\Events\Console\Commands;

use Acacha\Events\Models\Event;
use Illuminate\Console\Command;
use Mockery\Exception;

/**
 * Class EditEventCommand.
 *
 * @package Acacha\Events\Console\Commands
 */
class EditEventCommand extends Command
{
    use AsksForEvents;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'event:edit {id? : The event id to edit} {name? : The event name} {user_id? : The user id} {description? : The event description}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Edits an existing event';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $id = $this->argument('id') ? $this->argument('id') : $this->askForEvents();

        $event = Event::findOrFail($id);
        try {
            $event->update([
                'name' => $this->argument('name') ? $this->argument('name') : $this->ask('Event name?'),
                'user_id' => $this->argument('user_id') ? $this->argument('user_id') : $this->ask('User id?'),
                'description' => $this->argument('description') ? $this->argument('description') : $this->ask('Event description?')
            ]);
        } catch ( Exception $e) {
            $this->error('Error');
        }
        $this->info('Event has been edited succesfully');
    }

}
