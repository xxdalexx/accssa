@extends('layout.layout')

@section('content')

@section('title', $event->session_name)

<div class="row">
    <div class="col-sm-12">

        @include('event._card-header')

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

@can('manage series')
    <hr>
    @livewire('event-editor', ['event' => $event])
@endcan

<hr>

@livewire('event-incidents.event-incidents', ['event' => $event])

@endsection
