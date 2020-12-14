<?php

use Illuminate\Support\Collection;

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
