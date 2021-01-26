<?php

namespace App\Console\Commands;

use App\DataProvider\DataProvider;
use Illuminate\Console\Command;

class GetRandomGT3Car extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gimme:gt3';

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
        $car = app('DataProvider')->gimmeAGT3Car();
        $this->info($car);
        return;
    }
}
