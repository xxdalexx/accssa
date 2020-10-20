<?php

namespace App\Models;

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
}
