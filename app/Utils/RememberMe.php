<?php
namespace App\Utils;

use App\Models\RememberToken;
use App\Utils\Auth;

class RememberMe
{
    public static function create(int $userId): void
    {
        // Genera selector e validator
        $selector = bin2hex(random_bytes(6)); // 12 caratteri
        $validator = bin2hex(random_bytes(32)); // 64 caratteri
        $hashedValidator = hash('sha256', $validator);

        $expires = date('Y-m-d H:i:s', time() + (86400 * 30)); // 30 giorni

        // Salva su database
        (new RememberToken())->create([
            'user_id' => $userId,
            'selector' => $selector,
            'hashed_validator' => $hashedValidator,
            'expires_at' => $expires
        ]);

        // Imposta cookie (es: remember_me = selector:validator)
        $cookieValue = "$selector:$validator";
        setcookie('remember_me', $cookieValue, [
            'expires' => time() + (86400 * 30),
            'path' => '/',
            'httponly' => true,
            'secure' => isset($_SERVER['HTTPS']),
            'samesite' => 'Strict'
        ]);
    }

    public static function autoLogin(): void
    {
        if (!isset($_COOKIE['remember_me'])) return;

        [$selector, $validator] = explode(':', $_COOKIE['remember_me'] ?? '', 2);

        if (!$selector || !$validator) return;

        $token = (new RememberToken())->findBy('selector', $selector);

        if (!$token) return;

        // Token scaduto
        if (strtotime($token->expires_at) < time()) {
            self::destroy($token->id);
            return;
        }

        if (!hash_equals($token->hashed_validator, hash('sha256', $validator))) {
            self::destroy($token->id);
            return;
        }

        // ✅ Login
        $user = Auth::getUserById($token->user_id);
        if ($user) {
            Auth::login($user);
        }

        // ✅ Refresh del token
        self::create($token->user_id); // Nuovo token
        self::destroy($token->id);     // Elimina vecchio
    }

    public static function destroy($id = null): void
    {
        if (isset($_COOKIE['remember_me'])) {
            [$selector] = explode(':', $_COOKIE['remember_me']);
            unset($_COOKIE['remember_me']);
            setcookie('remember_me', '', time() - 3600, '/');

            if (!$id && $selector) {
                $token = (new RememberToken())->findBy('selector', $selector);
                if ($token) {
                    $id = $token->id;
                }
            }
        }

        if ($id) {
            (new RememberToken())->delete($id);
        }
    }
}
