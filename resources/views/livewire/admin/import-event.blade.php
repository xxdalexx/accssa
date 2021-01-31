<div class="iq-card-body">
    <form wire:submit.prevent="submitForm">
        <div class="form-group">
            <label>Series</label>
            <select wire:model="input.seriesId" class="form-control mb-3 @error('seriesId') is-invalid @enderror">
                @foreach(App\Models\Series::select(['id', 'name'])->get() as $series)
                    <option value="{{ $series->id }}">{{ $series->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>SGP Event Id</label>
            <input wire:model.lazy="input.sgpEventId" type="text" class="form-control @error('sgpEventId') is-invalid @enderror">
        </div>


        <div class="form-group">
            <label>Event Status</label>
            <select wire:model="input.hasResults" class="form-control mb-3 @error('hasResults') is-invalid @enderror">
                <option value="0">Pre-Event / No Results</option>
                <option value="1">Completed / Has Results</option>
            </select>
        </div>

        @if($input['hasResults'])
            <div class="form-group">
                <label>Minimum Lap Cut Off</label>
                <input wire:model.lazy="input.minLaps" type="text" class="form-control @error('hasResults') is-invalid @enderror">
            </div>
        @endif

        <hr>

        <button type="submit" class="btn btn-primary">Submit</button>
        <p wire:loading>Working.</p>
    </form>
</div>
