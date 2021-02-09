<?php

namespace App\Models;

use App\Http\Guzzle\Sgp\Get\Responses\DriverResultsResponse;
use App\Http\Guzzle\Sgp\Get\Responses\SessionResponse;
use App\Http\Guzzle\Sgp\SgpBase;
use App\Pipelines\ImportEventResults\ImportEventResultsPipeline;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends BaseModel
{
    use HasFactory;

    public static function buildPreResults($sgpEventId, $seriesId)
    {
        $apiResponse = app(SessionResponse::class)
            ->forEvent($sgpEventId)
            ->getRawResponse();

        return Event::create([
            'session_id_sgp' => $apiResponse->id,
            'session_name' => $apiResponse->sessionName,
            'track_name' => $apiResponse->trackName,
            'series_id' => $seriesId,
            'results_imported' => false
        ]);
    }

    public static function build($sgpEventId, $seriesId, $minLaps = 20)
    {
        $series = Series::find($seriesId);

        return ImportEventResultsPipeline::run($sgpEventId, $series, $minLaps);
    }

    public function repositionSplits()
    {
        $splits = $this->eventEntries->groupBy('split');

        $this->repositionSplit($splits, 'Pro');
        $this->repositionSplit($splits, 'Silver');
        $this->repositionSplit($splits, 'AM');

        if (property_exists($splits, 'No Score')) {
            foreach ($splits['No Score'] as $entry) {
                $entry->position = 0;
                $entry->points = 0;
                $entry->save();
            }
        }
    }

    protected function repositionSplit($splits, $splitName)
    {
        $counter = 1;
        $points = 20;
        foreach ($splits[$splitName] as $entry) {
            $entry->position = $counter;
            $entry->points = $points;
            $entry->final_points = $entry->points + $entry->best_lap_points + $entry->top_quali_points - $entry->penalty_points;
            $entry->save();
            $counter++;
            $points--;
        }
    }

    public function recalculatePoints()
    {
        if ($this->series->splits) {
            $this->repositionSplits();
        } else {
            $this->recalculatePointsNoSplits();
        }
    }

    protected function recalculatePointsNoSplits()
    {
        $top = $this->series->top_point + 1;
        foreach ($this->eventEntries as $entry) {
            $entry->points = $top - $entry->position;
            $entry->final_points = $entry->points + $entry->best_lap_points + $entry->top_quali_points - $entry->penalty_points;
            $entry->save();
        }
    }

    protected function recalculatePointsWithSplits()
    {
        $entries = $this->eventEntries->groupBy('split');
        $top = $this->series->top_point + 1;
        foreach ($this->eventEntries as $entry) {
            $entry->points = $top - $entry->position;
            $entry->final_points = $entry->points + $entry->best_lap_points + $entry->top_quali_points - $entry->penalty_points;
            $entry->save();
        }
    }

    public function series()
    {
        return $this->belongsTo(Series::class);
    }

    public function eventEntries()
    {
        return $this->hasMany(EventEntry::class);
    }

    public function incidents()
    {
        return $this->hasMany(Incident::class);
    }

    public function getDriverList(): array
    {
        $drivers = [];
        foreach($this->eventEntries as $entry) {
            $drivers['driver' . $entry->driver->id] = $entry->driver->displayNameReversed;
        }
        return $drivers;
    }

    public function link()
    {
        return route('event.show', $this);
    }

    public function sgpLink()
    {
        return "https://beta.simracing.gp/events/" . $this->session_id_sgp;
    }
}
