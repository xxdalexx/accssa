@extends('layout.layout')

@section('content')

<div class="row">
    <div class="col-sm-6 offset-3">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Welcome {{ $user->name }}</h4>
                </div>
            </div>
            @livewire('auth.password-reset.show-password-reset', ['reset' => $reset])
        </div>
    </div>
</div>

@endsection
