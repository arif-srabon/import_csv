<?php

namespace App\Model\Import;

use Illuminate\Database\Eloquent\Model;
use DB;

class ImportFileModel extends Model
{
    public function CheckDuplicateValueForGeneric($code,$name){

       $sql = "SELECT id
                FROM cc_generic
                WHERE CODE = '$code' LIMIT 1";
        $info = DB::select(DB::raw($sql));
        return $info;

    }
    public function CheckDuplicateValueForDosage($code,$name){
        $sql = "SELECT id
                FROM cc_medicine_type
                WHERE CODE = '$code' LIMIT 1";
        $info = DB::select(DB::raw($sql));
        return $info;
    }

    public function CheckCompany($Ccode,$Cname){
        $info = DB::table('manufacturer')
                    ->select('id')
                    ->where('company_code',$Ccode)
                    ->where('name',$Cname)
                    ->limit(1)
                    ->get();
        return $info;
    }

    public function CheckDuplicateValueForMedicineData($name,$code){
        $info = DB::table('medicine')
            ->select('id')
            ->where('name',$name)
//            ->where('code',$code)
            ->limit(1)
            ->get();
        return $info;
    }
}
