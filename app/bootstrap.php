<?php
// Avvio sessione
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use App\Sessions\SessionHelper;
use App\Core\Router;
use App\Core\View;
use App\Middleware\LogMiddleware;
use App\Utils\Env;
use App\Utils\Flash;
use App\Utils\Helper;
use App\Utils\Lang;

// Autoload
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../autoload.php';
require_once __DIR__ . '/Utils/helpers.php';
require_once __DIR__ . '/Helpers/lang_helper.php';

// Middleware globale (es. logging)
LogMiddleware::handle();

// Carica .env
Env::load();

$lang = $_SESSION['lang'] ?? 'it';
Lang::load($lang);

// Avvia la sessione custom
SessionHelper::start();

// Timeout sessione
$timeout = Env::get('SESSION_TIMEOUT', 900); // default 15 min

// Rotte escluse dal redirect (pubbliche)
$current = $_SERVER['REQUEST_URI'] ?? '';
$excluded = [
    '/login',
    '/register',
    '/forgot-password',
    '/reset-password',
    '/verify',
    '/activate'
];

// Se l'utente è inattivo e NON è in una rotta esclusa → logout forzato
if (!in_array($current, $excluded)) {
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout) {
        unset($_SESSION['user']);
        //Flash::error(Lang::t('session_expired_please_log_in_again'));
        Flash::error(__('session_expired_please_log_in_again'));
        Helper::redirect('/login');
        exit;
    }
}

// Aggiorna il timestamp attività
$_SESSION['last_activity'] = time();

// Imposta timezone e charset
date_default_timezone_set('Europe/Rome');
mb_internal_encoding('UTF-8');

// Istanza singleton
$router = Router::getInstance();
View::init(__DIR__ . '/Views');

// Carica le rotte
require_once __DIR__ . '/../routes/web.php';

// Lancia il router
$router->dispatch();
