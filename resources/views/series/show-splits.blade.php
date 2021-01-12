@extends('layout.layout')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="iq-card">
            @include('series._card-header')
            <div class="iq-card-body">

                @if($series->registration_locked)
                    @livewire('series.registration', ['series' => $series])
                    </div></div><div class="iq-card"><div class="iq-card-body">
                @endif

                @includeif('series.info.' . $series->id)

                <h4 class="text-center mb-2">AM Split</h4>
                @include('series._split-table', ['splitName' => 'AM'])
                <hr>
                <h4 class="text-center mb-2">Silver Split</h4>
                @include('series._split-table', ['splitName' => 'Silver'])
                <hr>
                <h4 class="text-center mb-2">Pro Split</h4>
                @include('series._split-table', ['splitName' => 'Pro'])
                @if(isset($points['No Score']))
                    <hr>
                    <h4 class="text-center mb-2">No Split Qualification</h4>
                    @include('series._split-table', ['splitName' => 'No Score'])
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
