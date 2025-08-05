<?php
namespace App\Utils;

use App\Core\BaseModel;
use App\Utils\Auth;

class DbLogger extends BaseModel
{
    protected $table = 'logs';
    
    public function log(string $level, string $message, array $context = []): void
    {
        $ip        = $_SERVER['REMOTE_ADDR'] ?? 'CLI';
        $agent     = $_SERVER['HTTP_USER_AGENT'] ?? 'CLI';
        $user      = Auth::user();
        $userId    = $user->id ?? null;
        $userEmail = $user->email ?? null;
        
        $caller = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1] ?? [];
        $file   = $caller['file'] ?? 'unknown';
        $line   = $caller['line'] ?? 0;
        
        $data = [
            'level'       => strtoupper($level),
            'message'     => $message,
            'context'     => json_encode($context, JSON_UNESCAPED_UNICODE),
            'ip'          => $ip,
            'user_agent'  => $agent,
            'user_id'     => $userId,
            'user_email'  => $userEmail,
            'file'        => $file,
            'line'        => $line,
            'created_at'  => date('Y-m-d H:i:s')
        ];
        
        $this->insert($this->table, $data);
    }
    
    public function info(string $msg, array $ctx = [])     { $this->log('info', $msg, $ctx); }
    public function warning(string $msg, array $ctx = [])  { $this->log('warning', $msg, $ctx); }
    public function error(string $msg, array $ctx = [])    { $this->log('error', $msg, $ctx); }
    public function debug(string $msg, array $ctx = [])    { $this->log('debug', $msg, $ctx); }
    public function critical(string $msg, array $ctx = []) { $this->log('critical', $msg, $ctx); }
    
    public function searchWithFilters(array $filters = [], int $perPage = 20): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE 1=1";
        $params = [];
        
        if (!empty($filters['level'])) {
            $sql .= " AND level = :level";
            $params['level'] = $filters['level'];
        }
        
        if (!empty($filters['ip'])) {
            $sql .= " AND ip LIKE :ip";
            $params['ip'] = '%' . $filters['ip'] . '%';
        }
        
        if (!empty($filters['route'])) {
            $sql .= ' AND JSON_EXTRACT(context, "$.route") LIKE :route';
            $params['route'] = '%' . $filters['route'] . '%';
        }
        
        $sql .= " ORDER BY created_at DESC";
        
        return $this->paginate($sql, $params, 20); // 20 log per pagina
    }
}
