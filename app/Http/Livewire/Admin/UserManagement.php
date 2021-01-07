<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use App\Notifications\PasswordResetNotification;
use Livewire\Component;

class UserManagement extends Component
{
    public $users;

    public function mount()
    {
        $this->users = User::all();
    }

    public function triggerPasswordReset(User $user)
    {
        $reset = $user->createPasswordReset();
        $user->notify(new PasswordResetNotification($reset));
    }

    public function render()
    {
        return view('livewire.admin.user-management');
    }
}
