<?php

namespace App\Http\Livewire;

use App\Helper\AccPracticeServerConfigGen;
use App\Http\Guzzle\Sgp\SgpBase;
use Livewire\Component;

class PracticeConfig extends Component
{
    public $apiFailed = false;
    public $notACC = false;
    public $type = 'quali';

    public $sgpEventId;
    public $serverNameInput = '';

    public $settings, $event, $eventRules, $assistRules;

    public function hydrate()
    {
        $this->resetErrorFields();
    }

    public function resetErrorFields()
    {
        $this->apiFailed = false;
        $this->notACC = false;
    }

    public function getInfo()
    {
        if (empty($this->sgpEventId)) {
            return;
        }

        $generator = new AccPracticeServerConfigGen($this->sgpEventId);
        $generator->setType($this->type);

        if (!empty($this->serverNameInput)) {
            $generator->setServerName($this->serverNameInput);
        }

        if (!$generator->isACC()) {
            $this->notACC = true;
            return;
        }

        $this->settings = $generator->getSettingsJson();
        $this->event = $generator->getEventJson();
        $this->eventRules = $generator->getEventRulesJson();
        $this->assistRules = $generator->getAssistRulesJson();
    }

    public function render()
    {
        return view('livewire.practice-config');
    }

}
