@extends('layout.layout')

@section('title', 'SGP API Token')

@section('content')

<div class="row">
    <div class="col-sm-6 offset-3">
        <div class="iq-card">
            <div class="iq-card-body">
                @livewire('admin.sgp-token')
            </div>
        </div>
    </div>
</div>

@endsection
