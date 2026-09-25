<?php

namespace App\Exports;

use App\Http\Controllers\LaporanController;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanExport implements FromCollection, WithHeadings
{
    public function __construct(public string $jenis, public array $filter) {}

    public function collection(): Collection
    {
        [, $rows] = LaporanController::data($this->jenis, $this->filter);

        return collect($rows);
    }

    public function headings(): array
    {
        [$headers] = LaporanController::data($this->jenis, $this->filter);

        return $headers;
    }
}
