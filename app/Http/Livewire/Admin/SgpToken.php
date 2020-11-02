<?php

namespace App\Http\Livewire\Admin;

use App\Models\Site;
use Livewire\Component;

class SgpToken extends Component
{
    public $tokenString;
    public $success = false;

    public function mount()
    {
        $this->tokenString = Site::sgpToken();
    }

    public function hydrate()
    {
        $this->success = false;
    }

    public function saveToken()
    {
        Site::setSgpToken($this->tokenString);
        $this->success = true;
    }

    public function render()
    {
        return view('livewire.admin.sgp-token');
    }
}
