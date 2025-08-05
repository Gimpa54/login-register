<?php
namespace App\Middleware;

use App\Utils\Lang;

class LocaleMiddleware implements MiddlewareInterface
{
    public function handle(callable $next): void
    {
        // Lingua
        if (isset($_GET['lang']) && in_array($_GET['lang'], ['it', 'en'])) {
            $_SESSION['lang'] = $_GET['lang'];
        }
        
        $lang = $_SESSION['lang'] ?? 'it';
        
        Lang::load($lang);
        
        // Tema
        if (!isset($_SESSION['theme'])) {
            $_SESSION['theme'] = 'light';
        }
        
        $next();
    }
}

