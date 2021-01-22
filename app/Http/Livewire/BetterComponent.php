<?php

namespace App\Http\Livewire;

use Livewire\Component;

class BetterComponent extends Component
{
    protected function success($title, $message)
    {
        $this->sendAlert($title, $message);
    }

    protected function warning($title, $message)
    {
        $this->sendAlert($title, $message, 'warning');
    }

    protected function inform($title, $message)
    {
        $this->sendAlert($title, $message, 'info');
    }

    protected function sendAlert($title, $message, $type = 'success')
    {
        $this->emit('alert', $title, $message, $type);
    }
}
