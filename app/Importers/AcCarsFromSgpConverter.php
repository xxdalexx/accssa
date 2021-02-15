<?php


namespace App\Importers;


use App\DataProvider\DataProvider;
use Illuminate\Support\Collection;

class AcCarsFromSgpConverter implements FromSgpConverterContract
{
    protected Collection $cars;

    protected array $formatted;

    public function __construct()
    {
        $this->cars = app('DataProvider')->getAcCars();
        $this->format();
    }

    public function getCars(): Collection
    {
        return $this->cars;
    }

    public function format(): void
    {
        foreach ($this->cars as $id => $car) {
            $new = [];
            $new['id'] = $id;
            $new['name'] = $car->name;
            $new['type'] = null;
            $new['sim'] = 'ac';


            $this->formatted[] = $new;
        }
    }

    public function getFormatted(): array
    {
        return $this->formatted;
    }
}
