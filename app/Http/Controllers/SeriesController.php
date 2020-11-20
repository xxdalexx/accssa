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
        if ($series->splits) {
            return view('series.show-splits')->with([
                'points' => $series->getStandingsSplit(),
                'title' => $series->name
            ]);
        }

        return view('series.show')->with([
            'points' => $series->getStandingsSplit(),
            'title' => $series->name
        ]);
    }

    public function showDropOne(Series $series)
    {
        return view('series.show')->with([
            'points' => $series->getStandingsDropOneSplit(),
            'title' => $series->name
        ]);
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
