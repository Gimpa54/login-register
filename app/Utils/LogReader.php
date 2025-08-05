<?php
namespace App\Utils;

class LogReader
{
    public static function read(string $date, string $search = ''): array
    {
        $basePath = __DIR__ . '/../../storage/logs/';
        $pathLog = $basePath . "$date.log";
        $pathTxt = $basePath . "$date.txt";
        $path = file_exists($pathLog) ? $pathLog : (file_exists($pathTxt) ? $pathTxt : null);
        
        if (!$path) return [];
        
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $results = [];
        
        foreach ($lines as $line) {
            $entry = json_decode($line, true);
            if (!is_array($entry)) continue;
            
            // ✅ Inversione corretta
            if (isset($entry['message'], $entry['level'])) {
                $entry['real_level'] = $entry['message']; // "info"
                $entry['message'] = $entry['level'];      // "ACCESSO ALLA ROTTA: ..."
                $entry['level'] = $entry['real_level'];
            }
            
            // ✅ Filtro per messaggio, livello e contesto
            if ($search !== '') {
                $haystack = strtolower($entry['message'] ?? '') . ' ' .
                    strtolower($entry['level'] ?? '') . ' ' .
                    strtolower(json_encode($entry['context'] ?? []));
                    if (!str_contains($haystack, strtolower($search))) {
                        continue;
                    }
            }
            
            $results[] = $entry;
        }
        
        return $results;
    }
    
    
}
