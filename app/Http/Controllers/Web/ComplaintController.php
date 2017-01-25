<?php
/**
 * Front End: Complaint
 *
 * @package  adr_dgda
 * @author   Mayeenul Islam
 */


namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

use App\Model\Setup\CommonConfigModel;
use App\Model\Setup\DistrictModel;
use App\Model\Setup\ThanaUpazillaModel;
use App\Model\Setup\UnionWardModel;
use App\Model\Web\ComplaintModel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Validator;
use Response;
use narutimateum\Toastr\Facades\Toastr;

use App\Http\Requests\Web\ComplaintRequest;

class ComplaintController extends Controller
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
     * ---------------------------------------------------------------------
     */
    public function index()
    {
        /**
         * Load necessary assets specific to this UI
         */
        \Assets::add([
                'plugins/bootstrap3-typeahead.min.js'
            ]);

        $district = DistrictModel::lists('name', 'id');
        $upazilla = ThanaUpazillaModel::lists('name', 'id');
        $union    = UnionWardModel::lists('name', 'id');

        $commonConfig          = new CommonConfigModel;
        $data['complaintType'] = $commonConfig->getAllCommonConfigList( 'cc_complaint_types', $this->lang );

        return view('web.complaint', compact('district', 'upazilla', 'union'))->with($data);
    }


    /**
     * Handle the form submission.
     * 
     * @return object Page view.
     * ---------------------------------------------------------------------
     */
    public function create()
    {
        /**
         * Load necessary assets specific to this UI
         */
        \Assets::add([
                'plugins/bootstrap3-typeahead.min.js'
            ]);
        
        $district = DistrictModel::lists('name', 'id');
        $upazilla = ThanaUpazillaModel::lists('name', 'id');
        $union    = UnionWardModel::lists('name', 'id');

        $commonConfig          = new CommonConfigModel;
        $data['complaintType'] = $commonConfig->getAllCommonConfigList( 'cc_complaint_types', $this->lang );

        return view('web.complaint', compact('district', 'upazilla', 'union'))->with($data);
    }

    /**
     * Store/Add Complaint Data
     * @param  ComplaintRequest $request    Type of request.
     * @return array                        JSON array.
     * ---------------------------------------------------------------------
     */
    public function store(ComplaintRequest $request)
    {

        try
        {

            $inputs = $request->all();
            $inputs['submit_date'] = date('Y-m-d');
            /**
             * Taking the value of `id` column from the app_config file
             * that denotes the ID of the `cc_complaint_status` table
             * for status 'open'
             */
            $inputs['status_id']   = config('app_config.complaint_default_status_id'); //default `1`

            ComplaintModel::create($inputs);

            return redirect('complaints/complain/create')->with('successMsg', config('app_config.msg_save'));;

        } catch (\Exception $e) {

            return redirect('complaints/complain/create')
                ->with('dangerMsg', $e->getMessage());

        }

    }


    /**
     * AutoComplete
     * @param  string $table  Table name.
     * @param  string $select Field name to select.
     * @param  string $string String to search.
     * @return array          One dimensional array.
     * ---------------------------------------------------------------------
     */
    private function autocomplete($table, $select, $string) {
        // get original model
        $fetchMode = DB::getFetchMode();

        // set mode to fetch associative arrays instead of objects
        DB::setFetchMode(\PDO::FETCH_ASSOC);

        $fetched_data = DB::table($table)
                            ->select($select)
                            ->where($select, 'like', "%$string%")
                            ->limit(10)
                            ->get();

        // restore mode the original
        DB::setFetchMode($fetchMode);        

        $collection = collect($fetched_data);
        $collapsed  = $collection->flatten(); //flatten them to one dimensional array
        $values     = $collapsed->all();

        return $values;
    }


    /**
     * AutoComplete : Profession
     * ---------------------------------------------------------------------
     */
    public function autoProfession(Request $request) {
        $search = $request->input('search');

        return $this->autocomplete( 'cc_profession', 'name', $search );
    }
}
