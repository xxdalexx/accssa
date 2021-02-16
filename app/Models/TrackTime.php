<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property string sim
 * @property integer driver_id
 * @property string track_id
 * @property integer car_id
 * @property Driver driver
 * @property Track track
 * @property Car car
 * @property integer lap_time
 * @property integer per_km_time
 * @property integer lap_delta
 * @property integer per_km_delta
 * @property string car_type
 */
class TrackTime extends BaseModel
{
    use HasFactory;

    public function driver(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function track(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(
            Track::class,
            'track_id',
            'track_id'
        );
    }

    public function car(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(
            Car::class
        );
    }

    public function setCarIdAttribute($value)
    {
        $this->attributes['car_id'] = $value;
        $this->attributes['car_type'] =  $this->car->type ?? null;
    }

    public function setLapTimeAttribute($value)
    {
        $this->attributes['lap_time'] = $value;
        $this->attributes['per_km_time'] = $value / $this->track->length;

        if ($this->driver_id > 0) {
            $this->calculateDeltas();
        }
    }

    protected function calculateDeltas()
    {
        $compare = $this->getAlienRecord();

        $this->attributes['lap_delta'] = $compare
            ? $this->lap_time - $compare->lap_time
            : 0;


        $this->attributes['per_km_delta'] = $compare
            ? $this->per_km_time - $compare->per_km_time
            : 0;
    }

    protected function getAlienRecord()
    {
        $wheres = [
            ['driver_id', 0],
            ['sim', $this->sim],
            ['track_id', $this->track_id],
        ];

        $wheres[] = empty($this->car_type)
            ? ['car_id', $this->car_id]
            : ['car_type', $this->car_type];

        return self::where($wheres)->first();
    }
}
