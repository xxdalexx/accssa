<div>
    <div class="row">
        <div class="col-sm-12">

            <h4>Penalties</h4>

            <div class="table-responsive">
                <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Description</th>
                            <th>Points</th>
                            <th>Protected</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penalties as $penalty)
                            <tr>
                                <td>{{ $penalty->id }}</td>
                                <td>{{ $penalty->description }}</td>
                                <td>{{ $penalty->points }}</td>
                                <td>
                                    @if($penalty->protected)
                                        Yes
                                    @else
                                        No
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <hr>
            <div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Description</label>
                            <input wire:model.lazy="newPenalty.description" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Points</label>
                            <input wire:model.lazy="newPenalty.points" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-2 align-self-center">
                        <div class="custom-control custom-checkbox custom-checkbox-color-check custom-control-inline">
                            <input wire:model="newPenalty.protected" type="checkbox" class="custom-control-input bg-info" name="penalties" id="penalty-check">
                            <label class="custom-control-label" for="penalty-check">Protected</label>
                            </div>
                    </div>
                    <div class="col-md-12">
                        <button wire:click="createPenalty" class="btn btn-block btn-outline-primary">Create</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm-12">
            <h4>Incident Statuses</h4>

            <div class="table-responsive">
                <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Current Roles</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
