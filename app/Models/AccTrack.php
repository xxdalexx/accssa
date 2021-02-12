<?php

namespace App\Models;

use App\Importers\AccTracksFromSgpConverter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccTrack extends Model
{
    use HasFactory;

    public bool $timestamps = false;

    protected array $guarded = [];

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
