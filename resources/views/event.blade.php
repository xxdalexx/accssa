@extends('layout.layout')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">{{ $event->session_name }}</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>DBID</th>
                                <th>Position</th>
                                <th>Driver</th>
                                <th>Laps</th>
                                <th>Total Time</th>
                                <th>Best Lap</th>
                                <th>Penalties</th>
                                <th>Fastest Lap</th>
                                <th>Quali</th>
                                <th>Points</th>
                                <th>Final Points</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($event->eventEntries as $entry)
                            <tr>
                                <td>{{ $entry->id }}</td>
                                <td>{{ $entry->position }}</td>
                                <td>{{ $entry->driver->driver_name }}</td>
                                <td>{{ $entry->laps }}</td>
                                <td>{{ $entry->total_time }}</td>
                                <td>{{ $entry->best_lap }}</td>
                                <td>{{ $entry->penalty_points }}</td>
                                <td>{{ $entry->best_lap_points }}</td>
                                <td>{{ $entry->top_quali_points }}</td>
                                <td>{{ $entry->points }}</td>
                                <td>{{ $entry->final_points }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
