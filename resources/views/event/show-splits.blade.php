@extends('layout.layout')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="iq-card">
            @include('event._card-header')
            <div class="iq-card-body">
                <h4 class="text-center mb-2">AM Split</h4>
                @include('event._split-table', ['splitName' => 'AM'])
                <hr>
                <h4 class="text-center mb-2">Silver Split</h4>
                @include('event._split-table', ['splitName' => 'Silver'])
                <hr>
                <h4 class="text-center mb-2">Pro Split</h4>
                @include('event._split-table', ['splitName' => 'Pro'])
                @if(isset($entries['No Score']))
                    <hr>
                    <h4 class="text-center mb-2">No Split Qualification</h4>
                    @include('event._split-table', ['splitName' => 'No Score'])
                @endif
            </div>
        </div>
    </div>
</div>

@can('manage series')
    @livewire('event-editor', ['event' => $event])
@endcan

@livewire('event-incidents.event-incidents', ['event' => $event])

@endsection
