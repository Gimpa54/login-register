<?php
namespace App\Utils;

class Csrf
{
    public static function generateToken(): string
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        
        $token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $token;
        return $token;
    }
    
    public static function getToken(): string
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        
        if (empty($_SESSION['csrf_token'])) {
            return self::generateToken();
        }
        
        return $_SESSION['csrf_token'];
    }
    
    public static function verifyToken(string $token): bool
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        
        return hash_equals($_SESSION['csrf_token'] ?? '', $token);
    }
}

