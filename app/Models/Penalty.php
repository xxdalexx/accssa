<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penalty extends BaseModel
{
    use HasFactory;

    protected $casts = [
        'protected' => 'boolean'
    ];

    public function getDisplayNameAttribute()
    {
        if ($this->points == 1) {
            $ending = 'pt.';
        } else {
            $ending = 'pts.';
        }

        return $this->description . ' - ' . $this->points . $ending;
    }
}
