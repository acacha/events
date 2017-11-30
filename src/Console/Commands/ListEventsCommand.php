<?php

namespace Acacha\Events\Console\Commands;

use Acacha\Events\Models\Event;
use Illuminate\Console\Command;
use Mockery\Exception;

/**
 * Class ListEventsCommand.
 *
 * @package Acacha\Events\Console\Commands
 */
class ListEventsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'event:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List events';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $headers = ['Name', 'User id','User name', 'Description'];

            $events = Event::all();

            $events_rows = [];
            foreach ($events as $event) {
                $events_rows[] = [
                    $event->name, $event->user_id, $event->user->name, $event->description
                ];
            }

            $this->table($headers, $events_rows);
        } catch ( Exception $e) {
            $this->error('Error');
        }
    }
}
