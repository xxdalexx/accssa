<div class="col-sm-6">
    <div class="iq-card">
        <div class="iq-card-header d-flex justify-content-between">
            <div class="iq-header-title">
                <h4 class="card-title">Report Incident</h4>
            </div>
        </div>
        <div class="iq-card-body">
            <form wire:submit.prevent="newIncident">

                <div class="form-group">
                    <label>Accused</label>
                    <select wire:model="formInputs.accusedId" class="form-control mb-3">
                        <option value="0">Select Driver</option>
                        @foreach($this->driverList as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Victim</label>
                    <select wire:model="formInputs.victimId" class="form-control mb-3">
                        <option value="0">Select Driver</option>
                        @foreach($this->driverList as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Reported For</label>
                    <select wire:model="formInputs.penaltyId" class="form-control mb-3">
                        <option value="0">Select Infraction</option>
                        @foreach(App\Models\Penalty::whereProtected(false)->get() as $penalty)
                            <option value="{{ $penalty->id }}">{{ $penalty->displayName }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>First Lap Incident</label>
                    <select wire:model="formInputs.firstLap" class="form-control mb-3">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Replay Timestamp</label>
                    <input wire:model.lazy="formInputs.timestamp" type="text" class="form-control">
                </div>

                <div class="form-group">
                    <label>Short Description (optional)</label>
                    <input wire:model.lazy="formInputs.description" type="text" class="form-control">
                </div>

                <button type="submit" class="btn btn-outline-success btn-block">Submit</button>

            </form>
        </div>
    </div>
</div>
