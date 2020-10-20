<?php

namespace App\Console\Commands;

use App\Models\Driver;
use Illuminate\Console\Command;

class RunAllDriversScores extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sgp:run-scores';

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
     * @return int
     */
    public function handle()
    {
        foreach (Driver::all() as $driver) {
            $driver->score->updateFromSgp();
            $this->info($driver->driver_name . ' updated.');
        }
    }
}
