<?php

namespace Tests\Unit;

use App\Importers\IncidentTrackerReportConverter;
use PHPUnit\Framework\TestCase;

class IncidentTrackerReportConverterTest extends TestCase
{
    /** @test */
    public function it_works()
    {
        $array = (new IncidentTrackerReportConverter)
            ->setImportJson(
                file_get_contents(__DIR__ . '\..\IncidentTrackerReports\incidentReport.json')
            )->getCleanedArray();

        $this->assertIsArray($array);
    }
}
