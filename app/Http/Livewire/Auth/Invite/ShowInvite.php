<?php

namespace App\Http\Livewire\Auth\Invite;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ShowInvite extends Component
{
    public $invite;
    public $email;
    public $password;
    public $passwordVerify;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
        'passwordVerify' => 'required|same:password'
    ];

    public function register()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->invite->driver->driver_name,
            'driver_id' => $this->invite->driver->id,
            'email' => $this->email,
            'password' => Hash::make($this->password)
        ]);

        Auth::login($user);

        $this->invite->delete();

        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.auth.invite.show-invite');
    }
}
