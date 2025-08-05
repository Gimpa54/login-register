<?php
namespace App\Utils;

class LoginThrottle
{
    protected static int $maxAttempts = 5;
    protected static int $decaySeconds = 900; // 15 minuti

    public static function isBlocked(string $key): bool
    {
        self::startSession();
        $attempt = $_SESSION['login_attempts'][$key] ?? null;

        if (!$attempt) {
            return false;
        }

        if ($attempt['count'] >= self::$maxAttempts) {
            $elapsed = time() - $attempt['time'];
            return $elapsed < self::$decaySeconds;
        }

        return false;
    }
    
    public static function increment(string $identifier): void
    {
        if (!isset($_SESSION['throttle'][$identifier])) {
            $_SESSION['throttle'][$identifier] = [
                'attempts' => 1,
                'last_attempt' => time()
            ];
        } else {
            $_SESSION['throttle'][$identifier]['attempts']++;
            $_SESSION['throttle'][$identifier]['last_attempt'] = time();
        }
    }

    public static function registerAttempt(string $key): void
    {
        self::startSession();

        if (!isset($_SESSION['login_attempts'][$key])) {
            $_SESSION['login_attempts'][$key] = ['count' => 1, 'time' => time()];
        } else {
            $_SESSION['login_attempts'][$key]['count']++;
            $_SESSION['login_attempts'][$key]['time'] = time();
        }
    }

    public static function clearAttempts(string $key): void
    {
        self::startSession();
        unset($_SESSION['login_attempts'][$key]);
    }

    public static function remaining(string $key): int
    {
        self::startSession();
        $attempt = $_SESSION['login_attempts'][$key] ?? ['count' => 0];
        return max(0, self::$maxAttempts - $attempt['count']);
    }

    public static function getRemainingTime(string $key): int
    {
        self::startSession();
        $attempt = $_SESSION['login_attempts'][$key] ?? null;

        if (!$attempt || $attempt['count'] < self::$maxAttempts) {
            return 0;
        }

        return max(0, self::$decaySeconds - (time() - $attempt['time']));
    }

    protected static function startSession(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }
}

