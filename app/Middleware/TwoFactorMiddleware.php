<?php
namespace App\Middleware;

use App\Utils\Helper;
use App\Utils\Logger;

class TwoFactorMiddleware implements MiddlewareInterface
{
    public function handle(callable $next): void
    {
        Logger::debug('TwoFactorMiddleware: inizio');
        
        // Se l'utente è autenticato ma ha ancora la 2FA in sospeso, reindirizza
        if (isset($_SESSION['2fa_pending']) && $_SESSION['2fa_pending'] === true) {
            Logger::debug('TwoFactorMiddleware: 2FA in sospeso');
            Helper::redirect('/verify-2fa');
            exit;
        }
        
        Logger::debug('TwoFactorMiddleware: 2FA completata');
        // Altrimenti continua
        $next();
    }
}
