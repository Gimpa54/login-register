<?php
namespace App\Core;

use App\Middleware\AdminMiddleware;
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use App\Middleware\CsrfMiddleware;
use App\Middleware\LocaleMiddleware;
use App\Middleware\LogMiddleware;
use App\Middleware\ModeratorMiddleware;
use App\Middleware\SessionToneoutMiddleware;
use App\Middleware\TwoFactorMiddleware;
use App\Middleware\MiddlewareInterface;
use App\Utils\Logger;

class Router
{
    protected static array $routes = [];
    protected static string $baseNamespace = 'App\\Controllers\\';
    protected static ?self $instance = null;
    
    protected static array $middlewareMap = [
        'auth'      => AuthMiddleware::class,
        'guest'     => GuestMiddleware::class,
        'admin'     => AdminMiddleware::class,
        'csrf'      => CsrfMiddleware::class,
        'locale'    => LocaleMiddleware::class,
        'log'       => LogMiddleware::class,
        'moderator' => ModeratorMiddleware::class,
        'session'   => SessionToneoutMiddleware::class,
        '2fa'       => TwoFactorMiddleware::class,
    ];
    
    private function __construct() {}
    
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public static function get(string $uri, string $action, array $middleware = [])
    {
        self::$routes['GET'][$uri] = ['action' => $action, 'middleware' => $middleware];
    }
    
    public static function post(string $uri, string $action, array $middleware = [])
    {
        self::$routes['POST'][$uri] = ['action' => $action, 'middleware' => $middleware];
    }
    
    public function dispatch()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];
        $routes = self::$routes[$method] ?? [];
        
        foreach ($routes as $routeUri => $routeData) {
            $pattern = preg_replace('#\{[a-zA-Z_][a-zA-Z0-9_]*\}#', '([^/]+)', $routeUri);
            $pattern = "#^" . $pattern . "$#";
            
            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // Rimuove la stringa intera matchata
                
                $middlewareList = $routeData['middleware'] ?? [];
                $controllerAction = function () use ($routeData, $matches) {
                    [$controllerName, $methodName] = explode('@', $routeData['action']);
                    $controllerClass = self::$baseNamespace . $controllerName;
                    
                    if (!class_exists($controllerClass) || !method_exists($controllerClass, $methodName)) {
                        http_response_code(500);
                        exit("Errore: Metodo o controller non valido.");
                    }
                    
                    $controller = new $controllerClass();
                    call_user_func_array([$controller, $methodName], $matches);
                };
                
                $next = $controllerAction;
                
                // Applichiamo i middleware in ordine corretto
                foreach (array_reverse($middlewareList) as $key) {
                    $middlewareClass = self::$middlewareMap[$key] ?? $key;
                    
                    if (!class_exists($middlewareClass)) continue;
                    
                    $middleware = new $middlewareClass();
                    
                    if ($middleware instanceof MiddlewareInterface) {
                        $currentNext = $next;
                        $next = function () use ($middleware, $currentNext) {
                            $middleware->handle($currentNext);
                        };
                    } elseif (method_exists($middleware, 'handle')) {
                        // Middleware statico come LogMiddleware
                        $currentNext = $next;
                        $next = function () use ($middleware, $currentNext) {
                            $middleware::handle();
                            $currentNext();
                        };
                    }
                }
                Logger::debug('Router: esecuzione catena middleware completata, lancio controller');
                // ✅ Esegui tutta la catena
                $next();
                return;
            }
        }
        
        // ❌ Nessuna rotta trovata
        http_response_code(404);
        require __DIR__ . '/../Views/errors/404.php';
        exit;
    }
    
}