<?php

namespace App\Http\Guzzle\Sgp\Cleaners;

use Illuminate\Support\Collection;

class DriverResultsForScoreCleaner extends CleanerBase
{
    protected Collection $trackResults;

    protected array $tracks = [
        "barcelona",
        "brands_hatch",
        "barcelona_2019",
        "brands_hatch_2019",
        "hungaroring",
        "hungaroring_2019",
        "kyalami_2019",
        "laguna_seca_2019",
        "misano",
        "misano_2019",
        "monza",
        "monza_2019",
        "mount_panorama_2019",
        "nurburgring",
        "nurburgring_2019",
        "paul_ricard",
        "paul_ricard_2019",
        "silverstone",
        "silverstone_2019",
        "spa",
        "spa_2019",
        "suzuka_2019",
        "zandvoort",
        "zandvoort_2019",
        "zolder",
        "zolder_2019",
        "barcelona_2020",
        "brands_hatch_2020",
        "hungaroring_2020",
        "misano_2020",
        "monza_2020",
        "nurburgring_2020",
        "paul_ricard_2020",
        "silverstone_2020",
        "spa_2020",
        "zandvoort_2020",
        "zolder_2020",
        "imola_2020",
        "snetterton_2019",
        "oulton_park_2019",
        "donington_2019",
    ];

    public function clean()
    {
        $this->trackResults = collect($this->response)->groupBy('trackId');

        foreach ($this->tracks as $track) {
            $this->processTrack($track);
        }
    }

    protected function processTrack(string $trackName)
    {
        if ($track = $this->trackResults->get($trackName)) {
            if ($time = $this->getGT3Top2Average($track)) {
                $this->cleaned[$trackName] = (int) $time;
            }
        }
    }

    protected function getGT3Top2Average($track)
    {
        $return = new Collection();
        foreach ($track as $result) {
            if ($result->carModelId < 26) {
                $races = collect($result->results)->where('type', 'RACE')->where('bestLap', '>', 0);
                foreach ($races as $race) {
                    $return->push($race);
                }
            }
        }
        return $return->sortBy('bestLapTime')->take(2)->pluck('bestLapTime')->avg();
    }
}
