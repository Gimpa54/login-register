<?php
namespace App\Utils;

use App\Utils\Logger;
use App\Utils\DbLogger;
use App\Utils\Auth;

class ActionLogger
{
    protected static Logger $fileLogger;
    protected static DbLogger $dbLogger;
    
    /**
     * Inizializza i logger
     */
    public static function init(): void
    {
        self::$fileLogger = new Logger();
        self::$dbLogger = new DbLogger();
    }
    
    /**
     * Registra un'azione su file e DB
     *
     * @param string $action Azione compiuta (es: login, modifica profilo, ecc.)
     * @param string $level Livello (es: info, warning, error, critical)
     * @param string|null $object Tipo oggetto coinvolto (es: "user", "file", ecc.)
     * @param int|null $objectId ID dell'oggetto
     * @param array $extra Dati extra (salvati in JSON)
     */
    public static function log(
        string $action,
        string $level = 'info',
        ?string $object = null,
        ?int $objectId = null,
        array $extra = []
        ): void {
            $user = Auth::user();
            $userId = $user->id ?? null;
            
            // Log su file
            self::$fileLogger->log($level, $action, $extra);
            
            // Log su DB
            self::$dbLogger->log($level, $action, $userId, $object, $objectId, $extra);
    }
}

