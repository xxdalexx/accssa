<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminManageDriversController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage drivers');
    }

    public function index()
    {
        return view('admin.drivers.index');
    }
}
