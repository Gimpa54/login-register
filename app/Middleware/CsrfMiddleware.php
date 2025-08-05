<?php
namespace App\Middleware;

use App\Utils\Flash;

class CsrfMiddleware implements MiddlewareInterface
{
    public function handle(callable $next): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['csrf_token'] ?? '';
            $sessionToken = $_SESSION['csrf_token'] ?? '';

            if (empty($token) || $token !== $sessionToken) {
                Flash::error(__('invalid_csrf_token_please_try_again'));
                http_response_code(403);
                exit("Accesso negato (CSRF).");
            }
        }

        $next();
    }
}

