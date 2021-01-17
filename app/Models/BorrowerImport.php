<?php

namespace App\Models;

use App\Models\Borrower;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class BorrowerImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        dd($rows);
        foreach($rows as $row) {
            $import = new Borrower();
            $import->first_name = $row[1];
            $import->user_id = $row[0];
            // $import->save();
        }
        // return new Borrower([
        //    'user_id'     => $row[0],
        //    'first_name'    => $row[1], 
        //    'password' => Hash::make($row[2]),
        // ]);
    }
}
