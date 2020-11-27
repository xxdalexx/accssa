<div class="iq-card-body">
    <div class="form-group">
        <label>Series</label>
        <select wire:model="seriesId" class="form-control">
            @foreach(App\Models\Series::all() as $series)
                <option value="{{ $series->id }}">{{ $series->name }}</option>
            @endforeach
        </select>
    </div>
    <table id="datatable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Split</th>
            </tr>
        </thead>
        <tbody>
            @foreach($locks as $key => $lock)
                <tr>
                    <td>{{ $lock['driver_name'] }}</td>
                    <td>
                        <select wire:model="locks.{{ $key }}.split" class="form-control" style="height: auto">
                            <option value="No Score">No Score</option>
                            <option value="AM">AM</option>
                            <option value="Silver">Silver</option>
                            <option value="Pro">Pro</option>
                        </select>
                        <button wire:click="overrideSplit('{{ $key }}')" class="btn btn-outline-success">Update</button>
                        @if(array_key_exists('success', $lock))
                            <p class="text-success">Saved</p>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
