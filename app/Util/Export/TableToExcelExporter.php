<?php


namespace App\Util\Export;


use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class TableToExcelExporter
{
    public static function exportSingle($table, $path)
    {
        self::exportAll([$table], $path);
    }

    public static function exportAll($tables, $path)
    {
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getDefaultStyle()
            ->getNumberFormat()
            ->setFormatCode('#');

        $spreadsheet->removeSheetByIndex(0);
        foreach ($tables as $table) {
            $tableName = $table[0];
            $tableRows = $table[1];
            $sheet = $spreadsheet->createSheet();
            $sheet->getColumnDimension('A')->setWidth(50);
            $sheet->getColumnDimension('B')->setWidth(80);
            $i = 1;
            foreach ($tableRows as $row) {
                if ($row[0] === UserToTableConverter::META_TITLE) {
                    $sheet->setCellValueExplicit("A$i", $row[1], DataType::TYPE_STRING);
                    $sheet->getStyle("A$i")->getFont()->setBold(true);
                } else {
                    $sheet->setCellValueExplicit("A$i", $row[0], DataType::TYPE_STRING);
                    $sheet->setCellValueExplicit("B$i", $row[1], DataType::TYPE_STRING);
                }
                $i++;
            }
        }
        $writer = new Xlsx($spreadsheet);
        $writer->save($path);
    }
}
