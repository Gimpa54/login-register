<?php
namespace App\Utils;

use App\Utils\Auth;
use App\Utils\DbLogger;

class Logger
{
    protected static string $logPath = __DIR__ . '/../../storage/logs';
    
    /**
     * Scrive un log su file e su DB
     */
    public static function log(string $level, string $message, array $context = [], string $logFile = null): void
    {
        $date = date('Y-m-d');
        $time = date('H:i:s');
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'CLI';
        $agent = $_SERVER['HTTP_USER_AGENT'] ?? 'CLI';
        $user = Auth::user();
        $userId = $user->id ?? null;
        $userEmail = $user->email ?? null;
        
        // Ottieni file e riga chiamante
        $caller = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1] ?? [];
        $file = $caller['file'] ?? 'unknown';
        $line = isset($caller['line']) ? (int)$caller['line'] : 0;
        
        // Array log
        $log = [
            'timestamp'   => "$date $time",
            'level'       => strtoupper($level),
            'message'     => $message,
            'context'     => $context,
            'ip'          => $ip,
            'user_agent'  => $agent,
            'user'        => $userId ? "$userId ($userEmail)" : 'guest',
            'file'        => $file,
            'line'        => $line
        ];
        
        // Assicura esistenza cartella log
        if (!is_dir(self::$logPath)) {
            mkdir(self::$logPath, 0775, true);
        }
        
        // Nome file di log
        $fileName = $logFile ?? "$date.log";
        $filePath = self::$logPath . '/' . $fileName;
        
        // Scrittura su file
        file_put_contents($filePath, json_encode($log, JSON_UNESCAPED_UNICODE) . PHP_EOL, FILE_APPEND);
        
        // Salvataggio su DB
        $dbLogger = new DbLogger();
        $dbLogger->insert('logs', [
            'level'      => strtoupper($level),
            'message'    => $message,
            'context'    => json_encode($context, JSON_UNESCAPED_UNICODE),
            'ip'         => $ip,
            'user_agent' => $agent,
            'user_id'    => $userId,
            'user_email' => $userEmail,
            'file'       => $file,
            'line'       => $line,
            'log_file'   => $fileName, // nuovo campo nel DB
            'created_at' => "$date $time"
        ]);
    }
    
    public static function info(string $msg, array $ctx = [], string $logFile = null): void
    {
        self::log('info', $msg, $ctx, $logFile);
    }
    
    public static function warning(string $msg, array $ctx = [], string $logFile = null): void
    {
        self::log('warning', $msg, $ctx, $logFile);
    }
    
    public static function error(string $msg, array $ctx = [], string $logFile = null): void
    {
        self::log('error', $msg, $ctx, $logFile);
    }
    
    public static function debug(string $msg, array $ctx = [], string $logFile = null): void
    {
        self::log('debug', $msg, $ctx, $logFile);
    }
    
    public static function critical(string $msg, array $ctx = [], string $logFile = null): void
    {
        self::log('critical', $msg, $ctx, $logFile);
    }
}
