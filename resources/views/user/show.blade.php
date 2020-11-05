@extends('layout.layout')

@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Tracks By Strength</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <table class="table table-striped table-bordered">
                    <tbody>
                        @foreach($tracksByStrength as $track => $null)
                        <tr>
                            <td>{{ $track }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
