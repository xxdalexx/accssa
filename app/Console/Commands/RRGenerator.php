<?php

namespace App\Console\Commands;

use App\DataProvider\DataProvider;
use Illuminate\Console\Command;

class RRGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gimme:event';

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
        $provider = new DataProvider;
        $entrants = [
            'Dale' => 0,
            'Fares' => 0,
            'Paul' => 0
        ];

        $this->info('Track: ' . $provider->gimmeATrack());

        foreach ($entrants as $entry => $null) {
            $this->info($entry . ' - ' . $provider->gimmeAGT3Car());
        }

        return;
    }
}
