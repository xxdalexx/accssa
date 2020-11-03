<?php

namespace App\Http\Livewire\Auth\Invite;

use App\Models\Invite;
use Livewire\Component;

class CodeInput extends Component
{
    public $inviteCode;
    public $failed = false;

    public function checkCode()
    {
        $invite = Invite::where('code', $this->inviteCode)->first();

        if ($invite) {
            return redirect()->route('invite.show', $invite);
        }
        $this->failed = true;
    }

    public function render()
    {
        return view('livewire.auth.invite.code-input');
    }
}
