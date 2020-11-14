<div class="row">
    <div class="col-sm-12">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Reported Incidents</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <div class="table-responsive">
                    <table id="one" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Accused</th>
                                <th>Victim</th>
                                <th>Time Stamp</th>
                                <th>Status</th>
                                <th>Penalty</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($this->event->incidents as $report)
                                <tr wire:click="showDetails({{ $report->id }})" class="finger">
                                    <td>{{ $report->accused->driver_name }}</td>
                                    <td>{{ $report->victim->driver_name }}</td>
                                    <td>{{ $report->timestamp }}</td>
                                    <td>{{ $this->statusList[$report->status] }}</td>
                                    <td>{{ $report->penalty->displayName }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <p wire:click="$refresh" class="finger">Known Bug, Click me if the table dissapears.</p>
                </div>
            </div>
        </div>
    </div>
</div>
