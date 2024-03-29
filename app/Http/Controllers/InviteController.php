<?php

namespace App\Http\Controllers;

use App\Models\Invite;
use App\Models\ResetPassword;
use Illuminate\Http\Request;

class InviteController extends Controller
{
    public function index()
    {
        return view('auth.invite.index');
    }

    public function show(Invite $invite)
    {
        $invite->load('driver');
        return view('auth.invite.show')->with([
            'invite' => $invite,
            'name' => $invite->driver->driver_name
        ]);
    }

    public function showReset(ResetPassword $reset)
    {
        return view('auth.password-reset.show')->with([
            'reset' => $reset,
            'user' => $reset->user
        ]);
    }
}
