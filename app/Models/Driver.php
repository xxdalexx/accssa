<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Driver extends BaseModel
{
    use HasFactory;

    public function Score()
    {
        return $this->hasOne(DriverScore::class);
    }

    public function User()
    {
        return $this->hasOne(User::class);
    }
}
