<?php

namespace App\Http\Controllers;

use App\Http\Guzzle\Sgp\RequestBuilders\RemoveDriverFromEvent;
use App\Http\Guzzle\Sgp\SgpBase;
use App\Http\Guzzle\Sgp\SgpPost;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DevController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index()
    {
        $override = 'change';
        $override = $override ?: 'defalut';

        dd($override);
    }

    public function aindex()
    {
        return redirect()->route('home');
    }

    public function loginMe()
    {
        $user = User::first();
        Auth::login($user);

        return redirect()->route('home');
    }

    public function loginAs(User $user)
    {
        Auth::login($user);
        return redirect()->route('home');
    }

}
