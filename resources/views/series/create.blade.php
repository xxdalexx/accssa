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
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

@endsection
