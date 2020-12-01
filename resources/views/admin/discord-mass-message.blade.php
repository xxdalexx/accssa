@extends('layout.layout')

@section('content')

<div class="row">
    <div class="col-sm-6 offset-3">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Send Discord Message To Everyone</h4>
                </div>
            </div>
            <div class="iq-card-body">
                @livewire('admin.discord-mass-message')
            </div>
        </div>
    </div>
</div>

@endsection
