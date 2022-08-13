<?php
  
namespace App\Imports;
  
use App\Models\PbTemp;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
  
class PbImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new PbTemp([
            'name'     => $row['name'],
            'phone'    => $row['phone'], 
        ]);
    }
}