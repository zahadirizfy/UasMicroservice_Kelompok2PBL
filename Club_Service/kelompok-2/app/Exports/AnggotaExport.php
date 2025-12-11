<?php

namespace App\Exports;

use App\Models\Anggota;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AnggotaExport implements
    FromCollection,
    WithStyles,
    WithColumnWidths,
    ShouldAutoSize,
    WithEvents
{
    public function collection()
    {
        // Biarkan kosong karena kita akan isi manual di AfterSheet
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
            'B' => 20,
            'C' => 20,
            'D' => 15,
            'E' => 20,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Judul
                $sheet->mergeCells('A3:E3');
                $sheet->setCellValue('A3', 'DATA ANGGOTA');
                $sheet->getStyle('A3')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14],
                    'alignment' => ['horizontal' => 'center'],
                ]);

                // Header kolom di baris 5
                $sheet->fromArray(
                    ['Nama', 'Klub', 'Tanggal Lahir', 'Peran', 'Kontak'],
                    null,
                    'A5',
                    true
                );

                // Ambil data anggota
                $data = \App\Models\Anggota::select('nama', 'klub', 'tgl_lahir', 'peran', 'kontak')->get()->toArray();

                // Isi data dimulai dari baris ke-6
                $sheet->fromArray($data, null, 'A6', true);

                // Border dari header sampai akhir data
                $rowCount = count($data) + 5;
                $sheet->getStyle("A5:E$rowCount")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ]);

                // Bold untuk header
                $sheet->getStyle('A5:E5')->applyFromArray([
                    'font' => ['bold' => true],
                ]);
            },
        ];
    }
}
