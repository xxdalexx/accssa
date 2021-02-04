<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invite extends BaseModel
{
    use HasFactory;

    public static function generate(int $driverID)
    {
        return self::firstOrCreate(
            ['driver_id' => $driverID],
            ['code' => (string) Str::uuid()]
        );
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
