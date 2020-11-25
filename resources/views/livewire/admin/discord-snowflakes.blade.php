<div class="iq-card-body">
    <div class="table-responsive">
        <table id="datatable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>User Name</th>
                    <th>Snowflake</th>
                    <th>Private Channel ID</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($drivers as $key => $driver)
                    <tr>
                        <td>
                            {{ $driver['driver_name'] }}
                        </td>
                        <td>
                            <input wire:model="drivers.{{ $key }}.discord_user_id" type="text" class="form-control" style="height: 2em">
                        </td>
                        <td>
                            {{ $driver['discord_private_channel_id'] }}
                        </td>
                        <td>
                            <button wire:click="snowflake({{ $key }})" class="btn btn-outline-primary">Update</button>
                            @if(array_key_exists('success', $driver))
                                <span class="text-success inline">Saved.</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
