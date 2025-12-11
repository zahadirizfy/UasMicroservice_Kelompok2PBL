<?php

namespace App\Exports;

use App\Models\PenyelenggaraEvent;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;

class PenyelenggaraExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithCustomStartCell
{
    public function collection()
    {
        $data = PenyelenggaraEvent::select('nama_penyelenggara_event', 'kontak')->get();

        return $data->map(function ($item, $key) {
            return [
                'No' => $key + 1,
                'Nama Penyelenggara' => $item->nama_penyelenggara_event,
                'Kontak' => $item->kontak,
            ];
        });
    }

    public function headings(): array
    {
        return ['No', 'Nama Penyelenggara', 'Kontak'];
    }

    public function startCell(): string
    {
        return 'A3'; // mulai heading dari baris 3
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();

                // Merge A1:C1 untuk judul
                $sheet->mergeCells("A1:C1");
                $sheet->setCellValue("A1", "Data Penyelenggara Event");

                // Style judul
                $sheet->getStyle("A1")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 14,
                        'name' => 'Arial',
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Border seluruh tabel
                $sheet->getStyle("A3:{$highestColumn}{$highestRow}")
                    ->getBorders()->getAllBorders()
                    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                // Center semua data
                $sheet->getStyle("A3:{$highestColumn}{$highestRow}")
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                // Header background color
                $sheet->getStyle("A3:{$highestColumn}3")
                    ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2');

                // Font semua data
                $sheet->getStyle("A1:{$highestColumn}{$highestRow}")
                    ->getFont()->setName('Arial')->setSize(12);
            },
        ];
    }
}
