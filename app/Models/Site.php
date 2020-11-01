<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    public $timestamps = false;

    public static function sgpToken()
    {
        return self::where('key', 'sgpToken')->value('value');
    }

    public static function setSgpToken(string $token)
    {
        return self::where('key', 'sgpToken')->update(['value' => $token]);
    }
}
