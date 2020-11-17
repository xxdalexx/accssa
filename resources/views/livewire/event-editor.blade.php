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
                    <div class="form-group">
                        <label>Event Name</label>
                        <input wire:model.lazy="nameInput" type="text" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-outline-success">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
