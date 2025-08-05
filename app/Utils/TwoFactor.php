<?php
namespace App\Utils;

use App\Models\TwoFactorToken;

class TwoFactor
{
    protected const SESSION_KEY = '2fa_code';
    protected const SESSION_EXPIRE = '2fa_expires';
    protected const LIFETIME = 300; // 5 minuti

    public static function generateCode(int $userId): int
    {
        $code = rand(100000, 999999);
        $model = new TwoFactorToken();
        $model->deleteCodesForUser($userId); // elimina codici vecchi
        $model->createToken($userId, $code);
        
        return $code;
    }
    
    public static function checkCode(int $userId, $code): bool
    {
        $model = new TwoFactorToken();
        if ($model->verifyCode($userId, (int)$code)) {
            $model->deleteCodesForUser($userId); // usato → elimina
            return true;
        }
        return false;
    }

    public static function verify(int $code): bool
    {
        self::startSession();
        
        $userId = $_SESSION['2fa_user_id'] ?? null;
        
        var_dump('VERIFY userId:', $userId, 'code:', $code);
        
        if (!$userId) return false;
        
        $tokenModel = new TwoFactorToken();
        $result = $tokenModel->verifyCode($userId, $code);
        
        var_dump('VERIFICA TOKEN:', $result);
        
        return $result;

        if (!isset($_SESSION[self::SESSION_KEY]) || !isset($_SESSION[self::SESSION_EXPIRE])) {
            return false;
        }

        if (time() > $_SESSION[self::SESSION_EXPIRE]) {
            self::clear();
            return false;
        }

        $valid = $_SESSION[self::SESSION_KEY] == $code;
        if ($valid) {
            self::clear();
        }

        return $valid;
    }

    public static function remainingTime(): int
    {
        self::startSession();
        return max(0, ($_SESSION[self::SESSION_EXPIRE] ?? 0) - time());
    }

    public static function clear(): void
    {
        unset($_SESSION[self::SESSION_KEY], $_SESSION[self::SESSION_EXPIRE]);
    }

    protected static function startSession(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }
}

