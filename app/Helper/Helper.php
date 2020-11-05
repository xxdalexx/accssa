<?php

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
