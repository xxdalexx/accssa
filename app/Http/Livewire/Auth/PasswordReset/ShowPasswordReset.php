<?php

namespace App\Http\Livewire\Auth\PasswordReset;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ShowPasswordReset extends Component
{
    public $reset;
    public $password, $passwordVerify;

    protected $rules = [
        'password' => 'required',
        'passwordVerify' => 'required|same:password'
    ];

    public function resetPassword()
    {
        $this->validate();
        $user = $this->reset->user->resetPassword($this->password);

        $this->reset->delete();
        Auth::login($user);

        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.auth.password-reset.show-password-reset');
    }
}
