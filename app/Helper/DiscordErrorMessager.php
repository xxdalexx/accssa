<?php

namespace App\Helper;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Throwable;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DiscordErrorMessager
{
    public array $ignores = [
        [
            'message' => 'The POST method is not supported for this route. Supported methods: GET, HEAD.',
            'file' => '/home/forge/default/vendor/laravel/framework/src/Illuminate/Routing/AbstractRouteCollection.php',
            'line' => 177
        ]
    ];

    public function handle(Throwable $exception)
    {
        if (App::environment('production') && $exception->getMessage()) {
            $this->sendMessage($exception);
        }
    }

    protected function sendMessage($exception)
    {
        if (Str::startsWith($exception->getMessage(), 'Unauthenticated')) return;

        $info = [
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'ip' => Request::ip()
        ];

        //ignore stored messages
        if (collect($this->ignores)->contains($info)) {
            return;
        }

        User::first()->sendDiscordDM(
            $this->buildMessage($info)
        );
    }

    protected function buildMessage($info)
    {
        $message = 'Error: ' . $info['message'] .
            ' - File: ' . $info['file'] .
            ' - Line: ' . $info['line'] .
            ' - IP:' . $info['ip'];

        if (Auth::check()) {
            $message = Auth::user()->name . ' - ' . $message;
        }

        return $message;
    }
}
