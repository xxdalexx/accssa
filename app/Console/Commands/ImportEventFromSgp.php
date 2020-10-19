<?php

namespace App\Console\Commands;

use App\Models\Event;
use Illuminate\Console\Command;

class ImportEventFromSgp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sgp:importEvent {sgpEventId} {seriesId} {minLaps=20}';

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
        $sgpEventId = $this->argument('sgpEventId');
        $seriesId = $this->argument('seriesId');
        $minLaps = $this->argument('minLaps');
        $e = Event::build($sgpEventId, $seriesId, $minLaps);
        $this->info($e->session_info . ' Imported.');
        return;
    }
}
