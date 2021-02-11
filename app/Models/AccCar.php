<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccCar extends BaseModel
{
    use HasFactory;

    public bool $timestamps = false;

    protected array $guarded = [];

    public static function import(array $cars)
    {
        self::truncate();
        self::insert($cars);
    }
}
