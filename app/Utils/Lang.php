<?php
namespace App\Utils;

class Lang
{
    protected static array $strings = [];
    protected static string $locale = 'it';

    /**
     * Carica tutte le traduzioni dal file messages.json
     */
    public static function load(string $locale): void
    {
        self::$locale = $locale;
        $path = __DIR__ . '/../../langs/messages.json';

        if (!file_exists($path)) {
            throw new \Exception("File di lingua non trovato: $path");
        }

        $json = file_get_contents($path);
        $data = json_decode($json, true);

        if (!is_array($data)) {
            throw new \Exception("Errore nel parsing del file di lingua: $path");
        }

        self::$strings = $data;
    }

    /**
     * Restituisce la traduzione per la chiave indicata
     */
    public static function get(string $key, array $replace = []): string
    {
        $value = self::resolveKey($key);

        if (!is_string($value)) {
            return $key; // fallback: mostra la chiave se non trovata
        }

        foreach ($replace as $search => $replacement) {
            $value = str_replace(':' . $search, $replacement, $value);
        }

        return $value;
    }

    /**
     * Alias per get()
     */
    public static function t(string $key, array $replace = []): string
    {
        return self::get($key, $replace);
    }

    /**
     * Restituisce tutte le traduzioni della lingua corrente
     */
    public static function all(): array
    {
        $result = [];
        foreach (self::$strings as $key => $langs) {
            $result[$key] = $langs[self::$locale] ?? reset($langs);
        }
        return $result;
    }

    /**
     * Controlla se una chiave esiste per la lingua corrente
     */
    public static function has(string $key): bool
    {
        $value = self::resolveKey($key);
        return $value !== null;
    }

    /**
     * Risolve le chiavi nested (tipo "validation.min_length")
     */
    protected static function resolveKey(string $key): mixed
    {
        $segments = explode('.', $key);
        $data = self::$strings;

        foreach ($segments as $segment) {
            if (!isset($data[$segment])) {
                return null;
            }
            $data = $data[$segment];
        }

        // Se è un array, selezioniamo la traduzione nella lingua corrente
        if (is_array($data) && isset($data[self::$locale])) {
            return $data[self::$locale];
        }

        return is_string($data) ? $data : null;
    }
}
