<?php

namespace App\Utils;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportExcel implements FromArray, WithHeadings
{
    use Exportable;

    //导出的数据
    private $data;
    private $headings;

    public function __construct(array $data, array $headings)
    {
        $this->data = $data;
        $this->headings = $headings;
    }

    public function array(): array
    {
        return [$this->data];
    }

    public function headings(): array
    {
        return $this->headings;
    }
}
