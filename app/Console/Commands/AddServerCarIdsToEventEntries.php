<?php

namespace App\Console\Commands;

use App\Http\Guzzle\Sgp\SgpApi;
use App\Models\EventEntry;
use Illuminate\Console\Command;

class AddServerCarIdsToEventEntries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sgp:fill-server-car-ids';

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
        $e = EventEntry::with('event')->get()->groupBy('event.session_id_sgp');
        foreach ($e as $eventId => $events) {
            $apiResult = SgpApi::eventResults($eventId);
            $sgpResults = collect($apiResult->race->results);

            foreach ($events as $event) {
                $event->server_car_id = (int) $sgpResults
                    ->firstWhere('driverId', $event->driver->sgp_id)
                    ->carId;

                $event->save();
            }
        }
    }
}
