<?php

namespace App\Console\Commands;

use App\Models\Driver;
use App\Models\DriverScore;
use Illuminate\Console\Command;

class DbFixDriverScoreRelations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:driverScoreRelations';

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
        $drivers = Driver::all();
        foreach ($drivers as $driver) {
            if (!$driver->score()->exists()) {
                $driver->score()->save(new DriverScore);
            }
        }
    }
}
