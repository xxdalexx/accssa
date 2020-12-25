<div class="table-responsive">
    <div class="row">
        <div class="col-md-6">
            <table id="datatable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @if(array_key_exists($splitName, $points))
                        @forelse($points[$splitName][0] as $name => $point)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $name }}</td>
                            <td>{{ $point }}</td>
                        </tr>
                        @php
                            $finalLoop = $loop->iteration;
                        @endphp
                        @empty
                        @endforelse
                    @endif
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <table id="datatable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @if(array_key_exists($splitName, $points))
                        @forelse($points[$splitName][1] as $name => $point)
                        <tr>
                            <td>{{ $loop->iteration + $finalLoop }}</td>
                            <td>{{ $name }}</td>
                            <td>{{ $point }}</td>
                        </tr>
                        @empty
                        @endforelse
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
