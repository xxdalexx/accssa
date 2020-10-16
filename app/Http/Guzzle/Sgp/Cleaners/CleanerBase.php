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
        return $this->cleaned;
    }

    public function getResponse(): object
    {
        return $this->response;
    }
}
