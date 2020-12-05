<div class="iq-card-body">
    <form wire:submit.prevent="submitForm">
        <div class="form-group">
            <label>Series</label>
            <select wire:model="seriesId" class="form-control mb-3">
                @foreach(App\Models\Series::all() as $series)
                    <option value="{{ $series->id }}">{{ $series->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>SGP Event Id</label>
            <input wire:model.lazy="sgpEventId" type="text" class="form-control">
        </div>

        <div class="form-group">
            <label>Minimum Lap Cut Off</label>
            <input wire:model.lazy="minLaps" type="text" class="form-control">
        </div>

        <hr>

        <button type="submit" class="btn btn-primary">Submit</button>
        <p wire:loading>Working.</p>
        @if($this->failed)
            <p class="text-danger">Failed. SGP token probably needs updated.</p>
        @endif
    </form>
</div>
