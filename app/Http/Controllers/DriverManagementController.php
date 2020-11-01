<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;

class DriverManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage drivers');
    }

    public function index()
    {
        return view('admin.drivers.index')
            ->withDrivers(Driver::all());
    }
}
