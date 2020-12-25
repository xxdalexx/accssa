<div class="table-responsive">
    <table id="datatable-am" class="table table-striped table-bordered">
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
            @isset($entries[$splitName])
                @foreach ($entries[$splitName] as $entry)
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
            @endisset
        </tbody>
    </table>
</div>
