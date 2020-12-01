<div class="row">
    <div class="col-sm-12">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Event Editor</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <form wire:submit.prevent="updateName">
                    <label>Event Name</label>
                    <div class="input-group">
                        <input wire:model.lazy="nameInput" type="text" class="form-control">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-outline-success">Update</button>
                        </div>
                    </div>
                </form>
                <hr>
                <form wire:submit.prevent="updateReplay">
                    <label>Replay Url</label>
                    <div class="input-group">
                        <input wire:model.lazy="replayInput" type="text" class="form-control">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-outline-success">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
