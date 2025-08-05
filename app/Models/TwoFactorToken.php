<?php
namespace App\Models;

use App\Core\BaseModel;

class TwoFactorToken extends BaseModel
{
    protected $table = 'two_factor_tokens';

    public function createToken(int $userId, int $code, int $lifetime = 300): bool
    {
        $this->deleteCodesForUser($userId);

        $expires = date('Y-m-d H:i:s', time() + $lifetime);

        return $this->create([
            'user_id'    => $userId,
            'code'       => $code,
            'expires_at' => $expires,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function verifyCode(int $userId, int $code): bool
    {
        // Rimuovi il controllo della scadenza dalla query
        $sql = "SELECT * FROM {$this->table} WHERE user_id = :uid AND code = :code ORDER BY id DESC LIMIT 1";
        $params = ['uid' => $userId, 'code' => $code];
        
        $row = $this->fetch($sql, $params);
        
        if (!$row) return false;
        
        // Confronta scadenza in PHP
        return $row->expires_at > date('Y-m-d H:i:s');
    }
    
   
    public function deleteCodesForUser(int $userId): void
    {
        $this->deleteBy('user_id', $userId);
    }
}
