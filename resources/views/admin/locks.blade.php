@extends('layout.layout')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Series Locks</h4>
                </div>
            </div>
            @livewire('admin.series-locks')
        </div>
    </div>
</div>

@endsection
