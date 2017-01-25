<?php
/**
 * Front End: Companies
 *
 * To display a list of all the enlisted companies.
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

class CompaniesController extends Controller
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
     * @return the View of companies.
     */
    public function index()
    {
        $name     = 'manufacturer.name AS name';
        $division = 'divisions.name AS division';
        $district = 'districts.name AS district';
        if( 'bn' === $this->lang ) {
            $name     = "manufacturer.name_{$this->lang} AS name";
            $division = "divisions.name_{$this->lang} AS division";
            $district = "districts.name_{$this->lang} AS district";
        }

       $data = DB::table('manufacturer')
                ->leftJoin('divisions', 'divisions.id', '=', 'manufacturer.division_id')
                ->leftJoin('districts', 'districts.id', '=', 'manufacturer.district_id')
                ->select('manufacturer.id AS id',
                    $name,
                    'manufacturer.code AS code',
                    'manufacturer.code_non_bio AS code_non_bio',
                    $division,
                    $district,
                    'manufacturer.address AS address',
                    'manufacturer.registration_dt AS registration',
                    'manufacturer.status')
                ->paginate(12);
                //->get();

        return view('web.companies', compact('data'));
    }


    /**
     * Search companies
     *
     * @return the View of companies.
     */
    public function search(Request $request)
    {
        $search   = $request->input('search');

        $name     = 'manufacturer.name AS name';
        $division = 'divisions.name AS division';
        $district = 'districts.name AS district';
        if( 'bn' === $this->lang ) {
            $name     = "manufacturer.name_{$this->lang} AS name";
            $division = "divisions.name_{$this->lang} AS division";
            $district = "districts.name_{$this->lang} AS district";
        }

       $data = DB::table('manufacturer')
                ->leftJoin('divisions', 'divisions.id', '=', 'manufacturer.division_id')
                ->leftJoin('districts', 'districts.id', '=', 'manufacturer.district_id')
                ->select('manufacturer.id AS id',
                    $name,
                    'manufacturer.code AS code',
                    'manufacturer.code_non_bio AS code_non_bio',
                    $division,
                    $district,
                    'manufacturer.address AS address',
                    'manufacturer.registration_dt AS registration',
                    'manufacturer.status')
                ->where('manufacturer.name', 'like', "%$search%")
                ->paginate(12);
                //->get();

        return view('web.companies_search', compact('data'));
    }
}
