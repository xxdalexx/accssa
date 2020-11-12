<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penalty extends Model
{
    use HasFactory;

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
