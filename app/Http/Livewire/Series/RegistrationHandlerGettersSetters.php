<?php


namespace App\Http\Livewire\Series;

use App\Http\Guzzle\Sgp\RequestBuilders\CarForRegistration;
use App\Models\Driver;
use App\Models\Series;

trait RegistrationHandlerGettersSetters
{
    public function getDriver()
    {
        return $this->driver;
    }

    public function getSeries()
    {
        return $this->series;
    }

    public function setSeries($series)
    {
        if ($series instanceof Series) {
            $this->series = $series;
        }

        if (is_int($series)) {
            $this->series = Series::find($series);
        }

        return $this;
    }

    public function setDriver($driver)
    {
        if ($driver instanceof Driver) {
            $this->driver = $driver;
        }

        if (is_int($driver)) {
            $this->driver = Driver::find($driver);
        }

        return $this;
    }
}
