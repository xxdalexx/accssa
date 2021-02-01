<div class="table-responsive">
    <table id="datatable-am" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th class="text-center">Position</th>
                <th>Driver</th>
                <th class="text-center">Laps</th>
                <th class="text-center">Total Time</th>
                <th class="text-center">Best Lap</th>
                <th class="text-center">Penalties</th>
                <th class="text-center">Fastest Lap</th>
                <th class="text-center">Quali</th>
                <th class="text-center">Points</th>
                <th class="text-center">Final Points</th>
            </tr>
        </thead>
        <tbody>
            @isset($entries[$splitName])
                @foreach ($entries[$splitName] as $entry)
                <tr>
                    <td class="text-center">{{ $entry->position }}</td>
                    <td class="text-success">{{ $entry->driver->displayName }}</td>
                    <td class="text-center">{{ $entry->laps }}</td>
                    <td class="text-center">{{ $entry->totalTimeText }}</td>
                    <td class="text-center">{{ $entry->bestLapText }}</td>
                    <td class="text-center">
                        @can('give penalties')
                            @livewire('penalty-td', ['points' => $entry->penalty_points, 'eventEntryId' => $entry->id])
                        @else
                            {{ $entry->penalty_points }}
                        @endcan
                    </td>
                    <td class="text-center">{{ $entry->best_lap_points }}</td>
                    <td class="text-center">{{ $entry->top_quali_points }}</td>
                    <td class="text-center">{{ $entry->points }}</td>
                    <td class="text-center">{{ $entry->final_points }}</td>
                </tr>
                @endforeach
            @endisset
        </tbody>
    </table>
</div>
