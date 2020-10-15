@extends('layout.layout')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Americas Pint Standings</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <div class="table-responsive">
                    <div class="row w-100">
                        <div class="col-md-6">
                            <table id="datatable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($points[0] as $name => $point)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $name }}</td>
                                        <td>{{ $point }}</td>
                                    </tr>
                                    @php
                                        $finalLoop = $loop->iteration;
                                    @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table id="datatable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($points[1] as $name => $point)
                                    <tr>
                                        <td>{{ $loop->iteration + $finalLoop }}</td>
                                        <td>{{ $name }}</td>
                                        <td>{{ $point }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
