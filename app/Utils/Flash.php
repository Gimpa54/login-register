<?php
namespace App\Utils;

class Flash
{
    protected static string $key = 'flash_messages';
    
    public static function add(string $type, string $message): void
    {
        $_SESSION[self::$key][$type][] = $message;
    }
    
    public static function success(string $message): void
    {
        self::add('success', $message);
    }
    
    public static function error(string $message): void
    {
        self::add('error', $message);
    }
    
    public static function warning(string $message): void
    {
        self::add('warning', $message);
    }
    
    public static function info(string $message): void
    {
        self::add('info', $message);
    }
    
    public static function get(): array
    {
        $messages = $_SESSION[self::$key] ?? [];
        unset($_SESSION[self::$key]);
        
        return $messages;
    }
    
    public static function display(): void
    {
        if (empty($_SESSION[self::$key])) {
            return;
        }
        
        foreach ($_SESSION[self::$key] as $type => $messages) {
            foreach ((array) $messages as $message) {
                $alertClass = match ($type) {
                    'success' => 'alert-success',
                    'error'   => 'alert-danger',
                    'warning' => 'alert-warning',
                    'info'    => 'alert-info',
                    default   => 'alert-secondary',
                };
                
                echo '<div class="alert ' . $alertClass . ' alert-dismissible fade show" role="alert">';
                echo htmlspecialchars($message);
                echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                echo '</div>';
            }
        }
        
        unset($_SESSION[self::$key]);
    }

}

