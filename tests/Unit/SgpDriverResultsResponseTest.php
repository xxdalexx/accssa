<?php

namespace Tests\Unit;

use App\Http\Guzzle\Sgp\Responses\SgpDriverResultsResponse;
use Tests\TestCase;

class SgpDriverResultsResponseTest extends TestCase
{
    /** @test */
    public function it_matches_snapshot_data()
    {
        $file = fake_sgp('driver-results\forTest.json');
        $results = json_decode(file_get_contents($file));

        $response = new SgpDriverResultsResponse();
        $response->setRawData($results);

        $have = $response->getFormattedListForTrackTimes();
        $want = $this->getSnapshot();

        $this->assertEquals($want, $have);
    }

    protected function getSnapshot()
    {
        $json = json_decode('
            {"suzuka_2019":{"GT3":123300,"GT4":134427,"sim":"acc"},"laguna_seca_2019":{"GT3":84826,"GT4":93781,"sim":"acc"},"cadwell_park::fullcircuit":{"ks_alfa_romeo_155_v6":98708,"sim":"ac"},"ks_laguna_seca::":{"ks_audi_tt_cup":92427,"tatuusfa1":84110,"sim":"ac"}}
        ', true);
        return $json;
    }
}
