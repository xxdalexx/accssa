<?php

namespace App\MenuBuilder;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class MenuSection
{
    public $title, $icon, $active = false;

    public $targetString;

    public Collection $entries;

    public function __construct($title, $icon)
    {
        $this->title = $title;
        $this->icon = $icon;
        $this->targetString = Str::kebab($title);
        $this->entries = collect();
    }

    public function addEntry(MenuEntry $entry)
    {
        if ($entry->active) {
            $this->active = true;
        }

        $this->entries->push($entry);

        return $this;
    }
}
