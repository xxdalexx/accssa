<div class="iq-card-body">
    <div class="table-responsive">
        <div class="row w-100">
            <table id="datatable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Current Roles</th>
                        <th>Reset Password</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->displayRoles() }}</td>
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
</div>
