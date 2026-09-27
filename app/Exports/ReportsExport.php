<?php

namespace App\Exports;

use App\Models\Report;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReportsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return Report::select(
    //         'created_at',
    //         'username',
    //         'report',
    //         'status_id'
    //     )->get();
    // }
    protected Collection $reports;

    public function __construct(Collection $reports)
    {
        $this->reports = $reports;
    }

    public function collection()
    {
        return $this->reports;
    }

    public function headings(): array{
        return[
            'Date',
            'Username',
            'Report',
            'Status'
        ];
    }

    public function map($report): array
    {
        return [
            $report->created_at->format('Y-m-d'),
            $report->username,
            $report->report,
            $report->status->Status       
        ];
    }
}
