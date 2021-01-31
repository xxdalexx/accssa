<?php

namespace App\Http\Livewire\Admin;

use App\Models\Event;
use App\Http\Livewire\BetterComponent;
use App\Http\Livewire\BetterInputs;

class ImportEvent extends BetterComponent
{
    use BetterInputs;

    protected $rules = [
        'seriesId' => 'required',
        'sgpEventId' => 'required',
        'hasResults' => 'required',
        'minLaps' => 'required|numeric'
    ];

    protected function inputDefaults()
    {
        $this->setInputDefault('minLaps', 20);
        $this->setInputDefault('seriesId', dbFirstId('series'));
        $this->setInputDefault('minLaps', 20);
    }

    public function submitForm()
    {
        $this->validate();

        if ($this->input('hasResults')) {
            $event = Event::build(
                $this->input('sgpEventId'),
                $this->input('seriesId'),
                $this->input('minLaps')
            );
        } else {
            $event = Event::buildPreResults(
                $this->input('sgpEventId'),
                $this->input('seriesId')
            );
        }

        //api call failed
        if (!$event) {
            $this->alertApiCallFailed();
            return;
        }

        return redirect($event->link());
    }

    public function render()
    {
        return view('livewire.admin.import-event');
    }
}
