<?php

namespace App\Exports;

use App\Models\Juri;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;

class JuriExport implements
    FromCollection,
    WithEvents,
    WithStyles,
    WithColumnWidths,
    ShouldAutoSize
{
    public function collection()
    {
        // Kosongkan isi collection karena kita akan isi secara manual di AfterSheet
        return collect([]);
    }

    public function styles(Worksheet $sheet)
    {
        return [];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 30,
            'C' => 25,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Judul
                $sheet->mergeCells('A3:C3');
                $sheet->setCellValue('A3', 'DATA JURI');
                $sheet->getStyle('A3')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14],
                    'alignment' => ['horizontal' => 'center'],
                ]);

                // Header kolom di baris ke-5
                $sheet->fromArray(['No', 'Nama Juri', 'Tanggal Lahir'], null, 'A5', true);

                // Ambil data juri
                $data = Juri::all()->map(function ($juri, $index) {
                    return [
                        $index + 1,
                        $juri->nama_juri,
                        \Carbon\Carbon::parse($juri->tanggal_lahir)->format('d-m-Y'),
                    ];
                })->toArray();

                // Isi data ke sheet mulai dari baris ke-6
                $sheet->fromArray($data, null, 'A6', true);

                // Tambahkan border
                $rowCount = count($data) + 5;
                $sheet->getStyle("A5:C$rowCount")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ]);

                // Header tebal
                $sheet->getStyle('A5:C5')->applyFromArray([
                    'font' => ['bold' => true],
                ]);
            },
        ];
    }
}
