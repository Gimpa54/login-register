<?php
namespace App\Utils;

use App\Utils\Flash;
use App\Utils\Helper;
use App\Models\User;

class Auth
{
    public static function login(object $user): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        
        $_SESSION['last_activity'] = time(); 
        
        $_SESSION['user'] = [
            'id'            => $user->id,
            'email'         => $user->email,
            'firstname'     => $user->firstname ?? '',
            'lastname'      => $user->lastname ?? '',
            'username'      => $user->username ?? '',
            'avatar'        => $user->avatar ?? '',
            'bio'           => $user->bio ?? '',
            'address'       => $user->address ?? '',
            'city'          => $user->city ?? '',
            'postal_code'   => $user->postal_code ?? '',
            'province'      => $user->province ?? '',
            'country'       => $user->country ?? '',
            'phone'         => $user->phone ?? '',
            'role'          => $user->role ?? 'user'
        ];
        
    }

    public static function check(): bool
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        
        return self::user() !== null;
        
    }

    public static function user(): ?object
    {
        return isset($_SESSION['user']) ? (object) $_SESSION['user'] : null;
    }

    public static function id(): ?int
    {
        return self::check() ? ($_SESSION['user']['id'] ?? null) : null;
    }

    public static function isAdmin(): bool
    {
        return self::check() && ($_SESSION['user']['role'] ?? '') === 'admin';
    }

    public static function logout(): void
    {
        unset($_SESSION['user']);
    }

    public static function requireLogin(): void
    {
        if (!self::check()) {
            Flash::error('Effettua il login per accedere.');
            Helper::redirect('/login');
        }
    }

    public static function requireAdmin(): void
    {
        if (!self::check() || ($_SESSION['user']['role'] ?? '') !== 'admin') {
            Flash::error('Accesso riservato agli amministratori.');
            Helper::redirect('/login');
        }
    }
    
    public static function getUserById(int $id): ?object
    {
        return (new User())->findById($id);
    }
}



