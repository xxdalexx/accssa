<?php

namespace App\Models;

use App\Importers\AccCarsFromSgpConverter;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property string name
 * @property string type
 */
class AccCar extends BaseModel
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = [];

    public static function import(array $cars): void
    {
        self::truncate();
        self::insert($cars);
    }

    public static function importFromSgpJson(): void
    {
        $cars = (new AccCarsFromSgpConverter())->getFormatted();
        self::import($cars);
    }
}
