<?php
/**
 * Esempi d'Uso in un Controller
 * 
 * $userModel = new User();
 * 
 * Trova utente per ID
 * $user = $userModel->findById(5);
 * 
 * Trova primo con email
 * $user = $userModel->findBy('email', 'mario@example.com');
 * 
 * Tutti gli admin
 * $admins = $userModel->findWhere('role', 'admin');
 * 
 * Controlla se email già registrata
 * if ($userModel->exists('email', 'mario@example.com')) {
 * Flash::error('Email già usata');
 * Helper::redirect('/register');
 * }
 * 
 * Paginazione su utenti attivi
 * $users = $userModel->paginate("SELECT * FROM users WHERE is_active = 1");
 * 
 * Conta utenti per ruolo
 * $tot = $userModel->count("role = :role", ['role' => 'admin']);
 * 
 * Elimina per ID
 * $userModel->deleteById(5);
 * 
 * Update per email
 * $userModel->updateBy('email', 'mario@example.com', ['is_active' => 0]); 
 */
namespace App\Core;

use App\Core\Database;

class BaseModel extends Database
{
    protected $table;

    # Lettura / Ricerca
    
    // Trova tutti i record
    public function findAll()
    {
        return $this->fetchAll("SELECT * FROM {$this->table}");
    }
    
    // Trova per ID (un solo record)
    public function findById($id)
    {
        return $this->fetch("SELECT * FROM {$this->table} WHERE id = :id", ['id' => $id]);
    }

    // Trova il primo record dove una colonna ha un certo valore
    public function findBy($column, $value)
    {
        return $this->fetch("SELECT * FROM {$this->table} WHERE {$column} = :value LIMIT 1", ['value' => $value]);
    }
    
    // Trova tutti i record che corrispondono a una colonna
    public function findWhere($column, $value)
    {
        return $this->fetchAll("SELECT * FROM {$this->table} WHERE {$column} = :value", ['value' => $value]);
    }
    
    // Trova il primo record che soddisfa una certa condizione complessa
    public function firstWhere(string $condition, array $params = [])
    {
        return $this->fetch("SELECT * FROM {$this->table} WHERE {$condition} LIMIT 1", $params);
    }
    
    // Trova tutti i record che soddisfano una condizione arbitraria
    public function where(string $condition, array $params = [])
    {
        return $this->fetchAll("SELECT * FROM {$this->table} WHERE {$condition}", $params);
    }
    
    // Verifica se esiste almeno un record con un certo valore
    public function exists(string $table, string $column, $value): bool
    {
        // Se non viene passato il nome della tabella, usa quella del modello
        $table = $table ?: $this->table;
        return parent::exists($table, $column, $value);
    }
    
    // Trova un record o mostra 404
    public function findOrFail($id)
    {
        $record = $this->findById($id);
        if (!$record) {
            http_response_code(404);
            require __DIR__ . '/../Views/errors/404.php';
            exit;
        }
        return $record;
    }
    
    #Creazione / Aggiornamento
    
    // Inserisce un nuovo record
    public function create(array $data)
    {
        return $this->insert($this->table, $data);
    }
    
    // Aggiorna un record per ID
    public function update(int $id, array $data)
    {
        return $this->updateById($this->table, $id, $data);
    }
    
    // Aggiorna per una colonna
    public function updateBy($column, $value, array $data)
    {
        return $this->updateByColumn($this->table, $column, $value, $data);
    }

    # Eliminazione
    
    // Elimina per colonna
    public function deleteBy(string $column, $value): bool
    {
        return $this->deleteByColumn($this->table, $column, $value);
    }

    // Elimina per ID
    public function deleteById($id): bool
    {
        return $this->deleteBy('id', $id);
    }
    
    // Marcare come cancellato senza cancellare
    public function softDeleteById($id)
    {
        return $this->update($id, ['deleted_at' => date('Y-m-d H:i:s')]);
    }

    # Paginazione e Conteggio
    
    public function paginate(string $sql, array $params = [], int $perPage = 10): array
    {
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $offset = ($page - 1) * $perPage;
        
        // Calcolo totale righe senza LIMIT
        $countSql = "SELECT COUNT(*) FROM (" . preg_replace('/\s+LIMIT\s+\:limit\s+OFFSET\s+\:offset/i', '', $sql) . ") AS subquery";
        $total = $this->fetchColumn($countSql, $params);
        
        // Aggiungi limit/offset alla query originale
        $sql .= " LIMIT :limit OFFSET :offset";
        $params['limit'] = $perPage;
        $params['offset'] = $offset;
        
        $data = $this->fetchAll($sql, $params);
        
        return [
            'data' => $data,
            'total' => (int)$total,
            'perPage' => $perPage,
            'page' => $page
        ];
    }
    
    
    
    
    // Conta tutti i record (con condizione opzionale)
    public function count(string $table = '', string $condition = '1=1', array $params = []): int
    {
        $table = $table ?: $this->table;
        return parent::count($table, $condition, $params);
    }
    
    
    // Conta con una colonna specifica
    public function countBy(string $column, $value): int
    {
        return $this->count("{$column} = :value", ['value' => $value]);
    }
}
