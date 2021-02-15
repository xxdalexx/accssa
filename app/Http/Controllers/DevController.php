<?php

namespace App\Http\Controllers;

use App\DataProvider\DataProvider;
use App\Helper\RaceTime;
use App\Http\Guzzle\Sgp\Get\DriverResults;
use App\Http\Guzzle\Sgp\Get\EventResults;
use App\Http\Guzzle\Sgp\Get\LeagueViews;
use App\Http\Guzzle\Sgp\Get\Responses\DriverResultsResponse;
use App\Http\Guzzle\Sgp\Get\Responses\LeagueViewsResponse;
use App\Http\Guzzle\Sgp\Get\Responses\SessionResponse;
use App\Http\Guzzle\Sgp\Get\Session;
use App\Http\Guzzle\Sgp\SgpApi;
use App\Models\AccCar;
use App\Models\Car;
use App\Models\EventEntry;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\VarDumper\Cloner\Data;
use Tests\Mocks\SgpLeagueViewsMock;

class DevController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index()
    {
        $formatted = $this->formatDriversTimes();
        $formatted = $this->injectCarIds($formatted);
        [$typed, $notTyped] = $formatted->partition(function ($results) {
            return array_key_exists('type', $results);
        });

        $typed = $this->processTimes($typed, 'type');
        $notTyped = $this->processTimes($notTyped, 'carModelId');

        $finished = $typed->merge($notTyped);

        dd($finished->toArray());
    }

    public function formatDriversTimes(): Collection
    {
        $api = new DriverResults();
        $response = collect($api->forDriver('SXs33IH-ZDSa6A2hUzKU_')->get());

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




    public function acTracksindex()
    {
        $tracks = (new DataProvider)->getAcTracks();
        dd($tracks->sortBy('length')->skip(30));
    }

    public function loginMe()
    {
        $user = User::first();
        Auth::login($user);

        return redirect()->route('home');
    }

    public function loginAs(User $user)
    {
        Auth::login($user);
        return redirect()->route('home');
    }



}
