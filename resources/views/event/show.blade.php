@extends('layout.layout')

@section('content')

@section('title', $event->session_name)

<div class="row">
    <div class="col-sm-12">
        @include('event._card-header')

        <div class="table-responsive">
            <table id="datatable" class="table table-striped table-bordered">
                <thead>
                    <tr>
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
                        <td>{{ $entry->position }}</td>
                        <td>{{ $entry->driver->displayName }}</td>
                        <td>{{ $entry->laps }}</td>
                        <td>{{ $entry->totalTimeText }}</td>
                        <td>{{ $entry->bestLapText }}</td>
                        <td>
                            @can('give penalties')
                                @livewire('penalty-td', ['points' => $entry->penalty_points, 'eventEntryId' => $entry->id])
                            @else
                                {{ $entry->penalty_points }}
                            @endcan
                        </td>
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

@can('manage series')
    @livewire('event-editor', ['event' => $event])
@endcan

<hr>

@livewire('event-incidents.event-incidents', ['event' => $event])

@endsection
