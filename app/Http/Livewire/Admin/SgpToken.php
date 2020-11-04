<?php

namespace App\Http\Livewire\Admin;

use App\Models\Site;
use Livewire\Component;

class SgpToken extends Component
{
    public $tokenString;
    public $tokenSuccess = false;
    public $leagueIdString;
    public $leagueIdSuccess = false;

    public function mount()
    {
        $this->tokenString = Site::sgpToken();
        $this->leagueIdString = Site::sgpLeagueId();
    }

    public function hydrate()
    {
        $this->tokenSuccess = false;
        $this->leagueIdSuccess = false;
    }

    public function saveToken()
    {
        Site::setSgpToken($this->tokenString);
        $this->tokenSuccess = true;
    }

    public function saveLeagueId()
    {
        Site::setSgpLeagueId($this->leagueIdString);
        $this->leagueIdSuccess = true;
    }

    public function render()
    {
        return view('livewire.admin.sgp-token');
    }
}
