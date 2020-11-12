<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Incident extends BaseModel
{
    use HasFactory;

    public function accused()
    {
        return $this->belongsTo(Driver::class, 'accused_id');
    }

    public function victim()
    {
        return $this->belongsTo(Driver::class, 'victim_id');
    }

    public function reportedBy()
    {
        return $this->belongsTo(User::class, 'reported_by_id');
    }

    public function penalty()
    {
        return $this->belongsTo(Penalty::class);
    }
}
