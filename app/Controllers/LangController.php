<?php
namespace App\Controllers;

use App\Utils\Helper;
use App\Utils\Logger;
use App\Utils\Auth;
use App\Utils\Lang;

class LangController
{
    /**
     * Cambia lingua e reindirizza alla pagina precedente.
     * Esempio: /lang/it oppure /lang/en
     */
    public function set($lang)
    {
        // Lingue supportate
        $available = ['it', 'en', 'fr', 'de', 'es', 'pt'];

        if (in_array($lang, $available)) {
            $_SESSION['lang'] = $lang;

            // Ricarica subito le traduzioni per la lingua scelta
            Lang::load($lang);

            Logger::info('Lingua modificata', [
                'lang'     => $lang,
                'user_id'  => Auth::user()?->id ?? null,
                'ip'       => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
            ]);
        } else {
            Logger::warning('Tentativo di impostare una lingua non supportata', [
                'attempted_lang' => $lang,
                'user_id'        => Auth::user()?->id ?? null,
                'ip'             => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
            ]);
        }

        // Torna alla pagina precedente
        $referer = $_SERVER['HTTP_REFERER'] ?? '/';
        Helper::redirect($referer);
    }
}
