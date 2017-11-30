<?php

namespace Acacha\Events\Console\Commands;

use Acacha\Events\Models\Event;
use Illuminate\Console\Command;
use Mockery\Exception;

/**
 * Class ShowEventCommand.
 *
 * @package Acacha\Events\Console\Commands
 */
class ShowEventCommand extends Command
{
    use AsksForEvents;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'event:show {id? : The event id to edit}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show an event';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $id = $this->argument('id') ? $this->argument('id') : $this->askForEvents();
        $event = Event::findOrFail($id);

        $this->info('Event:');
        try {
            $headers = ['Key', 'Value'];

            $fields = [
              ['Name:' , $event->name],
              ['User id:' , $event->user_id],
              ['User name:' , $event->user->name],
              ['Description:' , $event->description],
            ];

            $this->table($headers, $fields);

        } catch ( Exception $e) {
            $this->error('Error');
        }

    }

}
