@extends('layout.layout')

@section('content')

<div class="row">
    <div class="col-sm-6 offset-3">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Register with an Invite Code</h4>
                </div>
            </div>
            @livewire('auth.invite.code-input')
        </div>
    </div>
</div>

@endsection
