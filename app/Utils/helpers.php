<?php

use App\Utils\Csrf;

if (!function_exists('csrf')) {
    function csrf(): string
    {
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(Csrf::getToken(), ENT_QUOTES, 'UTF-8') . '">';
    }
}

if (!function_exists('sanitize')) {
    function sanitize(string $value): string
    {
        return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('redirect')) {
    function redirect(string $url): void
    {
        header("Location: $url");
        exit;
    }
}

if (!function_exists('is_post')) {
    function is_post(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
}

if (!function_exists('old')) {
    function old(string $key, $default = ''): string
    {
        return htmlspecialchars($_SESSION['old'][$key] ?? $default, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('clear_old')) {
    function clear_old(): void
    {
        unset($_SESSION['old']);
    }
}

if (!function_exists('is_active_route')) {
    function is_active_route(string $route): string
    {
        return $_SERVER['REQUEST_URI'] === $route ? 'active' : '';
    }
}

if (!function_exists('get_ip')) {
    function get_ip(): string
    {
        return $_SERVER['HTTP_CLIENT_IP']
        ?? $_SERVER['HTTP_X_FORWARDED_FOR']
        ?? $_SERVER['REMOTE_ADDR']
        ?? '0.0.0.0';
    }
}

if (!function_exists('e')) {
    function e(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}

function selected($a, $b): string {
    return $a == $b ? 'selected' : '';
}

function env($key, $default = null)
{
    return \App\Utils\Env::get($key, $default);
}

function logger(): \App\Utils\DbLogger {
    return new \App\Utils\DbLogger();
}
