<div class="iq-card-body">
    <div class="table-responsive-sm">
        <div class="row w-100">
            <div class="col-md-4">
                <table id="datatable" class="table table-bordered">
                    <tr>
                        <th>Track:</th>
                        <th>{{ $this->trackName }}</th>
                    </tr>
                </table>
                <button wire:click="repickTrack" class="btn btn-outline-success btn-block">Repick Track</button>
                <hr>
                <input wire:model="newEntrantName" type="text" class="form-control" placeholder="Enter Name" autocomplete="off">
                <button wire:click="addEntrant" class="btn btn-outline-success btn-block">Add Entrant</button>
            </div>
            <div class="col-md-8">
                <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Car</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($this->entrants as $name => $car)
                        <tr>
                            <td>{{ $name }}</td>
                            <td>{{ $car }}</td>
                            <td>
                                <button wire:click="repickCar('{{ $name }}')" class="btn btn-outline-success">Repick</button>
                                <button wire:click="deleteEntrant('{{ $name }}')" class="btn btn-outline-danger">Delete</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
