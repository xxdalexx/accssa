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
                <h6>Nov 16th.</h6>
                <p>
                    Self reported penalties automatically processed and applied.<br>
                    First lap incident option added to double penalties.<br>
                    Buttons to accept penalties or request review.<br>
                    Auth timeout bug on penalty system fixed.<br>
                </p>
            </div>
        </div>
    </div>
</div>

@endsection
