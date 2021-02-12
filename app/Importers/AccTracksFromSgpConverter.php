<?php


namespace App\Importers;


use Illuminate\Support\Collection;

class AccTracksFromSgpConverter implements FromSgpConverterContract
{
    protected array $formatted;

    protected Collection $tracks;

    public function __construct()
    {
        $this->tracks = app('DataProvider')->getAccTracks();
        $this->format();
    }

    public function format(): void
    {
        foreach ($this->tracks as $track) {
            $new = [];

            $new['track_id'] = $track->key;
            $new['name'] = $track->name;
            $new['length'] = $track->length;
            $new['max_entries'] = $track->maxEntries;

            $this->formatted[] = $new;
        }
    }

    public function getFormatted(): array
    {
        return $this->formatted;
    }

    public function getTracks(): Collection
    {
        return $this->tracks;
    }
}
