@extends('layout.layout')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Driver Management</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <div class="table-responsive">
                    <div class="row w-100">
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Score</th>
                                    <th>Account</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($drivers as $driver)
                                    <tr>
                                        <td>{{ $driver->driver_name }}</td>
                                        <td>
                                            {{ $driver->driver_score }}
                                            <i class="ri-refresh-fill pull-right"></i>
                                        </td>
                                        <td>
                                            @if($driver->user()->exists())
                                                <i class="ri-check-fill"></i>
                                            @endif
                                        </td>
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

@endsection
