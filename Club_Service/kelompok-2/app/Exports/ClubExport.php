<?php

namespace App\Exports;

use App\Models\Club;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ClubExport implements
    FromCollection,
    WithStyles,
    WithColumnWidths,
    ShouldAutoSize,
    WithEvents
{
    public function collection()
    {
        return collect([]);
    }

    public function styles(Worksheet $sheet)
    {
        return [];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 25,
            'C' => 20,
            'D' => 40,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Judul
                $sheet->mergeCells('A3:D3');
                $sheet->setCellValue('A3', 'DATA KLUB');
                $sheet->getStyle('A3')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14],
                    'alignment' => ['horizontal' => 'center'],
                ]);

                // Header
                $sheet->fromArray(
                    ['No', 'Nama Klub', 'Lokasi', 'Deskripsi'],
                    null,
                    'A5',
                    true
                );

                // Data
                $clubs = \App\Models\Club::all();
                $data = [];
                foreach ($clubs as $index => $club) {
                    $data[] = [
                        $index + 1,
                        $club->nama,
                        $club->lokasi,
                        $club->deskripsi,
                    ];
                }

                $sheet->fromArray($data, null, 'A6', true);

                // Border
                $rowCount = count($data) + 5;
                $sheet->getStyle("A5:D{$rowCount}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ]);

                // Bold Header
                $sheet->getStyle('A5:D5')->applyFromArray([
                    'font' => ['bold' => true],
                ]);
            },
        ];
    }
}
