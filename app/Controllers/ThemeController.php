<?php
namespace App\Controllers;

use App\Utils\Helper;
use App\Utils\Logger;
use App\Utils\Auth;

class ThemeController
{
    /**
     * Alterna il tema tra 'light' e 'dark' salvandolo in sessione
     */
    public function toggle()
    {
        $current = $_SESSION['theme'] ?? 'light';
        $newTheme = $current === 'light' ? 'dark' : 'light';
        $_SESSION['theme'] = $newTheme;
        
        Logger::info('Tema modificato', [
            'previous' => $current,
            'current'  => $newTheme,
            'user_id'  => Auth::user()?->id ?? null,
            'ip'       => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
        ]);
        
        $referer = $_SERVER['HTTP_REFERER'] ?? '/';
        Helper::redirect($referer);
    }
    
}
