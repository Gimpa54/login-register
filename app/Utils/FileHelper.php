<?php
namespace App\Utils;

class FileHelper
{
    public static function getSizeFormatted(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        $bytes = max($bytes, 0);
        $pow = $bytes > 0 ? floor(log($bytes, 1024)) : 0;
        $pow = min($pow, count($units) - 1);
        
        $bytes /= (1 << (10 * $pow));
        
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
    
    public static function deleteIfExists(string $path): bool
    {
        return file_exists($path) ? unlink($path) : false;
    }
    
    public static function sanitizeFileName(string $name): string
    {
        $name = preg_replace('/[^a-zA-Z0-9-_\.]/', '_', $name);
        return strtolower(trim($name));
    }
    
    public static function saveBase64Image(string $base64, string $dir, string $filename = null): ?string
    {
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        $imageData = base64_decode(str_replace('data:image/png;base64,', '', $base64));
        $filename = $filename ?? uniqid() . '.png';
        $path = rtrim($dir, '/') . '/' . $filename;
        
        if (file_put_contents($path, $imageData)) {
            return $filename;
        }
        
        return null;
    }
}

