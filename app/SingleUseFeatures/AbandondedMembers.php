<?php


namespace App\SingleUseFeatures;

use App\Http\Guzzle\Sgp\SgpApi;
use App\Http\Guzzle\Sgp\SgpBase;

class AbandondedMembers
{
    public static function run()
    {
        $list = SgpApi::memberList();
        $deleteList = [];
        $saveList = collect([
            'Doug Cooper',
            'Erik Strom',
            'Joe Marsiglia',
            'Josselin Merlet',
            'Kolbjørn Ålbu',
            'Matija Ličen',
            'Tim Sizeland',
            'Viktor  Janeba',
            'Maurício Redaelli',
            'Eric Hodge',
            'Antonio Guarda',
            'Marco Jurich',
            'Ryan Cody',
            'Michael Luecke',
            'Miikka Maaninka',
            'Aaron Talbert',
            'Jarrod Seccombe',
            'Thomas Atkins',
            'James Desjardine',
            'Jarrel Mayer',
            'Szymon Salamon',
            'Nicolas Alvarado'
        ]);

        foreach ($list->members as $userId => $member) {
            $response = (new SgpBase)->setCacheTTL($threeDays = 259200)->getDriverResults($userId);
            $eventCount = collect($response)->where('leagueId', 'ikG1uiyY6vvTGCTAL486M')->count();
            if ($eventCount == 0) {
                if ($saveList->contains($member->name)) {
                    dump($member->name);
                } else {
                    $deleteList[$userId] = $member->name;
                }
            }
        }
        return $deleteList;
    }
}
