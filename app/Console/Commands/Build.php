<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\Series;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Build extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aa:build';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rebuild Database';

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
        $this->call('migrate:fresh');
        $this->info('Database Rebuilt');

        $pint = Series::new('Americas Pint');
        $this->info('Americas Pint Series Created.');

        $pintEvents = [
            'OuwqupzZJpyEbDDhVSolx' => 28,
            'EGfd072zx_R9sx7Nw7xwm' => 30,
            'IDWTvDxLqqQsE6RQbMySI' => 35,
            'Hm6Wt88r4SdvlyiDG4yqv' => 20
        ];
        foreach ($pintEvents as $eventId => $minLaps) {
            $event = Event::build($eventId, $pint->id, $minLaps);
            $this->info($event->session_name . ' built.');
        }

        //GT4 Events.

    }
}
