<?php
namespace App\Core;

use PDO;
use PDOException;
use App\Utils\Env;

class Connection
{
    private static ?PDO $pdo = null;
    
    public static function get(): PDO
    {
        if (self::$pdo === null) {
            Env::load(); // Carica il file .env
            
            $host = Env::get('DB_HOST');
            $dbname = Env::get('DB_NAME');
            $user = Env::get('DB_USER');
            $pass = Env::get('DB_PASS');
            $charset = Env::get('DB_CHARSET', 'utf8mb4');
            
            $dsn = "mysql:host={$host};dbname={$dbname};charset={$charset}";
            
            try {
                self::$pdo = new PDO($dsn, $user, $pass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);
            } catch (PDOException $e) {
                die("Errore connessione: " . $e->getMessage());
            }
        }
        
        return self::$pdo;
    }
}

