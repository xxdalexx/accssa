@extends('layout.layout')

@section('content')

<div class="row">
    <div class="col-sm-6 offset-3">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">New Series</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <form action="{{ route('series.store') }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="email">Series Name</label>
                        <input type="text" class="form-control" id="name" name="name" autocomplete="off">
                    </div>

                    <div class="custom-control custom-checkbox custom-checkbox-color-check custom-control-inline">
                        <input type="checkbox" class="custom-control-input bg-info" name="splits" id="split-check">
                        <label class="custom-control-label" for="split-check">Uses Splits</label>
                     </div>

                    <div class="custom-control custom-checkbox custom-checkbox-color-check custom-control-inline">
                       <input type="checkbox" class="custom-control-input bg-info" name="penalties" id="penalty-check">
                       <label class="custom-control-label" for="penalty-check">Uses Penalty Points</label>
                    </div>

                    <div class="custom-control custom-checkbox custom-checkbox-color-check custom-control-inline">
                       <input type="checkbox" class="custom-control-input bg-info" name="registrationLocked" id="registration-check">
                       <label class="custom-control-label" for="registration-check">Lock Registration To Tracker</label>
                    </div>

                    <hr>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
