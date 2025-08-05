<?php
namespace App\Utils;

class Env
{
    protected static array $vars = [];
    
    public static function load(string $defaultFile = __DIR__ . '/../../.env'): void
    {
        if (!file_exists($defaultFile)) {
            throw new \RuntimeException("File .env non trovato: $defaultFile");
        }
        
        self::parse($defaultFile);
        
        // Se APP_ENV è definito, carica anche il file .env.APP_ENV
        if (isset(self::$vars['APP_ENV'])) {
            $envSuffix = trim(self::$vars['APP_ENV']);
            $envFile = dirname($defaultFile) . "/.env.$envSuffix";
            
            if (file_exists($envFile)) {
                self::parse($envFile); // sovrascrive eventuali valori duplicati
            }
        }
        
        // Importa in $_ENV, $_SERVER e putenv
        foreach (self::$vars as $key => $value) {
            putenv("$key=$value");
            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;
        }
    }
    
    protected static function parse(string $file): void
    {
        $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (str_starts_with(trim($line), '#')) {
                continue;
            }
            if (!str_contains($line, '=')) {
                continue;
            }
            
            [$name, $value] = array_map('trim', explode('=', $line, 2));
            $value = trim($value, '"\'');
            self::$vars[$name] = $value;
        }
    }
    
    public static function get(string $key, $default = null): mixed
    {
        return self::$vars[$key] ?? getenv($key) ?: $default;
    }
}
