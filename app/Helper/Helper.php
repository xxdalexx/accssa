<?php

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

function fixTrackNames($original)
{
    $new = [];
    foreach ($original as $key => $value) {
        //Capitalize words, replace underscores with spaces.
        $newKey = ucwords(str_replace('_', ' ', $key));
        $new[$newKey] = $value;
    }
    return $new;
}

function prettyJson(Collection $input)
{
    return $input->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

function dbFirstId($table)
{
    return DB::table('series')->select('id')->first()->id;
}

function fake_sgp($path = '')
{
    $file = file_get_contents(
        app()->basePath('tests/FakeSgpApi/' . $path)
    );

    return json_decode($file);
}
