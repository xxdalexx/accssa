<?php

namespace App\Http\Controllers;

use App\DataProvider\DataProvider;
use App\Models\User;
use App\Models\Series;
use App\Pipelines\ImportEventResults\ImportEventResults;
use Illuminate\Support\Facades\Auth;

class DevController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index()
    {
<<<<<<< HEAD
        $series = Series::find(10);

        $dto = ImportEventResults::get('0-s_Giz4-CyLbvvfJOm6L', $series, 20);

        return $dto->event->link();
    }

    public function acTracksindex()
    {
        $tracks = (new DataProvider)->getAcTracks();
        dd($tracks->sortBy('length')->skip(30));
=======
        $tracks = (new DataProvider)->getAcTracks();
        dd($tracks->sortBy('length')->skip(30));
    }

    public function indexImport()
    {
        $series = Series::find(8);

        $dto = ImportEventResults::get('0-s_Giz4-CyLbvvfJOm6L', $series, 20);

        dd('success', $dto);

        //Build event entry records

>>>>>>> 1f58780bd4e2d904f88072de071e442dfaf0623a
    }

    public function aindex()
    {
        return redirect()->route('home');
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
