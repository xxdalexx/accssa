<?php

namespace App\Helper;

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
        if (env('APP_ENV') == "production" && $exception->getMessage()) {
            $this->sendMessage($exception);
        }
    }

    protected function sendMessage($exception)
    {
        $info = [
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine()
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
        $message = 'Error: ' . $info['message'] . ' - File: ' . $info['file'] . ' - Line: ' . $info['line'];
        if (Auth::check()) {
            $message = Auth::user()->name . ' - ' . $message;
        }
        return $message;
    }
}
