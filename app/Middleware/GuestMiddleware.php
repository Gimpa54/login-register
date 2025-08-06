<?php
namespace App\Middleware;

use App\Utils\Auth;
use App\Utils\Flash;
use App\Utils\Helper;

class GuestMiddleware implements MiddlewareInterface
{
    public function handle(callable $next): void
    {
        if (Auth::check()) {
            Flash::info(__('you_are_already_authenticated'));
            Helper::redirect('/user/dashboard');
            exit;
        }
        
        $next();
    }
}