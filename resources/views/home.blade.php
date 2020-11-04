@extends('layout.layout')

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
                Put some stuff here.
            </div>
        </div>
    </div>
</div>

@endsection
