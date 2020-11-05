@extends('layout.layout')

@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Needed Tracks</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Track</th>
                            <th>Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($neededTracks as $track => $count)
                            <tr>
                                <td>{{ $track }}</td>
                                <td>{{ $count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Most Time Since Used</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Track Timeline Reversed</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reverseTimeline as $track)
                        <tr>
                            <td>{{ $track }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
