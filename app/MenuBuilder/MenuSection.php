<?php

namespace App\MenuBuilder;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class MenuSection
{
    public $title, $icon;

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
        $this->entries->push($entry);
        return $this;
    }
}
