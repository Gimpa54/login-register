<?php
namespace App\Controllers;

use App\Core\View;
use App\Utils\Auth;
use App\Utils\Helper;
use App\Utils\Logger;
use App\Utils\Flash;
use App\Utils\PdfExporter;
use App\Utils\CsvExporter;
use App\Utils\DbLogger;

class AdminSecurityController
{
    protected string $logFile;

    public function __construct()
    {
        Auth::requireAdmin();
        $this->logFile = __DIR__ . '/../../logs/error.log';
    }

    public function index()
    {
        $filters = [
            'level' => $_GET['level'] ?? '',
            'ip'    => $_GET['ip'] ?? '',
            'route' => $_GET['route'] ?? ''
        ];
        
        $logger = new DbLogger();
        $result = $logger->searchWithFilters($filters);  // contiene ['data' => [...], 'total' => ..., 'perPage' => ..., 'page' => ...]
        
        $logs = array_map(fn($log) => (object) $log, $result['data']);;
        
        // ✅ Esportazione PDF
        if (isset($_GET['export']) && $_GET['export'] === 'pdf') {
            $html = View::renderToString('admin/log-export', ['logs' => $logs]);
            PdfExporter::export($html);
            return;
        }
        
        // ✅ Esportazione CSV
        if (isset($_GET['export']) && $_GET['export'] === 'csv') {
            CsvExporter::export($logs);
            return;
        }
        
        // ✅ Visualizza pagina con log
        View::render('admin/security-log', [
            'logs'    => $logs,
            'total'   => $result['total'],
            'perPage' => $result['perPage'],
            'page'    => $result['page'],
            'filters' => $filters,
            'title'   => 'Log di Sicurezza'
        ]);
    }
    

    public function clear()
    {
        if (file_exists($this->logFile)) {
            file_put_contents($this->logFile, '');
            Logger::log('security', 'admin', 'Log di sicurezza cancellato manualmente.');
        }

        Flash::success(__('log_successfully_emptied'));
        Helper::redirect('/admin/security-log');
    }
}
