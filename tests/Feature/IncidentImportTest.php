<?php

namespace Tests\Feature;

use App\Helper\IncidentTrackerReportConverter;
use App\Models\Event;
use App\Models\EventEntry;
use App\Models\IncidentImport;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IncidentImportTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_records_from_imported_data()
    {
        Event::factory()->has(
            EventEntry::factory()->count(2)->state(new Sequence(
                ['server_car_id' => 1012],
                ['server_car_id' => 1013]
            ))
        )->create();

        $import = $this->singleImportArrayEntry();
        $incidentImport = IncidentImport::createFromImport($import);

        $this->assertDatabaseCount('incident_imports', 1);
        $this->assertEquals($import['replayTime'], $incidentImport->replay_time_stamp);
        $this->assertCount(2, $incidentImport->drivers);
    }

    /** @test */
    public function it_imports_multiple_records_from_cleaned_incident_tracker_report()
    {
        [$carIds, $eventEntriesCount] = $this->generateArgsForFactory();
        Event::factory()->has(
            EventEntry::factory()
                ->count($eventEntriesCount)
                ->state(
                    new Sequence(...$carIds)
                )
        )->create();
        $this->assertDatabaseCount('event_entries', $eventEntriesCount);

        $return = IncidentImport::createMultipleFromImport(
            $this->fullImportArray()
        );

        $this->assertDatabaseCount(
            'incident_imports',
            count($this->fullImportArray())
        );

        $this->assertInstanceOf(
            EloquentCollection::class,
            $return
        );

        $this->assertCount(
            count($this->fullImportArray()),
            $return
        );
    }

    protected function singleImportArrayEntry(): array
    {
        return
        [
            "replayTime" => "04:45.764",
            "cars" =>
                [
                    1012,
                    1013
                ]
        ];
    }

    protected function fullImportArray(): array
    {
        return (new IncidentTrackerReportConverter)
            ->setImportJson(
                file_get_contents(__DIR__ . '\..\IncidentTrackerReports\incidentReport.json')
            )->getCleanedArray();
    }

    protected function generateArgsForFactory(): array
    {
        $serverCarIds = collect($this->fullImportArray())
            ->pluck('cars')
            ->flatten()
            ->unique()
            ->transform(function($item) {
                return ['server_car_id' => $item];
            })->toArray();
        return [$serverCarIds, count($serverCarIds)];
    }
}
