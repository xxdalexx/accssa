<?php

namespace App\Console\Commands;

use App\Models\AccTrack;
use Illuminate\Console\Command;

class RebuildAccTracksTableFromSgpData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sgp:rebuild-acc-tracks';

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
        AccTrack::importFromSgpJson();
        $this->info('Tracks Imported.');
    }
}
