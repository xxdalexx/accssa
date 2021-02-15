<?php

namespace App\Models;

use App\Importers\AcCarsFromSgpConverter;
use App\Importers\AccCarsFromSgpConverter;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property string name
 * @property string type
 */
class Car extends BaseModel
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = [];

    public static function RebuildFromSgpJsons(): void
    {
        self::truncate();
        $accCars = (new AccCarsFromSgpConverter())->getFormatted();
        self::insert($accCars);
        $acCars = (new AcCarsFromSgpConverter())->getFormatted();
        self::insert($acCars);
    }
}
