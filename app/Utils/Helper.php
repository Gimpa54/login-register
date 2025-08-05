<?php
namespace App\Utils;

class Helper
{
    // Sanifica una stringa
    public static function sanitize(string $value): string
    {
        return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
    }

    // Redirect a un URL
    public static function redirect(string $url): void
    {
        header("Location: $url");
        exit;
    }

    // Verifica se la richiesta è POST
    public static function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    // Recupera il valore precedente di un campo (form repopulation)
    public static function old(string $key, $default = ''): string
    {
        return isset($_POST[$key]) ? self::sanitize($_POST[$key]) : $default;
    }

    // Evidenzia la route attiva nel menu
    public static function isActiveRoute(string $route): string
    {
        return $_SERVER['REQUEST_URI'] === $route ? 'active' : '';
    }

    // Ottiene l'indirizzo IP reale dell'utente
    public static function getIp(): string
    {
        return $_SERVER['HTTP_CLIENT_IP']
            ?? $_SERVER['HTTP_X_FORWARDED_FOR']
            ?? $_SERVER['REMOTE_ADDR']
            ?? '0.0.0.0';
    }

    // Rimuove campi "di sistema" (es. CSRF token) da $_POST
    public static function cleanPost(array $post, array $exclude = ['csrf_token']): array
    {
        foreach ($exclude as $key) {
            unset($post[$key]);
        }
        return $post;
    }

    // Genera una slug SEO-friendly da una stringa
    public static function slugify(string $string): string
    {
        $string = preg_replace('/[^a-zA-Z0-9\s]/', '', strtolower($string));
        $string = preg_replace('/[\s-]+/', '-', $string);
        return trim($string, '-');
    }

    // HTML helper: selected
    public static function selected($value, $expected): string
    {
        return $value == $expected ? 'selected' : '';
    }

    // HTML helper: checked
    public static function checked($value, $expected): string
    {
        return $value == $expected ? 'checked' : '';
    }

    // Restituisce l'URL completo per un asset
    public static function asset(string $path): string
    {
        $base = $_ENV['APP_URL'] ?? '/';
        return rtrim($base, '/') . '/' . ltrim($path, '/');
    }
    
    public static function url(string $path = '', array $params = []): string
    {
        $base = rtrim(env('APP_URL'), '/') . '/';
        $url = ltrim($path, '/');
        
        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }
        
        return $base . $url;
    }
}
