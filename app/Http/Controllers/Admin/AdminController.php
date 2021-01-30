<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function sgpToken()
    {
        return view('admin.sgp-token');
    }

    public function discord()
    {
        return view('admin.snowflakes');
    }

    public function discordMassMessage()
    {
        return view('admin.discord-mass-message');
    }

    public function permissions()
    {
        return view('admin.permissions');
    }

}
