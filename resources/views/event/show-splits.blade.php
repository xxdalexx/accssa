@extends('layout.layout')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">{{ $event->session_name }}</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <h4 class="text-center mb-2">AM Split</h4>
                @include('event._split-table', ['splitName' => 'AM'])
                <hr>
                <h4 class="text-center mb-2">Silver Split</h4>
                @include('event._split-table', ['splitName' => 'Silver'])
                <hr>
                <h4 class="text-center mb-2">Pro Split</h4>
                @include('event._split-table', ['splitName' => 'Pro'])
                <hr>
                <h4 class="text-center mb-2">No Split Qualification</h4>
                @include('event._split-table', ['splitName' => 'No Score'])
            </div>
        </div>
    </div>
</div>

@can('manage series')
    @livewire('event-editor', ['event' => $event])
@endcan

@livewire('event-incidents', ['event' => $event])

@endsection
