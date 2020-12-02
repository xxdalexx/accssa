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
        $viewName = $series->splits ? 'series.show-splits' : 'series.show';

        return view($viewName)->with([
            'points' => $series->getStandings($series->drop_one_standings),
            'dropOne' => $series->drop_one_standings,
            'title' => $series->name
        ]);
    }

    public function showDropOne(Series $series)
    {
        $viewName = $series->splits ? 'series.show-splits' : 'series.show';

        return view($viewName)->with([
            'points' => $series->getStandings($dropOne = true),
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
