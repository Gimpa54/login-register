<?php
namespace App\Utils;

class CsvExporter
{
    /**
     * Esporta un array di log in formato CSV
     */
    public static function export(array $data, string $filename = 'log-export.csv'): void
    {
        header('Content-Type: text/csv; charset=utf-8');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        
        $output = fopen('php://output', 'w');
        
        // Intestazioni CSV
        fputcsv($output, [
            'Timestamp', 'Livello', 'Messaggio', 'IP', 'User', 'User-Agent', 'File', 'Linea'
        ]);
        
        foreach ($data as $log) {
            fputcsv($output, [
                $log['timestamp'] ?? '',
                $log['level'] ?? '',
                $log['message'] ?? '',
                $log['ip'] ?? '',
                $log['user'] ?? '',
                $log['user_agent'] ?? '',
                $log['file'] ?? '',
                $log['line'] ?? '',
            ]);
        }
        
        fclose($output);
        exit;
    }
}

