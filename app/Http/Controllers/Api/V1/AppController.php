<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
//use Dingo\Api\Routing\Helpers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AppController extends Controller
{
    //use Helpers;

    public function manufacturer()
    {
        $manufacturer = DB::table('manufacturer')->select('id', 'name')
            ->where('status', 1)
            ->orderBy('name', 'asc')
            ->get();
			
        return $manufacturer;
    }
	
	public function manufacturerList()
    {
        $perfix = [
            'id' => "",
            'name' => "--Please Select--",
        ];

        $manufacturer = DB::table('manufacturer')->select('id', 'name')
            ->where('status', 1)
            ->orderBy('name', 'asc')
            ->get();
        array_unshift($manufacturer, $perfix);
        return $manufacturer;
    }

    public function divisions()
    {
        $perfix = [
            'id' => "",
            'name' => "--Please Select--",
        ];

        $divisions = DB::table('divisions')->select('id', 'name')->orderBy('name', 'asc')->get();
        array_unshift($divisions, $perfix);
        return ['data' => $divisions];
    }

    public function generics()
    {
        $generics = DB::table('cc_generic')->select('id', 'name')->where('is_active', 1)
            ->orderBy('weight', 'desc')->orderBy('name', 'asc')->get();

        return $generics;
    }

    public function medicinesInfo($id)
    {
        $medicine = DB::table('medicine')->where('id', $id)->get();
        return $medicine;
    }


    public function medicines($type = null, $id = null)
    {
        $medicine = DB::table('medicine')
            ->leftJoin('cc_medicine_type', 'cc_medicine_type.id', '=', 'medicine.medicine_type_id')
            ->leftJoin('cc_generic', 'cc_generic.id', '=', 'medicine.generic_id')
            ->leftJoin('manufacturer', 'manufacturer.id', '=', 'medicine.manufactuer_id')
            ->select('medicine.id AS id', 'medicine.name AS name', 'cc_medicine_type.name AS type',
                'cc_generic.name AS generic_name', 'manufacturer.name AS manufacturer_name', 'medicine.medicine_image_path AS medicine_image_path')
            ->orderBy('name', 'asc');

        if ($type == 'manufacturer' && !empty($id)) {
            $medicine = $medicine->where('manufacturer.id', (int)$id);
        }

        if ($type == 'generic' && !empty($id)) {
            $medicine = $medicine->where('medicine.generic_id', (int)$id);
        }

        $medicine = $medicine->get();
		
        return $medicine;
    }
	
	public function medicinesList($type = null, $id = null)
    {

        $medicine = DB::table('medicine')
            ->leftJoin('cc_medicine_type', 'cc_medicine_type.id', '=', 'medicine.medicine_type_id')
            ->leftJoin('cc_generic', 'cc_generic.id', '=', 'medicine.generic_id')
            ->leftJoin('manufacturer', 'manufacturer.id', '=', 'medicine.manufactuer_id')
            ->select('medicine.id AS id', 'medicine.name AS name', 'cc_medicine_type.name AS type',
                'cc_generic.name AS generic_name', 'manufacturer.name AS manufacturer_name', 'medicine.medicine_image_path AS medicine_image_path')
            ->orderBy('name', 'asc');

        if ($type == 'manufacturer' && !empty($id)) {
            $medicine = $medicine->where('manufacturer.id', (int)$id);
        }

        if ($type == 'generic' && !empty($id)) {
            $medicine = $medicine->where('medicine.generic_id', (int)$id);
        }

        $medicine = $medicine->get();

        return $medicine;
    }


}
