<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class Permissions extends Component
{
    public $input = [
        'user' => 0,
        'permission' => 0
    ];

    public function togglePermission()
    {
        $user = User::find($this->input['user']);
        $permissionId = (int) $this->input['permission'];

        if ($user->hasPermissionTo($permissionId)) {
            $user->revokePermissionTo($permissionId);
        } else {
            $user->givePermissionTo($permissionId);
        }
    }

    public function render()
    {
        return view('livewire.admin.permissions')->with([
            'users' => User::with('permissions')->get()->sortBy('name'),
            'permissions' => Permission::all()
        ]);
    }
}
