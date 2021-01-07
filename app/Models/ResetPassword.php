<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ResetPassword extends BaseModel
{
    use HasFactory;

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function link()
    {
        return route('password-reset.show', $this);
    }
}
