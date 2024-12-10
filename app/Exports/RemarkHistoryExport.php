<?php

namespace App\Exports;

use App\Models\CaseCallLog;

use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;


class RemarkHistoryExport implements FromQuery, WithHeadings, WithMapping, WithColumnFormatting, WithStyles, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    use Exportable;

    public function __construct($request)
    {
        $this->search_input = $request->search_input;
    }

    public function query()
    {
        $query = CaseCallLog::with(['user','case']);
        if (isset($this->search_input)) {
            $search_input = $this->search_input;
            $query->whereHas('user', function ($query_batch) use ($search_input) {
                $query_batch->where('name', 'LIKE', '%' . $search_input . '%');
            });
            $query->orWhereHas('case', function ($query_batch) use ($search_input) {
                $query_batch->where('case_code', 'LIKE', '%' . $search_input . '%');
            });
            $query->orWhere('datetime', 'LIKE', '%' . $search_input . '%');
            $query->orWhere('details', 'LIKE', '%' . $search_input . '%');
            $query->orWhere('phone', 'LIKE', '%' . $search_input . '%');
        }
        return $query;
    }

    public function headings(): array
    {
        return [
            [
                'Datetime',
                'Remarks',
                'Phone',
                'Action By',
                'Under Case',
            ]
        ];
    }

    public function map($CaseCallLog): array
    {
        $excel_array = [
            Date::dateTimeToExcel($CaseCallLog->created_at),
            $CaseCallLog->details,
            $CaseCallLog->phone,
            $CaseCallLog?->user?->name,
            $CaseCallLog?->case?->case_code,
        ];
        return [$excel_array];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first & second row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }

    public function registerEvents(): array
    {
//        return [
//            AfterSheet::class    => function(AfterSheet $event) {
//                $event->sheet->getDelegate()->getStyle('A1:Q1')
//                    ->getFill()
//                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
//                    ->getStartColor()
//                    ->setARGB('ebedef');
//                $event->sheet->getDelegate()->getStyle('A2:Q2')
//                    ->getFill()
//                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
//                    ->getStartColor()
//                    ->setARGB('ebedef');
//            },
//        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_DATE_DDMMYYYY,
//            'D' => NumberFormat::FORMAT_NUMBER_00,
//            'I' => NumberFormat::FORMAT_NUMBER,
//            'J' => NumberFormat::FORMAT_NUMBER_00,
        ];
    }
}
