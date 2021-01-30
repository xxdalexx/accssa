<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminManageUsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage users');
    }

    public function index()
    {
        return view('admin.users.index');
    }
}
