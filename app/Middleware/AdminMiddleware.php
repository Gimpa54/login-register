<?php
namespace App\Middleware;

use App\Utils\Auth;
use App\Utils\Flash;
use App\Utils\Helper;

class AdminMiddleware implements MiddlewareInterface
{
    public function handle(callable $next): void
    {
        if (!Auth::isAdmin()) {
            Flash::error(__('access_restricted_to_administrators'));
            Helper::redirect('/login');
            exit;
        }
        
        $next();
    }
}


