<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage series')->only(['store', 'create']);
    }

    public function show(Series $series)
    {
        return view('series.show')->withPoints($series->getStandingsSplit());
    }

    public function showDropOne(Series $series)
    {
        return view('series.show')->withPoints($series->getStandingsDropOneSplit());
    }

    public function create()
    {
        return view('series.create');
    }

    public function store(Request $request)
    {
        $series = Series::new(
            $request->input('name'),
            $request->boolean('splits'),
            $request->boolean('penalties')
        );
        return redirect()->route('series.show', $series);
    }
}
