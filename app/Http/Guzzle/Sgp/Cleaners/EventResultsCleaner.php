<?php

namespace App\Http\Guzzle\Sgp\Cleaners;

use App\Models\Driver;

class EventResultsCleaner extends CleanerBase
{
    protected $qualiResults;
    protected $resultsCollection;

    protected function clean(): void
    {
        // $this->testing();
        // dd($this->response);
        $this->cleaned['session_id_sgp'] = $this->response->sessionId;
        $this->cleaned['session_name'] = $this->response->sessionName;
        $this->cleaned['track_name'] = $this->response->trackName;

        $this->qualiResults = collect($this->response->qualify->results);

        $this->buildRaceResults();

        //dd($this->cleaned);
        //dd($this->response->qualify->results);
    }

    protected function testing()
    {
        $test = collect($this->response->results);
        dd($test->where('type', 'RACE'));
    }

    protected function buildRaceResults($minLaps = 25): void
    {
        foreach ($this->response->results[2]->results as $result) {
            if ($result->lapCount > $minLaps) {
                $results[$result->position] = $this->buildRaceResult($result);
            }
        }
        //dd($results);
        $this->cleaned['raceResults'] = $results;
        $this->resultsCollection = collect($results);

        $this->assignBestQualiPoints();
        $this->assignBestLapPoints();
    }

    protected function buildRaceResult($input): array
    {
        $driver = Driver::firstOrCreate([
            'sgp_id' => $input->driverId,
            'driver_name' => $input->driverName
        ]);
        //dd($input);
        $result['driver_id'] = $driver->id;
        $result['driver_id_sgp'] = $driver->sgp_id;
        $result['driver_name'] = $driver->driver_name;
        $result['position'] = $input->position;
        $result['quali_time'] = $this->qualiResults->firstWhere('driverId', $driver->sgp_id)->bestLapTime;
        $result['laps'] = $input->lapCount;
        $result['clean_laps'] = $input->cleanLapCount;
        $result['total_time'] = $input->totalTime;
        $result['best_lap'] = $input->bestLapTime;
        $result['penalty_points'] = 0;
        $result['best_lap_points'] = 0;
        $result['top_quali_points'] = 0;
        $result['points'] = 0;
        $result['final_points'] = 0;

        return $result;
    }

    protected function assignBestQualiPoints()
    {
        $best = $this->resultsCollection->sortBy('quali_time')->first();
        $this->cleaned['raceResults'][$best['position']]['top_quali_points'] = 2;
    }

    protected function assignBestLapPoints()
    {
        $best = $this->resultsCollection->sortBy('best_lap')->first();
        $this->cleaned['raceResults'][$best['position']]['best_lap_points'] = 2;
    }
}
