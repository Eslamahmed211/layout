<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class contactExport implements FromCollection, WithMapping, WithHeadings
{
    protected $contacts;

    public function __construct($contacts)
    {
        $this->contacts = $contacts;
    }



    public function headings(): array
    {
        return [
            "الاسم",
            "الرقم"
        ];
    }

    public function collection()
    {
        return collect($this->contacts);
    }

    public function map($contacts): array
    {
        return [
            $contacts->name,
            $contacts->phone,
        ];
    }
}
