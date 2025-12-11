<?php

namespace App\Exports;

use App\Models\Atlet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AtletExport implements
    FromCollection,
    WithStyles,
    WithColumnWidths,
    ShouldAutoSize,
    WithEvents
{
    public function collection()
    {
        // Dikosongkan karena data ditambahkan di AfterSheet
        return collect([]);
    }

    public function styles(Worksheet $sheet)
    {
        return [];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 25,
            'C' => 30,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Judul di baris 3
                $sheet->mergeCells('A3:C3');
                $sheet->setCellValue('A3', 'DATA ATLET');
                $sheet->getStyle('A3')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14],
                    'alignment' => ['horizontal' => 'center'],
                ]);

                // Header di baris 5
                $sheet->fromArray(
                    ['Nama', 'Klub', 'Prestasi'],
                    null,
                    'A5',
                    true
                );

                // Ambil data atlet
                $data = Atlet::with('club')->get()->map(function ($atlet) {
                    return [
                        $atlet->nama,
                        $atlet->club->nama ?? '-',
                        $atlet->prestasi ?? '-',
                    ];
                })->toArray();

                // Isi data mulai baris ke-6
                $sheet->fromArray($data, null, 'A6', true);

                // Hitung jumlah baris
                $rowCount = count($data) + 5;

                // Border untuk semua data
                $sheet->getStyle("A5:C{$rowCount}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ]);

                // Bold header
                $sheet->getStyle('A5:C5')->applyFromArray([
                    'font' => ['bold' => true],
                ]);
            },
        ];
    }
}
