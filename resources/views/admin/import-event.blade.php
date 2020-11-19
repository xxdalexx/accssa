@extends('layout.layout')

@section('content')

<div class="row">
    <div class="col-sm-6 offset-3">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Import Event</h4>
                </div>
            </div>
            @livewire('admin.import-event')
        </div>
    </div>
</div>

@endsection
