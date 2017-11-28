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
    protected $signature = 'event:create {name? : The event name} {user_id? : The user id} {description? : The event description}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new event';

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
                'name' => $this->argument('name') ? $this->argument('name') : $this->ask('Event name?'),
                'user_id' => $this->argument('user_id') ? $this->argument('user_id') : $this->ask('User id?'),
                'description' => $this->argument('description') ? $this->argument('description') : $this->ask('Event description?')
            ]);
        } catch ( Exception $e) {
            $this->error('Error');
        }
        $this->info('Event has been added to database succesfully');
    }
}
