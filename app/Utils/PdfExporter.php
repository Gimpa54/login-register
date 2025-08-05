<?php
namespace App\Utils;

use Dompdf\Dompdf;
use Dompdf\Options;

class PdfExporter
{
    public static function export(string $html, string $filename = 'report.pdf'): void
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('defaultFont', 'DejaVu Sans');
        
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        $dompdf->stream($filename, ['Attachment' => true]);
        exit;
    }
}
