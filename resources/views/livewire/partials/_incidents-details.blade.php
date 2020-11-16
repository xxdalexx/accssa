<div class="col-sm-6">
    <div class="iq-card">
        <div class="iq-card-header d-flex justify-content-between">
            <div class="iq-header-title">
                <h4 class="card-title">Incident Details</h4>
            </div>
        </div>
        <div class="iq-card-body">
            @if($this->showDetails)
                <table id="two" class="table table-striped table-bordered">
                    <tr>
                        <td>Accused:</td>
                        <td>{{ $this->accusedNameDisplay }}</td>
                    </tr>
                    <tr>
                        <td>Victim:</td>
                        <td>{{ $this->victimNameDisplay }}</td>
                    </tr>
                    <tr>
                        <td>Reported By:<br></td>
                        <td>{{ $this->reportedNameDisplay }}</td>
                    </tr>
                    <tr>
                        <td>Infraction: </td>
                        <td>{{ $this->penaltyNameDisplay }}</td>
                    </tr>
                    <tr>
                        <td>Timestamp:</td>
                        <td>{{ $this->timestampDisplay }}</td>
                    </tr>
                    <tr>
                        <td>Given Description: </td>
                        <td>{{ $this->descriptionDisplay }}</td>
                    </tr>
                    <tr>
                        <td>Reviewer Notes: </td>
                        <td>{{ $this->notesDisplay }}</td>
                    </tr>
                    <tr>
                        <td>Status: </td>
                        <td>{{ $this->statusDisplay }}</td>
                    </tr>
                    <tr>
                        <td>First Lap Incident: </td>
                        <td>
                            @if($this->firstLapDisplay)
                                Yes
                            @else
                                No
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Penalty Applied: </td>
                        <td>
                            @if($this->appliedDisplay)
                                Yes
                            @else
                                No
                            @endif
                        </td>
                    </tr>
                </table>
                @if(Auth::user()->driver->driver_name == $this->accusedNameDisplay && $this->displayedStatusId == 0)
                <hr>
                <div class="row">
                    <div class="col-sm-6">
                        <button wire:click="acceptPenalty" class="btn btn-outline-success btn-block">Accept</button>
                    </div>
                    <div class="col-sm-6">
                        <button wire:click="requestReview" class="btn btn-outline-danger btn-block">Request Review</button>
                    </div>
                </div>
                @endif
                @can('give penalties')
                    <hr>
                    <div class="row">
                        <div class="col-sm-10">
                            <p>
                                Incidents should only be deleted if they don't belong here. Incidents that have been determined
                                to have no action taken should have the status changed.
                            </p>
                        </div>
                        <div class="col-sm-2 align-self-center">
                            <button wire:click="deleteIncident" class="btn btn-outline-danger">Delete</button>
                        </div>
                    </div>
                    <hr>
                    @if(!$this->appliedDisplay)
                    <div class="row">
                        <div class="col-sm-10">
                            <p>
                                This might be working correctly. You'll need to refresh the page to see if the points were added.
                            </p>
                        </div>
                        <div class="col-sm-2 align-self-center">
                            <button wire:click="applyPenalty" class="btn btn-outline-warning">Apply Penalty</button>
                        </div>
                    </div>
                    <hr>
                    @endif
                    <div class="row">
                        <div class="col-sm-10">
                            <label>Change Status</label>
                            <select wire:model="displayedStatusId" class="form-control mb-3">
                                <option value="0">Status</option>
                                @foreach($this->statusList as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            @if($this->statusChangeSuccess)
                                <p class="text-success">Status Updated.</p>
                            @endif
                        </div>
                        <div class="col-sm-2 align-self-center">
                            <button wire:click="updateStatusOfDisplayed" class="btn btn-outline-warning">Update</button>
                        </div>
                    </div>
                @endcan
            @else
                <p>Click a reported incident to view details.</p>
            @endif
        </div>
    </div>
</div>
