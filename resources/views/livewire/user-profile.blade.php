<div class="row">
    <div class="col-md-6">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Tracks By Strength</h4>
                </div>
            </div>
            <div class="iq-card-body">
                Disabled for now.
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Your Current Split</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <h3>
                    {{ $user->driver->currentSplit }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Driver Number</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <div class="input-group">
                    <input wire:model.lazy="driverNumber" type="text" class="form-control">
                    <div class="input-group-append">
                        <button wire:click="changeDriverNumber" class="btn btn-outline-primary">Update</button>
                    </div>
                </div>
                @if($driverNumberSuccess)
                    <p class="text-success">Updated</p>
                @endif
            </div>
        </div>
    </div>
</div>
