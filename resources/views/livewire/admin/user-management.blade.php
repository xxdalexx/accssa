<div class="widget-content widget-content-area">

    <div class="form-group">
        <label>Filter By Name</label>
        <input wire:model="searchString" type="text" class="form-control">
    </div>

    <div class="table-responsive">
        <table id="datatable" class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">Id</th>
                    <th>Name</th>
                    <th class="text-center">Current Roles</th>
                    <th class="text-center">Reset Password</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td class="text-center">{{ $user->id }}</td>
                        <td class="text-success">{{ $user->name }}</td>
                        <td class="text-center">{{ $user->displayRoles() }}</td>
                        <td>
                            @if($user->passwordReset()->exists())
                            Pending
                            @else
                            <button wire:click="triggerPasswordReset({{ $user->id }})" class="btn btn-outline-primary btn-block">Reset Password</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
