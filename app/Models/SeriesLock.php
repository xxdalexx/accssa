<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class SeriesLock extends BaseModel
{
    use HasFactory;

    public $timestamps = false;

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function series()
    {
        return $this->belongsTo(Series::class);
    }
}
