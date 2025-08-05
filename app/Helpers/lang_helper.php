<?php
use App\Utils\Lang;

if (!function_exists('__')) {
    /**
     * Restituisce una traduzione usando la lingua caricata
     *
     * @param string $key     Chiave di traduzione (es. "welcome" o "validation.min_length")
     * @param array  $replace Array di sostituzioni (es. ['min' => 8])
     * @return string
     */
    function __(string $key, array $replace = []): string
    {
        return Lang::t($key, $replace);
    }
}

