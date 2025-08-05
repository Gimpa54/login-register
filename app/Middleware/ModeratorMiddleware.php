<?php
namespace App\Middleware;

use App\Utils\Flash;
use App\Utils\Helper;

class ModeratorMiddleware implements MiddlewareInterface
{
    public function handle(callable $next): void
    {
        session_start();

        $role = $_SESSION['user_role'] ?? null;

        if (!in_array($role, ['admin', 'moderator'])) {
            Flash::error(__('access_restricted_ to_moderators_or_administrators'));
            Helper::redirect('/');
            exit;
        }

        $next();
    }
}

