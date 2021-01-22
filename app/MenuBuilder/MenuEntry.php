<?php

namespace App\MenuBuilder;

class MenuEntry
{
    public $title, $link, $active;

    public function __construct($title, $link, $active = false)
    {
        $this->title = $title;
        $this->link = $link;
        $this->active = $active;
    }
}
