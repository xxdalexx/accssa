@extends('layout.layout')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Driver Management</h4>
                </div>
            </div>
            @livewire('admin.drivers')
        </div>
    </div>
</div>

@endsection
