<?php

namespace App\Models;

use App\Importers\AccTracksFromSgpConverter;
use App\Importers\AcTracksFromSgpConverter;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property string name
 * @property string track_id
 * @property string sim
 * @property integer length
 * @property integer max_entries
 */
class Track extends BaseModel
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = [];

    public static function rebuildFromSgpJsons(): void
    {
        self::truncate();

        $accTracks = (new AccTracksFromSgpConverter())->getFormatted();
        self::insert($accTracks);
        $acTracks = (new AcTracksFromSgpConverter())->getFormatted();
        self::insert($acTracks);
    }
}
