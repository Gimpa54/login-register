<?php
namespace App\Middleware;

use App\Utils\Auth;
use App\Utils\Flash;
use App\Utils\Helper;
use App\Utils\Logger;

class AuthMiddleware implements MiddlewareInterface
{
    public function handle(callable $next): void
    {
        Logger::debug('AuthMiddleware: inizio');
        
        if (!Auth::check() && !isset($_SESSION['2fa_pending'])) {
            Logger::debug('AuthMiddleware: utente non autenticato né in attesa 2FA');
            Flash::error(__('access_denied_login'));
            Helper::redirect('/login');
           exit;
        }
        
        Logger::debug('AuthMiddleware: utente autorizzato');
        $next();
    }
}

