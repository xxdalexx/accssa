<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use App\Http\Livewire\BetterComponent;
use App\Notifications\PasswordResetNotification;

class UserManagement extends BetterComponent
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
        $this->success('Password Reset Sent', 'DM sent to ' . $user->name . ' with a link to reset their password.');
    }

    public function render()
    {
        return view('livewire.admin.user-management');
    }
}
