<?php

namespace App\Exports;

use App\Models\FormAnswerModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class BodExport implements FromCollection, WithEvents
{
    public function collection()
    {
        return collect([]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $model = FormAnswerModel::all();
                $sheet = $event->sheet->getDelegate(); // Gunakan getDelegate() di sini

                $this->setupPage($sheet);
                $this->buildPrintLayout($sheet, $model);
                $this->applyStyles($sheet);
            },
        ];
    }

    protected function setupPage($sheet)
    {
        $sheet->getPageSetup()
            ->setOrientation(PageSetup::ORIENTATION_LANDSCAPE)
            ->setPaperSize(PageSetup::PAPERSIZE_A4)
            ->setFitToWidth(1)
            ->setFitToHeight(0);

        $sheet->getPageMargins()
            ->setTop(0.5)
            ->setRight(0.25)
            ->setLeft(0.25)
            ->setBottom(0.5);
    }

    protected function buildPrintLayout($sheet, $model)
    {
        // Header Section
        $sheet->mergeCells('A1:B4');
        $imagePath = public_path('img/company-logo.png');
        
        if (file_exists($imagePath)) {
            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $drawing->setPath($imagePath);
            $drawing->setHeight(90);
            $drawing->setCoordinates('A1');
            $drawing->setOffsetY(15);
            $drawing->setOffsetX(500);
            $drawing->setWorksheet($sheet);
        }

        $sheet->mergeCells('C1:G3');
        $sheet->setCellValue('C1', 'FORM TEMUAN GENBA MANAGEMENT');
        $sheet->mergeCells('C4:G4');
        $sheet->setCellValue('C4', 'EHS COMITTE');

        $sheet->setCellValue('H1', 'Approved By');
        $sheet->setCellValue('I1', 'Checked By');
        $sheet->setCellValue('J1', 'Prepared By');

        $sheet->mergeCells('H2:H3');
        $sheet->mergeCells('I2:I3');
        $sheet->mergeCells('J2:J3');

        $sheet->setCellValue('H4', 'Rian Effendi');
        $sheet->setCellValue('I4', 'Muhlisin');
        $sheet->setCellValue('J4', 'Renti Iswarindra');
        
        $sheet->mergeCells('L1:M1');
        $sheet->mergeCells('L2:M2');
        $sheet->mergeCells('L3:M3');
        $sheet->mergeCells('L4:M4');
        
        $sheet->setCellValue('K1', 'No Document');
        $sheet->setCellValue('K2', 'Revision');
        $sheet->setCellValue('K3', 'Effective Start');
        $sheet->setCellValue('K4', 'Page');

        $sheet->setCellValue('L1', 'FR/API-HRGA/EHS/018/18');
        $sheet->setCellValue('L2', '1');
        $sheet->setCellValue('L3', '2023-10-01');
        $sheet->setCellValue('L4', '1');

        // Month Section
        $sheet->mergeCells('A5:M6');
        $sheet->setCellValue('A5', 'Bulan : April 2025');

        // Table Header
        $sheet->setCellValue('A7', 'No');
        $sheet->mergeCells('B7:C7');
        $sheet->setCellValue('B7', 'Temuan Lapangan');
        $sheet->setCellValue('D7', 'Lokasi');
        $sheet->setCellValue('E7', 'Temuan');
        $sheet->setCellValue('F7', 'Kategori');
        $sheet->mergeCells('G7:H7');
        $sheet->setCellValue('G7', 'Improvment');
        $sheet->setCellValue('I7', 'PIC');
        $sheet->setCellValue('J7', 'DD');
        $sheet->mergeCells('K7:L7');
        $sheet->setCellValue('K7', 'Perbaikan');
        $sheet->setCellValue('M7', 'Status');

        // Table Data
        $row = 8;
        foreach ($model as $index => $item) {
            $sheet->setCellValue("A{$row}", $index + 1);
            $sheet->mergeCells("B{$row}:C{$row}");
            $sheet->mergeCells("G{$row}:H{$row}");
            $sheet->mergeCells("K{$row}:L{$row}");

            // Handle image insertion
            if (!empty($item->img_path)) {
                $imgPath = public_path("storage/{$item->img_path}");

                if (file_exists($imgPath)) {
                    [$imgWidth, $imgHeight] = getimagesize($imgPath);
                    $aspectRatio = $imgHeight / $imgWidth;
                    $colWidth = 30;
                    $sheet->getColumnDimension('B')->setWidth($colWidth);
                    
                    $colWidthPx = $colWidth * 7;
                    $imgHeightPx = $colWidthPx * $aspectRatio;
                    $rowHeight = $imgHeightPx;
                    
                    $sheet->getRowDimension($row)->setRowHeight($rowHeight);

                    $objDrawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                    $objDrawing->setPath($imgPath);
                    $objDrawing->setCoordinates("B{$row}");
                    $objDrawing->setResizeProportional(true);
                    $objDrawing->setHeight($imgHeightPx);
                    $objDrawing->setOffsetX(5);
                    $objDrawing->setOffsetY(5);
                    $objDrawing->setWorksheet($sheet);
                }
            }

            $sheet->setCellValue("D{$row}", $item->detail_area ?? '');
            $sheet->setCellValue("E{$row}", $item->deskripsi ?? '');
            $sheet->setCellValue("F{$row}", '');
            $sheet->setCellValue("G{$row}", $item->masukan ?? '');
            $sheet->setCellValue("I{$row}", $item->pic ?? '');
            $sheet->setCellValue("J{$row}", $item->created_at ? date('d/m/y', strtotime($item->created_at)) : '');
            $sheet->setCellValue("K{$row}", $item->perbaikan ?? '');
            $sheet->setCellValue("M{$row}", '');

            // Set default row height if no image
            if (empty($item->img_path)) {
                $sheet->getRowDimension($row)->setRowHeight(25);
            }

            $row++;
        }
    }

    protected function applyStyles($sheet)
    {
        // Alignment
        $sheet->getStyle('A1:M4')->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);
        
        $sheet->getStyle('A5:M6')->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_LEFT)
            ->setVertical(Alignment::VERTICAL_CENTER);
        
        $sheet->getStyle('K1:K4')->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_LEFT)
            ->setVertical(Alignment::VERTICAL_CENTER);

        $sheet->getStyle('A7:M' . $sheet->getHighestRow())->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);

        // Borders
        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
        
        $sheet->getStyle('A1:M4')->applyFromArray($borderStyle);
        $sheet->getStyle('A7:M7')->applyFromArray($borderStyle); // Header table
        
        // Apply borders to data rows
        $lastRow = $sheet->getHighestRow();
        if ($lastRow > 7) {
            $sheet->getStyle('A8:M' . $lastRow)->applyFromArray($borderStyle);
        }

        // Header styles
        $headerStyle = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => 'FFD9D9D9'],
            ],
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FF000000']
            ]
        ];
        
        $sheet->getStyle('A1:M6')->applyFromArray($headerStyle);
        $sheet->getStyle('A7:M7')->applyFromArray($headerStyle);

        // Title style
        $sheet->getStyle('C1')->getFont()->setSize(16)->setBold(true);

        // Column widths
        $sheet->getColumnDimension('A')->setWidth(5);   // No
        $sheet->getColumnDimension('B')->setWidth(25);  // Temuan Lapangan (gambar)
        $sheet->getColumnDimension('C')->setWidth(10);
        $sheet->getColumnDimension('D')->setWidth(20);  // Lokasi
        $sheet->getStyle('D8:D' . $sheet->getHighestRow())->getAlignment()->setWrapText(true);
        $sheet->getColumnDimension('E')->setWidth(30);  // Temuan
        $sheet->getStyle('E8:E' . $sheet->getHighestRow())->getAlignment()->setWrapText(true);
        $sheet->getColumnDimension('F')->setWidth(15);  // Kategori
        $sheet->getColumnDimension('G')->setWidth(25);  // Improvment
        $sheet->getStyle('G8:G' . $sheet->getHighestRow())->getAlignment()->setWrapText(true);
        $sheet->getColumnDimension('H')->setWidth(18);
        $sheet->getColumnDimension('I')->setWidth(18);  // PIC
        $sheet->getColumnDimension('J')->setWidth(18);  // DD
        $sheet->getColumnDimension('K')->setWidth(25);  // Perbaikan
        $sheet->getColumnDimension('L')->setWidth(20);
        $sheet->getColumnDimension('M')->setWidth(15);  // Status

        // Row heights
        $sheet->getRowDimension(1)->setRowHeight(30);
        $sheet->getRowDimension(2)->setRowHeight(20);
        $sheet->getRowDimension(3)->setRowHeight(20);
        $sheet->getRowDimension(4)->setRowHeight(20);
        $sheet->getRowDimension(7)->setRowHeight(25); // Table header
    }
}