<?php

namespace App\Exports;

use App\Models\Pertandingan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class HasilPertandinganExport implements
    FromCollection,
    WithStyles,
    WithColumnWidths,
    ShouldAutoSize,
    WithEvents
{
    protected $pertandingan;

    public function __construct($pertandingan_id)
{
    $this->pertandingan = Pertandingan::findOrFail($pertandingan_id);
}


    public function collection()
    {
        return collect([]); // tetap kosong
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
            'C' => 15,
            'D' => 15,
            'E' => 15,
            'F' => 15,
            'G' => 15,
            'H' => 15,
            'I' => 15,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // ============================
                // Judul Utama
                // ============================
                $sheet->mergeCells('A1:I1');
                $sheet->setCellValue('A1', 'HASIL PERTANDINGAN');
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14],
                    'alignment' => ['horizontal' => 'center'],
                ]);

                $sheet->mergeCells('A2:I2');
                $sheet->setCellValue('A2', strtoupper($this->pertandingan->nama_pertandingan));
                $sheet->getStyle('A2')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => ['horizontal' => 'center'],
                ]);

                // ============================
                // Info Pertandingan
                // ============================
                $sheet->fromArray([
                    ['Nama Pertandingan', $this->pertandingan->nama_pertandingan],
                    ['Tanggal', optional($this->pertandingan->jadwalPertandingan)?->tanggal
                        ? Carbon::parse($this->pertandingan->jadwalPertandingan->tanggal)->format('d-m-Y') : '-'],
                    ['Waktu', optional($this->pertandingan->jadwalPertandingan)?->waktu
                        ? Carbon::parse($this->pertandingan->jadwalPertandingan->waktu)->format('H:i') : '-'],
                    ['Lokasi', optional($this->pertandingan->jadwalPertandingan)?->lokasi ?? '-'],
                    ['Penyelenggara', optional($this->pertandingan->penyelenggaraEvent)?->nama_penyelenggara_event ?? '-'],
                    ['Juri', optional($this->pertandingan->juri)?->nama_juri ?? '-'],
                ], null, 'A4', false);

                // ============================
                // Header Data Peserta
                // ============================
                $startRow = 11;
                $sheet->fromArray([
                    ['No', 'Nama Peserta', 'Lemparan 1', 'Lemparan 2', 'Lemparan 3', 'Lemparan 4', 'Lemparan 5', 'Skor', 'Rangking']
                ], null, "A{$startRow}");

                // ============================
                // Data Peserta
                // ============================
                $row = $startRow + 1;
                $no = 1;

                foreach ($this->pertandingan->hasilPertandingan as $hasil) {
                    foreach ($hasil->detailHasil as $detail) {
                        $sheet->fromArray([
                            [
                                $no++,
                                $detail->nama,
                                $detail->lemparan1,
                                $detail->lemparan2,
                                $detail->lemparan3,
                                $detail->lemparan4,
                                $detail->lemparan5,
                                $detail->skor,
                                $detail->rangking
                            ]
                        ], null, "A{$row}");
                        $row++;
                    }
                }

                // ============================
                // Styling
                // ============================
                $lastRow = $row - 1;

                $sheet->getStyle("A{$startRow}:I{$startRow}")->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => ['horizontal' => 'center'],
                ]);

                $sheet->getStyle("A{$startRow}:I{$lastRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    ],
                ]);
            },
        ];
    }
}
