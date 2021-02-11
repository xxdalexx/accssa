<?php


namespace App\Helper;


use Illuminate\Support\Collection;

class IncidentTrackerReportConverter
{
    protected Collection $importJson;

    public function setImportJson($json): self
    {
        $this->importJson = collect(json_decode($json));
        return $this;
    }

    public function getCleanedArray(): array
    {
        $formattedReport = [];

        $offset = $this->importJson['greenFlagOffset'];

        $incidents = collect($this->importJson['incidents'])->where('sessionID.type', 'RACE');

        foreach ($incidents as $incident) {
            $report = [];
            $report['replayTime'] =
                (new RaceTime($offset + $incident->sessionEarliestTime))
                    ->onlySeconds();
            foreach ($incident->cars as $key => $car) {
                $report['cars'][$key] = $car->carId;
            }
            $formattedReport[] = $report;
        }

        return $formattedReport;
    }
}
