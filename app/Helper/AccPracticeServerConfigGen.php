<?php

namespace App\Helper;

use App\Http\Guzzle\Sgp\SgpBase;

class AccPracticeServerConfigGen
{
    protected $config;
    protected $trackId;
    protected $passwords;
    protected $serverName;
    protected $game;

    public function __construct(string $sgpEventId)
    {
        $result = (new SgpBase)->getPreEventDetails($sgpEventId);
        $this->game = $result->game;

        if ($this->game != 'acc') {
            return;
        }

        $this->serverName = $result->leagueName . ' Practice Server';
        $this->trackId = $result->trackId;
        $this->config = $result->config;
        $this->setPasswordsFromSGP();
    }

    public function isACC()
    {
        return $this->game == 'acc';
    }

    public function setServerName(string $serverName)
    {
        if (!empty($serverName)) {
            $this->serverName = $serverName;
        }
    }

    protected function setPasswordsFromSGP()
    {
        //Commented out code until a better way to figure out api calls.
        //$passwords = $this->config->passwords;
        $this->passwords['server'] = '';
        $this->passwords['admin'] = '';
        $this->passwords['spectator'] = '';
        // $this->passwords['server'] = $passwords->server ?? '';
        // $this->passwords['admin'] = $passwords->admin ?? '';
        // $this->passwords['spectator'] = $passwords->spectator ?? '';
    }

    public function getSettingsJson()
    {
        $settings = [];

        $settings['serverName'] = $this->serverName;
        $settings['password'] = $this->passwords['server'];
        $settings['adminPassword'] = $this->passwords['admin'];
        $settings['spectatorPassword'] = $this->passwords['spectator'];
        $settings['carGroup'] = "FreeForAll";
        $settings['trackMedalsRequirement'] = 0;
        $settings['safetyRatingRequirement'] = 0;
        $settings['racecraftRatingRequirement'] = 0;
        $settings['maxCarSlots'] = 30;
        $settings['dumpLeaderboards'] = 0;
        $settings['isRaceLocked'] = 1;
        $settings['randomizeTrackWhenEmpty'] = 0;
        $settings['centralEntryListPath'] = "";
        $settings['allowAutoDQ'] = 1;
        $settings['shortFormationLap'] = 0;
        $settings['dumpEntryList'] = 0;
        $settings['formationLapType'] = 3;

        return prettyJson(collect($settings));
    }

    public function getEventJson()
    {
        $event = [];
        $weather = $this->config->trackCondition->weather;

        $event['track'] = $this->trackId;
        $event['preRaceWaitingTimeSeconds'] = 30;
        $event['sessionOverTimeSeconds'] = 30;
        $event['ambientTemp'] = $weather->ambientTemp;
        $event['cloudLevel'] = $weather->cloudLevel;
        $event['rain'] = $weather->rain;
        $event['weatherRandomness'] = $weather->weatherRandomness;
        $event['configVersion'] = 1;
        $event['isFixedConditionQualification'] = 1;


        $session['hourOfDay'] = $this->getFirstRaceHourOfDay();
        $session['dayOfWeekend'] = 3;
        $session['timeMultiplier'] = 1;
        $session['sessionType'] = "Q";
        $session['sessionDurationMinutes'] = 120;

        $event['sessions'][0] = $session;

        return prettyJson(collect($event));
    }

    protected function getFirstRaceHourOfDay()
    {
        $firstRace = collect($this->config->parts)->firstWhere('sessionType', 'R');
        return $firstRace->hourOfDay;
    }

    public function getEventRulesJson()
    {
        return prettyJson($this->defaultEventRules());
    }

    public function getAssistRulesJson()
    {
        $assists = collect($this->config->difficulty->assists);
        return prettyJson($assists);
    }

    protected function defaultEventRules()
    {
        $json = '
        {
            "qualifyStandingType": 1,
            "pitWindowLengthSec": -1,
            "driverStintTimeSec": -1,
            "mandatoryPitstopCount": 0,
            "maxTotalDrivingTime": -1,
            "maxDriversCount": 1,
            "isRefuellingAllowedInRace": true,
            "isRefuellingTimeFixed": false,
            "isMandatoryPitstopRefuellingRequired": false,
            "isMandatoryPitstopTyreChangeRequired": false,
            "isMandatoryPitstopSwapDriverRequired": false,
            "tyreSetCount": 50
           }
        ';

        return collect(json_decode($json));
    }
}
