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
            'Dale',
            'How did I go that fast',
            'Paul Cantea',
            'KB+M',
            'Thunder Down Under',
            'Bryan Curzon',
            'Justin Sly Stallone',
            'A. Franchino',
            'My Tires are Roasting',
            'Hans Solo',
            'Meeting Man',
            'Oklahoma City Bomber',
            'Emoji King'
        ];

        $this->info('Track: ' . $provider->gimmeATrack());

        foreach ($entrants as $entry) {
            $this->info($entry . ' - ' . $provider->gimmeAGT3Car());
        }

        return;
    }
}
