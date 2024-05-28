<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\contact;


class contactImport implements ToModel
{

    protected $group_id;

    public function __construct($group_id)
    {
        $this->group_id = $group_id;
    }
    public function model(array $row)
    {
        return new contact([
            'phone'    => $row[0],
            'name'     => $row[1] ?? null,
            "group_id" => $this->group_id
        ]);
    }
}
