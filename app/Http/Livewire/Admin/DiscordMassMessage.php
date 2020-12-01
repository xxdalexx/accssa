<?php

namespace App\Http\Livewire\Admin;

use App\Models\Driver;
use Livewire\Component;

class DiscordMassMessage extends Component
{
    public $messageString, $success;

    public function hydrate()
    {
        $this->success = false;
    }

    public function sendMessage()
    {
        Driver::massDiscordMessage($this->messageString);
        $this->success = true;
    }

    public function render()
    {
        return view('livewire.admin.discord-mass-message');
    }
}
