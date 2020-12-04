<?php

namespace App\Http\Guzzle\Sgp\Cleaners;

class CleanerBase
{
    public array $cleaned;

    public $response;

    public function __construct($response)
    {
        $this->response = $response;
        $this->clean();
    }

    protected function clean()
    {
        dd('Build Me');
    }

    public function getCleaned()
    {
        if (isset($this->cleaned)) {
            return $this->cleaned;
        }
        return null;
    }

    public function getResponse(): object
    {
        return $this->response;
    }
}
