<?php
namespace App\Controllers;

use App\Core\View;
use App\Utils\LogReader;
use App\Utils\Csrf;
use App\Utils\Helper;
use App\Utils\Auth;
use App\Utils\Flash;
use App\Utils\PdfExporter;
use App\Utils\CsvExporter;

class AdminLogController
{
    public function index()
    {
        $date = $_GET['date'] ?? date('Y-m-d');
        $search = $_GET['search'] ?? '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 20;
        
        $filePathTxt = __DIR__ . "/../../storage/logs/{$date}.txt";
        $filePathLog = __DIR__ . "/../../storage/logs/{$date}.log";
        
        
        // Verifica file esistente
        if (!file_exists($filePathTxt) && !file_exists($filePathLog)) {
            Flash::error(__('file_not_found_for_the_selected_date'));
            View::render('admin/logs/index', [
                'logs'   => [],
                'date'   => $date,
                'search' => $search,
                'csrf'   => Csrf::generateToken(),
                'page'   => $page,
                'totalPages' => 0
            ]);
            return;
        }
        
        $filePath = file_exists($filePathTxt) ? $filePathTxt : $filePathLog;
        
        // ✅ Legge ogni riga (una entry JSON per riga)
        $logs = [];
        foreach (file($filePath) as $line) {
            $line = trim($line);
            if (!$line) continue;
            
            $entry = json_decode($line, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                if ($search && stripos(json_encode($entry), $search) === false) {
                    continue;
                }
                $logs[] = $entry;
            }
        }
        
        // ✅ Calcolo paginazione
        $total = count($logs);
        $totalPages = ceil($total / $perPage);
        $offset = ($page - 1) * $perPage;
        $logs = array_slice($logs, $offset, $perPage);
        
        View::render('admin/logs/index', [
            'logs'        => $logs,
            'date'        => $date,
            'search'      => $search,
            'csrf'        => Csrf::generateToken(),
            'page'        => $page,
            'totalPages'  => $totalPages
        ]);
    }
    
    
    public function exportCsv()
    {
        $date = $_GET['date'] ?? date('Y-m-d');
        $search = $_GET['search'] ?? '';
        $filePath = __DIR__ . "/../../storage/logs/$date.txt";
        
        if (!file_exists($filePath)) {
            $filePath = __DIR__ . "/../../storage/logs/$date.log";
            if (!file_exists($filePath)) {
                // ❌ Non fare redirect, ma mostra testo (debug temporaneo)
                header("HTTP/1.1 404 Not Found");
                echo "❌ File non trovato.";
                exit;
            }
        }
        
        $raw = file_get_contents($filePath);
        $entries = explode("\n", trim($raw));
        //$entries = preg_split('/\R{2,}/', trim($raw));
        $logs = [];
        
        foreach ($entries as $entryRaw) {
            $entry = json_decode($entryRaw, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                if ($search && stripos(json_encode($entry), $search) === false) {
                    continue;
                }
                $logs[] = $entry;
            }
        }
        
        // ✅ Se nessun log trovato, restituisci CSV vuoto con solo intestazioni
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="log-' . $date . '.csv"');
        header('Pragma: no-cache');
        header('Expires: 0');
        
        $output = fopen('php://output', 'w');
        fputcsv($output, ['Timestamp', 'Livello', 'Messaggio', 'IP', 'User', 'File', 'Linea']);
        
        foreach ($logs as $log) {
            fputcsv($output, [
                $log['timestamp'] ?? '',
                $log['level'] ?? '',
                $log['message'] ?? '',
                $log['ip'] ?? '',
                $log['user'] ?? '',
                $log['file'] ?? '',
                $log['line'] ?? ''
            ]);
        }
        
        fclose($output);
        exit;
    }
    
    
    
    public function exportPDF()
    {
        $date = $_GET['date'] ?? date('Y-m-d');
        $search = $_GET['search'] ?? '';
        
        $filePath = __DIR__ . "/../../storage/logs/$date.txt";
        if (!file_exists($filePath)) {
            $filePath = __DIR__ . "/../../storage/logs/$date.log";
            if (!file_exists($filePath)) {
                Flash::error(__('file_not_found_for_the_selected_date'));
                Helper::redirect('/admin/logs');
                return;
            }
        }
        
        $logs = [];
        
        // ✅ Ogni riga del file è un oggetto JSON
        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        foreach ($lines as $line) {
            $entry = json_decode($line, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                if ($search && stripos(json_encode($entry), $search) === false) {
                    continue;
                }
                $logs[] = $entry;
            }
        }
        
        // ✅ Genera HTML dalla view e lo passa a PdfExporter
        $html = View::renderToString('admin/log-export', [
            'logs' => $logs,
            'date' => $date,
            'search' => $search
        ]);
        
        PdfExporter::export($html, "log-$date.pdf");
    }
}

