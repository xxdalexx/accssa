<hr>
<div class="row mt-3">
    <div class="col-sm-12">

        <h4 class="card-title">Event Editor</h4>

        <form wire:submit.prevent="updateName">
            <label>Event Name</label>
            <div class="input-group">
                <input wire:model.lazy="nameInput" type="text" class="form-control">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-outline-success">Update</button>
                </div>
            </div>
        </form>

        <form class="mt-2" wire:submit.prevent="updateReplay">
            <label>Replay Url</label>
            <div class="input-group">
                <input wire:model.lazy="replayInput" type="text" class="form-control">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-outline-success">Update</button>
                </div>
            </div>
        </form>

        @if($showImport)
        <hr>
        <label>Min Lap Cut Off</label>
        <input wire:model="minLap" type="text" class="form-control mb-2">
        <button wire:click="importResults" class="btn btn-outline-primary btn-block">Import Results</button>
        @endif

    </div>
</div>
