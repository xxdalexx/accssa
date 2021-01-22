<?php

namespace App\MenuBuilder;

use App\Models\Series;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class MenuBuilder
{

    protected $request;

    protected Collection $adminEntries;

    protected Collection $menuSections;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->adminEntries = collect();
        $this->menuSections = collect();
        $this->buildAdminMenu();
        $this->buildMenu();
    }

    protected function buildAdminMenu()
    {

        if (Auth::user()->can('manage users')) {
            $this->addAdminEntry('User Management', 'admin.users');
        }

        if (Auth::user()->can('manage drivers')) {
            $this->addAdminEntry('Driver Management', 'admin.drivers');
        }

        if (Auth::user()->can('manage series')) {
            $this->addAdminEntry('Create Series', 'series.create');
            $this->addAdminEntry('Import Event', 'admin.importEvent');
            $this->addAdminEntry('Series Locks', 'admin.lockOverride');
            $this->addAdminEntry('Pre Event Checks', 'admin.preEvent');
            $this->addAdminEntry('Needed Tracks', 'admin.neededTracks');
        }

        if (Auth::user()->can('give penalties')) {
            $this->addAdminEntry('Incident Settings', 'admin.incidents');
        }

        if (Auth::user()->hasRole('admin')) {
            $this->addAdminEntry('SGP API Token', 'admin.sgpToken');
        }
    }

    protected function addAdminEntry($title, $route)
    {
        $active = false;
        if ($route == $this->request->route()->getName()) {
            $active = true;
        }
        $this->adminEntries->push(new MenuEntry($title, route($route), $active));
    }

    protected function buildMenu()
    {
        $this->buildActiveSeries();
        $openTools = new MenuSection('Open Tools', 'zap');
        $openTools->addEntry(
            new MenuEntry('Event Randomizer', route('randomizer'))
        )->addEntry(
            new MenuEntry('Practice Server Config', route('practiceConfig'))
        );

        $this->menuSections->push($openTools);
    }

    protected function buildActiveSeries()
    {
        foreach (Series::with('events')->get() as $series) {
            $menu = new MenuSection($series->name, 'navigation');

            $menu->addEntry(
                new MenuEntry('Standings', $series->link())
            );

            foreach ($series->events as $event) {
                $menu->addEntry(
                    new MenuEntry($event->session_name, $event->link())
                );
            }

            $this->menuSections->push($menu);
        }
    }

    public function getSections()
    {
        return $this->menuSections;
    }

    public function getAdminEntries()
    {
        return $this->adminEntries;
    }

    public function showAdmin()
    {
        return $this->adminEntries->count() > 0;
    }
}
