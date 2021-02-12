<?php

namespace App\Importers;

interface FromSgpConverterContract
{
    public function format(): void;

    public function getFormatted(): array;
}
