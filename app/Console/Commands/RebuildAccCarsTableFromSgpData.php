<?php

namespace App\Console\Commands;

use App\Models\Car;
use Illuminate\Console\Command;

class RebuildAccCarsTableFromSgpData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sgp:rebuild-acc-cars';

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
        Car::RebuildFromSgpJsons();
        $this->info('Cars Imported.');
    }
}
