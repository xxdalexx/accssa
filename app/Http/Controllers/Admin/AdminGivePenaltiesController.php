<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminGivePenaltiesController extends Controller
{
    public function incidentSettings()
    {
        return view('admin.incident-settings');
    }
}
