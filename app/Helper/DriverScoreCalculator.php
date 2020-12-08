<?php

namespace App\Helper;

use App\Models\DriverScore;
use Illuminate\Support\Str;
use App\Http\Guzzle\Sgp\SgpBase;
use App\DataProvider\DataProvider;

class DriverScoreCalculator
{
    protected $trackTimes;
    protected $alienTimes;
    protected $trackScores;
    protected $score;

    public function __construct(DriverScore $driverScore)
    {
        $this->alienTimes = (new DataProvider)->getAlienTimes();
        $this->trackTimes = $this->cleanModelAttributes($driverScore);

        foreach ($this->trackTimes as $track => $time) {
            if ($calculatedScore = $this->calculateScore($track, $time)) {
                $this->trackScores[$track] = $calculatedScore;
            }
        }

        if (!empty($this->trackScores) && count($this->trackScores) > 2) {
            $this->score = collect($this->trackScores)->sort()->take(5)->avg();
        } else {
            $this->score = 0;
        }
    }

    protected function cleanModelAttributes($driverScore)
    {
        $attributes = $driverScore->getAttributes();
        unset(
            $attributes['id'],
            $attributes['driver_id'],
            $attributes['created_at'],
            $attributes['updated_at'],
        );
        return $attributes;
    }

    protected function calculateScore($track, $time)
    {
        if (!$time) {
            return false;
        }

        if (Str::endsWith($track, '_2020') && $track != 'imola_2020') {
            $track = str_replace('2020', '2019', $track);
        }

        if (!array_key_exists($track, $this->alienTimes)) {
            $score = $time - $this->alienTimes[$track . '_2019'];
        } else {
            $score = $time - $this->alienTimes[$track];
        }

        if ($score > 10000) {
            return false;
        }
        return $score;
    }

    public function getScore()
    {
        if (count($this->trackTimes) > 2) {
            return (int) $this->score;
        }
        return 0;
    }

    public function getTrackScores()
    {
        return $this->trackScores;
    }
}
