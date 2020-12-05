<?php

namespace App\Helper;

use Carbon\Carbon;

class GoogleCalendar
{
    protected $text, $startDate, $endDate, $details;
    protected Carbon $carbonStartDate;

    public function setTitle(string $title)
    {
        $this->text = $title;
        return $this;
    }

    public function setStartDate(string $date)
    {
        $this->carbonStartDate = Carbon::parse($date);
        $this->startDate = $this->carbonStartDate->format('Ymd\THis\Z');
        return $this;
    }

    public function addDurationForEndDate(int $durationMinutes)
    {
        $this->endDate = $this->carbonStartDate->addMinutes($durationMinutes + 5)->format('Ymd\THis\Z');
        return $this;
    }

    public function setDetails(string $details)
    {
        $this->details = $details;
        return $this;
    }

    public function getLink()
    {
        $link = "https://www.google.com/calendar/render?action=TEMPLATE";
        $link .= "&text=" . str_replace(" ", "+", $this->text);
        $link .= "&dates=" . $this->startDate . '/' . $this->endDate;

        if (isset($this->details)) {
            $link .= "&details=" . str_replace(" ", "+", $this->details);
        }

        return $link;
    }

    public function __toString()
    {
        return $this->getLink();
    }
}
