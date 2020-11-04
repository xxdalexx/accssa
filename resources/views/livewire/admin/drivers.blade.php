<div class="iq-card-body">
    <div class="table-responsive">
        <div class="row w-100">

            <div class="col-md-6">
                <div class="form-group">
                    <label>Filter By Driver Name</label>
                    <input wire:model="searchString" type="text" class="form-control">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <form wire:submit.prevent="import">
                        <label>Import Driver by SGP ID</label>
                        <div class="input-group">
                            <input type="text" class="form-control">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-outline-secondary">Import</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <table id="datatable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Score</th>
                        <th>Account</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($drivers as $driver)
                    <tr>
                        <td>{{ $driver->driver_name }}</td>
                        <td>
                            {{ $driver->driver_score }}
                            <div wire:click="calculateScore({{ $driver->id }})" class="finger pull-right">
                                <i class="ri-refresh-line"></i>
                            </div>
                        </td>
                        <td>
                            @if($driver->user()->exists())
                                <i class="ri-check-fill"></i>
                            @elseif($driver->invite()->exists())
                                {{ $driver->invite->code }}
                            @else
                                <a wire:click.prevent="genInvite({{ $driver->id }})" href='#'>Generate Invite Code</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
