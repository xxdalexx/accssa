@extends('layout.layout')

@section('content')

@section('title', $title . ' - Standings')

<div class="row">
    <div class="col-sm-12">

        @if($dropOne)
        This series is a drop one standings.
        @endif

        <div class="table-responsive">
            <div class="row m-auto">
                <div class="col-md-6">
                    <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Name</th>
                                <th class="text-center">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($points[0] as $name => $point)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-success">{{ $name }}</td>
                                <td class="text-center">{{ $point }}</td>
                            </tr>
                            @php
                            $finalLoop = $loop->iteration;
                            @endphp
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Name</th>
                                <th class="text-center">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($points[1] as $name => $point)
                            <tr>
                                <td class="text-center">{{ $loop->iteration + $finalLoop }}</td>
                                <td class="text-success">{{ $name }}</td>
                                <td class="text-center">{{ $point }}</td>
                            </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
