<?php
namespace App\Middleware;

use App\Utils\Flash;
use App\Utils\Env;
use App\Utils\Logger;
use App\Utils\Helper;

class SessionToneoutMiddleware implements MiddlewareInterface
{
    public function handle(callable $next): void
    {
        Logger::debug('SessionToneoutMiddleware: inizio');
        
        $timeout = Env::get('SESSION_TIMEOUT', 900); // in secondi

        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout) {
            Logger::debug('SessionToneoutMiddleware: sessione scaduta');
            session_unset();
            session_destroy();
            Flash::warning(__('session_expired_for_inactivity'));
            Helper::redirect('/login');
            exit;
        }

        Logger::debug('SessionToneoutMiddleware: sessione valida');
        $_SESSION['last_activity'] = time();

        $next();
    }
}

