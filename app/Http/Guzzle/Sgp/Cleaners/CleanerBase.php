<?php

namespace App\Http\Guzzle\Sgp\Cleaners;

class CleanerBase
{
    public array $cleaned;

    public object $response;

    public function __construct(object $response)
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
