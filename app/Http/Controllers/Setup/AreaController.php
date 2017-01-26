<?php

namespace App\Http\Controllers\Setup;

use App\Model\Setup\DistrictModel;
use App\Model\Setup\ThanaUpazillaModel;
use App\Model\Setup\UnionWardModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AreaController extends Controller
{

    /**
     * @param $division_id
     */
    public function getDistrict($division_id)
    {
        $district = new DistrictModel;
        $districtList = $district->getAllDistrictByDivisionList($division_id);
        //print_r($districtList);
        $districtData = array();
        foreach ($districtList as $district_id => $district_name) {
            $districtData[$division_id][$district_id] = $district_name;
        }
        // build json data
        if ($districtData) {
            echo json_encode($districtData[$division_id]);
        } else {
            echo '{}';
        }
    }

    /**
     * @param $district_id
     */
    public function getUpazilla($district_id)
    {
        $upazilla = new ThanaUpazillaModel;
        $upazillaList = $upazilla->getAllUpazillaByDistrictList($district_id);
        //print_r($upazillaList);
        $upzillaData = array();
        foreach ($upazillaList as $upazilla_id => $upazilla_name) {
            $upzillaData[$district_id][$upazilla_id] = $upazilla_name;
        }

        // build json data
        if ($upzillaData) {
            echo json_encode($upzillaData[$district_id]);
        } else {
            echo '{}';
        }
    }

    /**
     * @param $upzilla_id
     */
    public function getWard($upzilla_id)
    {
        $ward = new UnionWardModel;
        $wardList = $ward->getAllWardByUpazillaList($upzilla_id);
        $wardData = array();
        foreach ($wardList as $ward_id => $ward_name) {
            $wardData[$upzilla_id][$ward_id] = $ward_name;
        }
        // build json data
        if ($wardData) {
            echo json_encode($wardData[$upzilla_id]);
        } else {
            echo '{}';
        }
    }


    public function permanentareaList(Request $request)
    {
        $division_id = $request->input('permanent_division');
        $district_id = $request->input('permanent_district');
        $upzilla_id = $request->input('permanent_upzilla');

        if ($division_id && !$district_id && !$upzilla_id) {
            $this->getDistrict($division_id);
        } elseif ($division_id && $district_id && !$upzilla_id) {
            $this->getUpazilla($district_id);
        } elseif ($division_id && $district_id && $upzilla_id) {
            $this->getWard($upzilla_id);
        } else {
            echo '{}';
        }
    }

    public function areaList(Request $request)
    {
        $division_id = $request->input('division_id');
        $district_id = $request->input('district_id');
        $upzilla_id = $request->input('upazilla_id');

        if ($division_id && !$district_id && !$upzilla_id) {
            $this->getDistrict($division_id);
        } elseif ($division_id && $district_id && !$upzilla_id) {
            $this->getUpazilla($district_id);
        } elseif ($division_id && $district_id && $upzilla_id) {
            $this->getWard($upzilla_id);
        } else {
            echo '{}';
        }
    }


    public function presentareaList(Request $request)
    {
        $division_id = $request->input('present_division');
        $district_id = $request->input('present_district');
        $upzilla_id = $request->input('present_upzilla');

        if ($division_id && !$district_id && !$upzilla_id) {
            $this->getDistrict($division_id);
        } elseif ($division_id && $district_id && !$upzilla_id) {
            $this->getUpazilla($district_id);
        } elseif ($division_id && $district_id && $upzilla_id) {
            $this->getWard($upzilla_id);
        } else {
            echo '{}';
        }
    }


}
