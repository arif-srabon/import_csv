<?php
/**
 * Front End: Medicines
 *
 * To display a list of all the enlisted medicines.
 *
 * @package  adr_dgda
 * @author   Mayeenul Islam
 */


namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class MedicinesController extends Controller
{
    public $lang;

    public function __construct()
    {
        $this->lang = Session::get("locale");
        if (!isset($this->lang)) {
            $this->lang = config('app.locale');
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return the View of medicines.
     */
    public function index()
    {
        $generic      = 'cc_generic.name AS generic';
        $manufacturer = 'manufacturer.name AS manufacturer';
        if( 'bn' === $this->lang ) {
            $generic      = "cc_generic.name_{$this->lang} AS generic";
            $manufacturer = "manufacturer.name_{$this->lang} AS manufacturer";
        }

       $data = DB::table('medicine')
                ->leftJoin('manufacturer', 'manufacturer.id', '=', 'medicine.manufactuer_id') //spelling mistake! :o
                ->leftJoin('cc_generic', 'cc_generic.id', '=', 'medicine.generic_id')
                ->select('medicine.id AS id',
                    'medicine.medicine_image_path AS image',
                    'medicine.code AS code',
                    'medicine.name AS name',
                    $generic,
                    $manufacturer,
                    'medicine.price AS price')
                ->where('medicine.status', '=', 1)
                ->paginate(12);
                //->get();

        return view('web.medicines', compact('data'));
    }

    /**
     * Search medicines
     *
     * @return the View of medicines.
     */
    public function search(Request $request)
    {
        $search   = $request->input('search');

        $generic      = 'cc_generic.name AS generic';
        $manufacturer = 'manufacturer.name AS manufacturer';
        if( 'bn' === $this->lang ) {
            $generic      = "cc_generic.name_{$this->lang} AS generic";
            $manufacturer = "manufacturer.name_{$this->lang} AS manufacturer";
        }

       $data = DB::table('medicine')
                ->leftJoin('manufacturer', 'manufacturer.id', '=', 'medicine.manufactuer_id') //spelling mistake! :o
                ->leftJoin('cc_generic', 'cc_generic.id', '=', 'medicine.generic_id')
                ->select('medicine.id AS id',
                    'medicine.medicine_image_path AS image',
                    'medicine.code AS code',
                    'medicine.name AS name',
                    $generic,
                    $manufacturer,
                    'medicine.price AS price')
                ->where('medicine.status', '=', 1)
                ->where('medicine.name', 'like', "%$search%")
                ->paginate(12);
                //->get();

        return view('web.medicines_search', compact('data'));
    }
}
