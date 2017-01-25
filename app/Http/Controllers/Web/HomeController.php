<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        \Assets::add([
            'plugins/jquery.form.js'
        ]);

        return view('web.home');
    }


    /**
     * Check Fake medicine
     * @param  Request $request Global request.
     * @return string           Formatted string whether fake or real.
     */
    public function fakeMedicineChecker(Request $request) {
        $unique_id = $request->input('medicine_unique_id');

        $data = DB::table('medicine_code_details')
                    ->select('medicine.id')
                    ->join('medicine_code_info', 'medicine_code_details.medicine_info_id', '=', 'medicine_code_info.id')
                    ->join('medicine', 'medicine_code_info.medicine_id', '=', 'medicine.id')
                    ->where('medicine_code_details.unique_code', '=', "$unique_id")
                    ->get();

        if( empty($data) ) {
            return '<div class="fake-result result-medicine-fake"><i class="fa fa-times-circle"></i> Fake. <small>Please contact DGDA</small></div>';
        } else {
            return '<div class="fake-result result-medicine-real"><i class="fa fa-check-circle"></i> Authentic. <small>Feel free to use this</small></div>';
        }
    }
}
