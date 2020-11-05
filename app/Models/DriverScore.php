<?php

namespace App\Models;

use App\Helper\DriverScoreCalculator;
use App\Http\Guzzle\Sgp\SgpBase;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DriverScore extends BaseModel
{
    use HasFactory;

    public function Driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function updateFromSgp()
    {
        $apiResults = (new SgpBase)->getDriverResultsForScore($this->driver->sgp_id);

        foreach ($apiResults as $track => $score) {
            $this->{$track} = $score;
        }

        $this->save();
        return $this;
    }

    public function calculateScore()
    {
        $calculator = $this->buildCalculator();
        return $calculator->getScore();
    }

    public function tracksByStrength()
    {
        $calculator = $this->buildCalculator();
        $tracks = collect($calculator->getTrackScores())->sort();
        return fixTrackNames($tracks);
    }

    protected function buildCalculator()
    {
        $this->updateFromSgp();
        return new DriverScoreCalculator($this);
    }
}
