<?php
namespace App\Middleware;

use App\Utils\Logger;
use App\Utils\Auth;

class LogMiddleware
{
    public static function handle(): void
    {
        Logger::debug('LogMiddleware: eseguito');
        
        $user = Auth::user();
        
        Logger::info(
            'Accesso alla rotta: ' . $_SERVER['REQUEST_URI'],
            [
                'ip'         => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
                'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
                'method'     => $_SERVER['REQUEST_METHOD'],
                'route'      => $_SERVER['REQUEST_URI'] ?? '',
                'user_id'    => $user->id ?? null,
                'session_id' => session_id(),
            ]
            );
    }
}

