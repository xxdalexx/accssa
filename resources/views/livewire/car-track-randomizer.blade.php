<div class="iq-card-body">
    <div class="table-responsive-sm">
        <div class="row w-100">
            <div class="col-md-4">
                <table id="datatable" class="table table-bordered">
                    <tr>
                        <th class="w-50">Track:</th>
                        <th class="w-50">{{ $this->trackName }}</th>
                    </tr>
                </table>
                <button wire:click="repickTrack" class="btn btn-outline-success btn-block" style="margin-top: -1.2em">Repick Track</button>
                <hr>
                <form wire:submit.prevent="addEntrant">
                    <input wire:model.lazy="newEntrantName" type="text" class="form-control" placeholder="Enter Name" autocomplete="off">
                    <button class="btn btn-outline-success btn-block">Add Entrant</button>
                </form>
            </div>
            <div class="col-md-8">
                <table id="datatable" class="table table-striped table-bordered" style="margin-bottom: 0">
                    <thead>
                        <tr>
                            <th class="w-30">Name</th>
                            <th class="w-50">Car</th>
                            <th class="w-20"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($this->entrants as $name => $car)
                        <tr>
                            <td>{{ $name }}</td>
                            <td>{{ $car }}</td>
                            <td>
                                <button wire:click="repickCar('{{ $name }}')" class="btn btn-outline-success">Repick</button>
                                <button wire:click="deleteEntrant('{{ $name }}')" class="btn btn-outline-danger">Remove</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
