<?php

namespace App\Models;

use App\Importers\AccTracksFromSgpConverter;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccTrack extends BaseModel
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = [];

    public static function import(array $tracks): void
    {
        self::truncate();
        self::insert($tracks);
    }

    public static function importFromSgpJson(): void
    {
        $tracks = (new AccTracksFromSgpConverter())->getFormatted();
        self::import($tracks);
    }
}
