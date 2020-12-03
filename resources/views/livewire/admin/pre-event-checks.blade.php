<div>
    <div class="iq-card-body">
        <div class="form-group">
            <label>SGP Event</label>
            <select wire:model="sgpEventId" class="form-control mb-3">
                @foreach($upcomingEvents as $event)
                    <option value="{{ $event['id'] }}">{{ $event['name'] }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Series</label>
            <select wire:model="seriesId" class="form-control mb-3">
                @foreach(App\Models\Series::all() as $series)
                    <option value="{{ $series->id }}">{{ $series->name }}</option>
                @endforeach
            </select>
        </div>

        <button wire:click="pullData" class="btn btn-outline-primary">Get Data</button>
        <p wire:loading>Working.</p>
    </div>
    <div class="iq-card-body">
        <div class="table-responsive">
            <table id="datatable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Driver</th>
                        <th>Has Tracker Account</th>
                        <th>Have Discord In Tracker</th>
                        <th>Selected Correct Split</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($this->driverEntriesForTable as $entry)
                        <tr>
                            <td>
                                {{ $entry['name'] }}
                            </td>
                            <td>
                                @if($entry['hasAccount'])
                                    Yes
                                @endif
                            </td>
                            <td>
                                @if($entry['haveDiscordId'])
                                    Yes
                                @endif
                            </td>
                            <td>
                                @if($entry['splitMatch'])
                                    Yes
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
