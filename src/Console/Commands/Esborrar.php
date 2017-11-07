<?php

namespace Acacha\Events\Console\Commands;

use Illuminate\Console\Command;

/**
 * Class Esborrar.
 *
 * @package Acacha\Events\Console\Commands
 */
class Esborrar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'esborrar:todo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $this->info('esborrar TODO');
    }
}
