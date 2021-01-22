@extends('layout.layout')

@section('title', 'Home')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    @if(Auth::check())
                        <h4 class="card-title">Welcome {{ Auth::user()->name }}</h4>
                    @else
                        <h4 class="card-title">Welcome</h4>
                    @endif
                </div>
            </div>
            <div class="iq-card-body">
                <h5>Recent Changes</h5>
                <h6>Nov 27th.</h6>
                <p>
                    Standings pages for Series that are separated into splits now show by split.<br>
                </p>
                <h5>
                    Someone come up with something better to put here.
                </h5>
            </div>
        </div>
    </div>
</div>

@endsection
