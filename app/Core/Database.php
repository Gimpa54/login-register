<?php
namespace App\Core;

use App\Core\Connection;
use PDO;
use PDOException;
use App\Utils\Logger;

class Database
{
    protected PDO $pdo;
    
    public function __construct()
    {
        $this->pdo = Connection::get();
    }
    
    protected function query(string $sql, array $params = []): \PDOStatement
    {
        $stmt = $this->pdo->prepare($sql);
        
        foreach ($params as $key => $value) {
            $paramType = is_int($value) ? \PDO::PARAM_INT : \PDO::PARAM_STR;
            
            // Se la query contiene ? e la chiave è numerica (parametri posizionali)
            if (is_int($key)) {
                $stmt->bindValue($key + 1, $value, $paramType); // Posizionali in PDO sono 1-based
            } else {
                // Parametri nominativi: 'username' → ':username'
                $paramName = strpos($key, ':') === 0 ? $key : ":$key";
                $stmt->bindValue($paramName, $value, $paramType);
            }
        }
        
        $stmt->execute();
        return $stmt;
    }
    
    
    public function fetch(string $sql, array $params = []): ?object
    {
        $stmt = $this->query($sql, $params);
        return $stmt->fetch(PDO::FETCH_OBJ) ?: null;
    }
    
    public function fetchAll(string $sql, array $params = []): array
    {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    
    public function fetchColumn(string $sql, array $params = []): mixed
    {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchColumn();
    }
    
    public function insert(string $table, array $data): bool
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_map(fn($key) => ":$key", array_keys($data)));
        
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        return $this->query($sql, $data)->rowCount() > 0;
    }
    
    public function updateById(string $table, int $id, array $data): bool
    {
        $set = implode(', ', array_map(fn($key) => "$key = :$key", array_keys($data)));
        $data['id'] = $id;
        
        $sql = "UPDATE $table SET $set WHERE id = :id";
        return $this->query($sql, $data)->rowCount() > 0;
    }
    
    public function updateByColumn(string $table, string $column, $value, array $data): bool
    {
        $sets = [];
        $params = [];
        
        foreach ($data as $key => $val) {
            $sets[] = "$key = :set_$key";
            $params["set_$key"] = $val;
        }
        
        $params['where_value'] = $value;
        
        $sql = "UPDATE $table SET " . implode(', ', $sets) . " WHERE $column = :where_value";
        return $this->query($sql, $params)->rowCount() > 0;
    }
    
    public function deleteByColumn(string $table, string $column, $value, string $operator = '='): bool
    {
        $sql = "DELETE FROM $table WHERE $column $operator :value";
        return $this->query($sql, ['value' => $value])->rowCount() > 0;
    }
    
    # 🔢 Funzioni aggregate (min, max, avg, sum)
    
    // Ritorna un valore aggregato
    public function aggregate(string $table, string $function, string $column, string $condition = '1=1', array $params = [])
    {
        $sql = "SELECT $function($column) as value FROM $table WHERE $condition";
        $result = $this->fetch($sql, $params);
        return $result->value ?? null;
    }
    
    # 💾 Inserimento con ritorno dell'ID
    
    // Inserisce un record e ritorna l'ID inserito
    public function insertAndGetId(string $table, array $data): ?int
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_map(fn($k) => ":$k", array_keys($data)));
        
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        // 👇 DEBUG: mostriamo SQL e parametri
        Logger::debug('Tentativo INSERT', [
            'sql' => $sql,
            'params' => $data
        ], 'register.log');
        
        $this->query($sql, $data);
        return (int) $this->lastInsertId();
    }
    
    # ❌ DELETE con condizione personalizzata
    
    // Elimina record con condizione personalizzata
    public function deleteWhere(string $table, string $condition, array $params): bool
    {
        $sql = "DELETE FROM $table WHERE $condition";
        return $this->query($sql, $params)->rowCount() > 0;
    }
    
    # 🔄 UPDATE con condizioni complesse
    
    // Update con condizione personalizzata
    public function updateWhere(string $table, string $condition, array $data, array $params): bool
    {
        $set = implode(', ', array_map(fn($k) => "$k = :$k", array_keys($data)));
        $allParams = array_merge($data, $params);
        $sql = "UPDATE $table SET $set WHERE $condition";
        return $this->query($sql, $allParams)->rowCount() > 0;
    }
    
    # 🧮 COUNT, EXISTS
    
    // Conta i record con condizione personalizzata
    public function count(string $table, string $condition = '1=1', array $params = []): int
    {
        $sql = "SELECT COUNT(*) as total FROM $table WHERE $condition";
        $result = $this->fetch($sql, $params);
        return $result ? (int)$result->total : 0;
    }
    
    // Verifica se un valore esiste in una colonna
    public function exists(string $table, string $column, $value): bool
    {
        $sql = "SELECT 1 FROM $table WHERE $column = :value LIMIT 1";
        return (bool) $this->fetch($sql, ['value' => $value]);
    }
    
    # 🔎 SELECT dinamico
    
    // Esegui una query con WHERE personalizzabile e ritorna oggetti
    public function selectWhere(string $table, string $condition = '1=1', array $params = []): array
    {
        $sql = "SELECT * FROM $table WHERE $condition";
        return $this->fetchAll($sql, $params);
    }
    
    // SELECT con JOIN (LEFT, INNER, ecc.)
    public function selectJoin(string $sql, array $params = []): array
    {
        return $this->fetchAll($sql, $params);
    }
    
    public function lastInsertId(): string
    {
        return $this->pdo->lastInsertId();
    }
    
    public function beginTransaction(): void
    {
        $this->pdo->beginTransaction();
    }
    
    public function commit(): void
    {
        $this->pdo->commit();
    }
    
    public function rollBack(): void
    {
        $this->pdo->rollBack();
    }
}

