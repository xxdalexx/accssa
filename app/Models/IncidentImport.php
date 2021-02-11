<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property EloquentCollection drivers
 * @property string replay_time_stamp
 */
class IncidentImport extends BaseModel
{
    use HasFactory;

    /** @noinspection PhpDynamicAsStaticMethodCallInspection */
    public static function createFromImport(array $import)
    {
        $eventEntries = EventEntry::whereIn('server_car_id', $import['cars'])
            ->with('driver')
            ->get();

        $new = self::create(['replay_time_stamp' => $import['replayTime']]);

        foreach ($eventEntries as $eventEntry) {
            $new->drivers()->attach($eventEntry->driver);
        }

        return $new;
    }

    /** @noinspection PhpFullyQualifiedNameUsageInspection */
    public function drivers(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Driver::class);
    }

    public static function createMultipleFromImport(array $fullImportArray): EloquentCollection
    {
        $collection = new EloquentCollection();
        foreach ($fullImportArray as $importArray) {
            $new = self::createFromImport($importArray);
            $collection->push($new);
        }
        return $collection;
    }
}
