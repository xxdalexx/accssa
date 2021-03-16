<?php

namespace App\MenuBuilder;

use App\Models\Series;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class MenuBuilder
{
    protected $request;

    protected Collection $menuSections;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->adminEntries = collect();
        $this->menuSections = collect();

        if (Auth::check()) {
            $this->buildAdminMenu();
            $this->buildActiveSeries();
            $this->buildArchivedSeries();
        } else {
            $this->buildLogIn();
        }

        $this->buildOpenToolsMenu();
    }

    protected function buildLogIn()
    {
        $this->menuSections->push(
            new MenuSectionNoSubs('Login', 'log-in', 'login')
        );
        $this->menuSections->push(
            new MenuSectionNoSubs('Login w/ Discord (Beta)', 'log-in', 'discordSend')
        );
    }

    protected function buildAdminMenu()
    {
        $menu = new MenuSection('Administration', 'terminal');

        if (Auth::user()->can('manage users')) {
            $menu->addEntry(
                new MenuEntry('User Management', 'admin.users')
            );
        }

        if (Auth::user()->can('manage drivers')) {
            $menu->addEntry(
                new MenuEntry('Driver Management', 'admin.drivers')
            );
        }

        if (Auth::user()->can('manage series')) {
            $menu->addEntry(
                new MenuEntry('Create Series', 'series.create')
            )->addEntry(
                new MenuEntry('Import Event', 'admin.importEvent')
            )->addEntry(
                new MenuEntry('Series Locks', 'admin.lockOverride')
            )->addEntry(
                new MenuEntry('Pre Event Checks', 'admin.preEvent')
            )->addEntry(
                new MenuEntry('Needed Tracks', 'admin.neededTracks')
            );
        }

        if (Auth::user()->can('give penalties')) {
            $menu->addEntry(
                new MenuEntry('Incident Settings', 'admin.incidents')
            );
        }

        if (Auth::user()->hasRole('admin')) {
            $menu->addEntry(
                new MenuEntry('SGP API Token', 'admin.sgpToken')
            );
        }

        if ($menu->entries->count()) {
            $this->menuSections->push($menu);
        }
    }

    protected function buildActiveSeries()
    {
        foreach (Series::active()->with('events')->get() as $series) {
            $menu = new MenuSection($series->name, 'navigation');

            $menu->addEntry(
                new MenuEntry('Standings', 'series.show', $series->id)
            );

            foreach ($series->events as $event) {
                $menu->addEntry(
                    new MenuEntry($event->session_name, 'event.show', $event->id)
                );
            }

            $this->menuSections->push($menu);
        }
    }

    protected function buildArchivedSeries()
    {
        $menu = new MenuSection('Archived Series', 'navigation');

        foreach (Series::archived()->get() as $series) {
            $menu->addEntry(
                new MenuEntry($series->name, 'series.show', $series->id)
            );
        }

        $this->menuSections->push($menu);
    }

    protected function buildOpenToolsMenu()
    {
        $openTools = new MenuSection('Open Tools', 'zap');
        $openTools->addEntry(
            new MenuEntry('Event Randomizer', 'randomizer')
        );

        $this->menuSections->push($openTools);
    }

    public function getSections()
    {
        return $this->menuSections;
    }
}
