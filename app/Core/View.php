<?php
namespace App\Core;

class View
{
    protected static string $basePath;
    
    public static function init(string $basePath): void
    {
        self::$basePath = rtrim($basePath, '/');
    }
    
    public static function render(string $view, array $data = [])
    {
        
        extract($data);
        $viewPath = self::$basePath . '/' . $view . '.php';
        
        if (!file_exists($viewPath)) {
            throw new \Exception("Views '{$view}' non trovata");
        }
        
        include self::$basePath . '/layout/layout.php';
    }
    
    public static function includePartial(string $partial, array $data = [])
    {
        extract($data);
        $partialPath = self::$basePath . '/' . $partial . '.php';
        
        if (file_exists($partialPath)) {
            include $partialPath;
        }
    }
    
    public static function renderToString(string $template, array $data = []): string
    {
        extract($data);
        ob_start();
        include __DIR__ . '/../Views/' . $template . '.php';
        return ob_get_clean();
    }
    
}
