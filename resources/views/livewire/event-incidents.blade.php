<div class="row">
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
                        <select wire:model="accusedId" class="form-control mb-3">
                            <option value="0">Select Driver</option>
                            @foreach($this->driverList as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Victim</label>
                        <select wire:model="victimId" class="form-control mb-3">
                            <option value="0">Select Driver</option>
                            @foreach($this->driverList as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Reported For</label>
                        <select wire:model="penalty" class="form-control mb-3">
                            @foreach(App\Models\Penalty::all() as $penalty)
                                <option value="{{ $penalty->id }}">{{ $penalty->description }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Replay Timestamp</label>
                        <input wire:model.lazy="timestamp" type="text" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Short Description (optional)</label>
                        <input wire:model.lazy="description" type="text" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-outline-success btn-block">Submit</button>

                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Something Else</h4>
                </div>
            </div>
            <div class="iq-card-body">
                Blah
            </div>
        </div>
    </div>
</div>
