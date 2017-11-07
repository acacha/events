<?php

namespace Acacha\Events\Console\Commands;

use Acacha\Events\Models\Event;
use Illuminate\Console\Command;
use Mockery\Exception;

/**
 * Class CreateEventCommand.
 * @package Acacha\Events\Console\Commands
 */
class CreateEventCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'event:create {name? : The event name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This commands creates a new event';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            Event::create([
                'name' => $this->argument('name') ? $this->argument('name') : $this->ask('Event name?')
            ]);
        } catch ( Exception $e) {
            $this->error('Error');
        }
        $this->info('Event has been added to database succesfully');
    }
}
