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
                            <input wire:model="importString" type="text" class="form-control">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-outline-secondary">Import</button>
                            </div>
                        </div>
                    </form>
                </div>
                @if($this->importSuccess)
                    <p class="text-success">{{ $this->importedDriverName }} Imported</p>
                @endif
                @if($this->apiFailed)
                    <p class="text-danger">Connection to SGP failed. Check Token.</p>
                @endif
            </div>

            <table id="datatable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>DBID</th>
                        <th wire:click="$set('sortBy', 'driver_name')" class="finger">Name</th>
                        <th wire:click="$set('sortBy', 'driver_score')" class="finger">Score</th>
                        <th>Split</th>
                        <th>Account</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($drivers as $driver)
                    <tr>
                        <td>{{ $driver->id }}</td>
                        <td>{{ $driver->driver_name }}</td>
                        <td>
                            {{ $driver->driver_score }}
                            <div wire:click="calculateScore({{ $driver->id }})" class="finger pull-right">
                                <i class="ri-refresh-line"></i>
                            </div>
                        </td>
                        <td>
                            {{ $driver->currentSplit }}
                        </td>
                        <td>
                            @if($driver->user()->exists())
                                <i class="ri-check-fill"></i>
                            @elseif($driver->invite()->exists())
                                {{ $driver->invite->code }}
                            @else
                                <input wire:model.lazy="snowflakes.driver{{ $driver->id }}" class="form-control" style="height: 2em">
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
