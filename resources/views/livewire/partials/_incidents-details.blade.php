<div class="col-sm-6">
    <div class="iq-card">
        <div class="iq-card-header d-flex justify-content-between">
            <div class="iq-header-title">
                <h4 class="card-title">Event Details</h4>
            </div>
        </div>
        <div class="iq-card-body">
            @if($this->showDetails)
                <table id="datatable" class="table table-striped table-bordered">
                    <tr>
                        <td>Accused:</td>
                        <td>{{ $this->accusedNameDispaly }}</td>
                    </tr>
                    <tr>
                        <td>Victim:</td>
                        <td>{{ $this->victimNameDispaly }}</td>
                    </tr>
                    <tr>
                        <td>Reported By:<br></td>
                        <td>{{ $this->reportedNameDispaly }}</td>
                    </tr>
                    <tr>
                        <td>Infraction: </td>
                        <td>{{ $this->penaltyNameDispaly }}</td>
                    </tr>
                    <tr>
                        <td>Timestamp:</td>
                        <td>{{ $this->timestampDispaly }}</td>
                    </tr>
                    <tr>
                        <td>Given Description: </td>
                        <td>{{ $this->descriptionDispaly }}</td>
                    </tr>
                    <tr>
                        <td>Reviewer Notes: </td>
                        <td>{{ $this->notesDispaly }}</td>
                    </tr>
                    <tr>
                        <td>Status: </td>
                        <td>{{ $this->statusDispaly }}</td>
                    </tr>
                </table>
                @can('give penalties')
                    <hr>
                    Penalty Management.
                @endcan
                @else
                    <p>Click a reported incident to view details.</p>
                @endif
        </div>
    </div>
</div>
