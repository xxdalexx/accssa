<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Driver extends BaseModel
{
    use HasFactory;

    public function score()
    {
        return $this->hasOne(DriverScore::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function invite()
    {
        return $this->hasOne(Invite::class);
    }

    public function calculateDriverScore()
    {
        $this->driver_score = $this->score->calculateScore();
        $this->save();

        return $this;
    }
}
