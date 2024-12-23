<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use setasign\Fpdi\Tcpdf\Fpdi;

class CertificateController extends Controller
{
    public function index(){
        $templatePath = storage_path('app/templates/шаблон_1.pdf');
        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile($templatePath);
        for ($i = 1; $i <= $pageCount; $i++) {
            $templateId = $pdf->importPage($i);
            $size = $pdf->getTemplateSize($templateId);

            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);

            $pdf->useTemplate($templateId);

            $pdf->SetFont('FreeSerif', '', 12);
            $pdf->SetTextColor(255, 0, 0);
            $pdf->SetXY(10, 10);
            // $text = mb_convert_encoding("Пример текста", 'UTF-8', 'auto');
            $pdf->Write(0, 'Текст');
        }

        $outputPath = storage_path('app/public/modified_example.pdf');
        $pdf->Output($outputPath, 'F');
        return response()->download($outputPath);
    }
}
