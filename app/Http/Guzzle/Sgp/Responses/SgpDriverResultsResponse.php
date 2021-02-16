<?php


namespace App\Http\Guzzle\Sgp\Responses;


use App\Models\Car;
use Illuminate\Support\Collection;

class SgpDriverResultsResponse
{
    protected $rawData;

    public function setRawData($rawData): SgpDriverResultsResponse
    {
        $this->rawData = $rawData;
        return $this;
    }

    public function getFormattedListForTrackTimes()
    {
        $formatted = $this->formatDriversTimes();
        $formatted = $this->injectCarIds($formatted);
        [$typed, $notTyped] = $formatted->partition(function ($results) {
            return array_key_exists('type', $results);
        });

        $typed = $this->processTimes($typed, 'type');
        $notTyped = $this->processTimes($notTyped, 'carModelId');

        $finished = $typed->merge($notTyped);

        return $finished->toArray();
    }

    protected function formatDriversTimes(): Collection
    {
        $response = collect($this->rawData);

        $sim = [
            'acc' => 'acc',
            'assetto_corsa' => 'ac'
        ];

        return $response->map(function ($event) use ($sim) {
            $results = collect($event->results)->filter(function ($result) {
                return $result->type == "RACE" && is_int($result->bestLapTime);
            })->each(function ($result) use ($event, $sim) {
                $result->carModelId = $event->carModelId;
                $result->sim        = $sim[$event->game];
                $result->trackId    = $event->trackId;
            })->map(function ($result) {
                return collect($result)
                    ->only([
                        'trackId',
                        'carModelId',
                        'sim',
                        'bestLapTime'
                    ]);
            });
            return $results->toArray();
        })->flatten(1);
    }

    protected function injectCarIds(Collection $formatted): Collection
    {
        $carIds = $formatted->groupBy('carModelId')->keys();
        $cars = Car::select(['id', 'type'])->whereIn('id', $carIds)->get();
        return $formatted->transform(function ($result) use ($cars) {
            $car = $cars->find($result['carModelId']);
            if ($car->type) {
                $result['type'] = $car->type;
            }
            return $result;
        });
    }

    protected function processTimes($input, $groupedBy)
    {
        return $input->groupBy('trackId')->map(function ($track) use ($groupedBy) {
            $types = $track->groupBy($groupedBy);
            $types->transform(function (Collection $type) {
                return (int)
                $type->sortBy('bestLapTime')
                    ->take(2)
                    ->avg('bestLapTime');
            });
            $types->put('sim',  $track->first()['sim']);
            return $types;
        });
    }
}
