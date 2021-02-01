<div class="row">
    <div class="col-sm-12">
        <h4 class="card-title">Reported Incidents</h4>

        @if($this->event->incidents->count())
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
            </div>
        @else
        <h5 class="text-center">No Reports Yet.</h5>
        @endif
    </div>
</div>
