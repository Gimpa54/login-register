<?php
namespace App\Models;

use App\Core\BaseModel;

class UserDevice extends BaseModel
{
    protected $table = 'user_devices';
    
    public function log(int $userId, string $ip, string $userAgent): void
    {
        $device = $this->getByUserAndAgent($userId, $userAgent);
        
        $this->updateAll(['is_current' => 0], 'user_id = :uid', ['uid' => $userId]);
        
        $location = $this->resolveLocation($ip);
        
        if ($device) {
            $this->update($device->id, [
                'ip_address' => $ip,
                'last_login' => date('Y-m-d H:i:s'),
                'is_current' => true,
                'location'    => $device->location ?: $location
            ]);
        } else {
            $this->create([
                'user_id'     => $userId,
                'ip_address'  => $ip,
                'user_agent'  => $userAgent,
                'device_info' => $this->parseDeviceInfo($userAgent),
                'last_login'  => date('Y-m-d H:i:s'),
                'is_current'  => true,
                'location'    => $location
            ]);
        }
    }
    
    public function getByUser(int $userId): array
    {
        return $this->fetchAll("SELECT * FROM {$this->table} WHERE user_id = :id ORDER BY last_login DESC", ['id' => $userId]);
    }
    
    public function getByUserAndAgent(int $userId, string $agent): ?object
    {
        return $this->fetch("SELECT * FROM {$this->table} WHERE user_id = :id AND user_agent = :ua", [
            'id' => $userId,
            'ua' => $agent
        ]);
    }
    
    private function resolveLocation(string $ip): ?string
    {
        // Non geolocalizzare IP locali
        if (in_array($ip, ['127.0.0.1', '::1'])) {
            return 'Locale';
        }
        
        $url = "http://ip-api.com/json/{$ip}?fields=status,country,regionName,city";
        
        $response = @file_get_contents($url);
        if (!$response) return null;
        
        $data = json_decode($response, true);
        
        if ($data['status'] === 'success') {
            $parts = array_filter([$data['city'], $data['regionName'], $data['country']]);
            return implode(', ', $parts);
        }
        
        return null;
    }
    
    
    
    private function parseDeviceInfo(string $userAgent): string
    {
        if (stripos($userAgent, 'Windows')) return 'Windows';
        if (stripos($userAgent, 'Mac')) return 'MacOS';
        if (stripos($userAgent, 'Linux')) return 'Linux';
        if (stripos($userAgent, 'Android')) return 'Android';
        if (stripos($userAgent, 'iPhone')) return 'iPhone';
        return 'Dispositivo sconosciuto';
    }
}