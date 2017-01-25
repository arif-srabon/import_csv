<?php

namespace App\Http\Controllers\Manufacturer;

use App\Http\Requests\MedicinecodeRequest;
use App\Model\Setup\MedicineModel;
use App\Model\Trans\MedicinecodeModel;
use Response;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use narutimateum\Toastr\Facades\Toastr;
use Riesenia\Kendo\Kendo;
use App\KendoModel as kds;
use mjanssen\BreadcrumbsBundle\Breadcrumbs;

use App\Http\Libraries\SentinelAuthCheck as SentinelAuth;

class UniqueNumberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        \Assets::add(['kendoui/kendo.common.min.css',
            'kendoui/kendo.default.min.css',
            'kendoui/kendo.all.min.js'
        ]);

        Breadcrumbs::addBreadcrumb(trans('trans/medicinecode.breadcrumb1'), '#');

        $transport_read_data = Kendo::createRead()
            ->setUrl('/medicinecode/read')
            ->setContentType('application/json')
            ->setType('POST');

        $transport_data = Kendo::createTransport()
            ->setRead($transport_read_data)
            ->setParameterMap(Kendo::js('function(data) { return kendo.stringify(data); }'));

        $model_data = Kendo::createModel()
            ->setId('id');

        $schema_data = Kendo::createSchema()
            ->setData('data')
            ->setModel($model_data)
            ->setTotal('total');

        $dataSource_data = Kendo::createDataSource()
            ->setTransport($transport_data)
            ->setSchema($schema_data)
            ->setPageSize(config('app_config.num_paging_row'))
            ->setServerSorting(true)
            ->setServerPaging(true)
            ->setServerFiltering(true);

        $pageable = Kendo::createPageable();
        $pageable->setRefresh(true)
            ->setPageSizes(config('app_config.grid_page_sizes'))
            ->setButtonCount(config('app_config.grid_button_count'));


        $grid_allowance_program = Kendo::createGrid('#grid_allowance_program')
            ->setDataSource($dataSource_data)
            ->setHeight(config('app_config.grid_height'))
            ->setSortable(true)
            ->setFilterable(true)
            ->setPageable($pageable)
            ->setColumns([
                ['field' => 'medicine', 'title' => trans('trans/medicinecode.col_medicine')],
                ['field' => 'medicine_code', 'title' => trans('trans/medicinecode.col_medicine_code')],
                ['field' => 'batch_no', 'title' => trans('trans/medicinecode.col_lot_no')],
                ['field' => 'generate_dt', 'title' => trans('trans/medicinecode.col_generate_dt')],
                ['field' => 'total_codes', 'title' => trans('trans/medicinecode.col_total_count')],
            ]);

        $command = [];

        if (SentinelAuth::check('manufacturer.uniquenumber.edit')) {
            $btn_edit = " <div class='k-button k-grid-edit' style='min-width: 16px;' title='" . trans('office.btn_edit') . "' ><span class='k-icon k-edit'></span></div>";
            $command [] = ["template" => $btn_edit];
        }
        if (SentinelAuth::check('manufacturer.uniquenumber.del')) {
            $btn_del = "<div class='k-button k-grid-delete' style='min-width: 16px;' title='" . trans('office.btn_delete') . "' ><span class='k-icon k-delete'></span></div>";
            $command [] = ["template" => $btn_del];
        }
        if (SentinelAuth::check(['manufacturer.uniquenumber.edit', 'manufacturer.uniquenumber.del'])) {
            $grid_allowance_program->addColumns(null, ['command' => $command, 'title' => "&nbsp;", 'width' => "100px"]);
        }

        $data = ['js_grid_allowance_program' => $grid_allowance_program];
        return view('medicinecode.list', $data);
    }

    public function read()
    {
        $request = json_decode(file_get_contents('php://input'));
        $table = 'medicine
            INNER JOIN medicine_code_info ON medicine.id = medicine_code_info.medicine_id';
        $properties = array('medicine_code_info.id AS id',
            'medicine.`name` AS medicine',
            'medicine.`code` AS medicine_code',
            'medicine_code_info.batch_lot_no AS batch_no',
            "DATE_FORMAT(medicine_code_info.generate_date,'%e %M %Y') AS generate_dt",
            'medicine_code_info.total_codes AS total_codes',
        );

        $this->kds = new kds;
        $data = $this->kds->read($table, $properties, $request);
        return response(json_encode($data))
            ->header('Content-Type', 'application/json');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        \Assets::add(['plugins/forms/validation/validate.min.js',
            'plugins/ui/moment/moment.min.js',
            'plugins/pickers/daterangepicker.js',
            'plugins/forms/selects/select2.min.js',
            'core/libraries/jquery.form.js',
            'app/medicinecode_form_validation.js'
        ]);

        // breadcrumbs
        Breadcrumbs::addBreadcrumb(trans('trans/medicinecode.breadcrumb1'), '/medicinecode');
        Breadcrumbs::addBreadcrumb(trans('trans/medicinecode.breadcrumb2'), '#');

        $data['medicines'] = MedicineModel::lists("name", 'id');

        return view('medicinecode.add')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(MedicinecodeRequest $request)
    {
        try {
            $inputs = $request->all();
            $inputs['created_by'] = Session::get('sess_user_id');
            $codeInfo = MedicinecodeModel::create($inputs);
            $this->_saveUniqueMedicalCode($codeInfo, $request);
            $response = $this->_printGeneratedcode($codeInfo);
            return $response;
        } catch (\Exception $e) {
            Toastr::error(config('app_config.msg_failed_save'), "Save Failed", $options = []);
        }
    }

    private function _generateCode($medicine)
    {
        // Unique number Generation parameters:
        // 1. During Unique number generation try to avoid the following confusion characters: 1, I, L, O, 0, X
        // 2. Medicine Code (Max 3 digit) +
        // random number (current year last 2 digit + current month 2 digit + combination of 8 Alphanumeric number)

        $medicineCode = $medicine->code;
        $yymm = date('ym');

        // custom quick random number generation
        // $pool = '23456789abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ';
        // $randomNumber = mb_substr(str_shuffle(str_repeat($pool, 32)), 0, 8, 'UTF-8');
        $randomNumber = str_random(8); // helper function -> random_bytes()

        $uniqueCode = $medicineCode . $yymm . $randomNumber;
        return $uniqueCode;
    }

    private function _saveUniqueMedicalCode($codeInfo, $request)
    {
        $medicine = MedicineModel::where('id', $request->medicine_id)->select('code')->first();
        //dump($medicineCode->code);
        try {
            // generate data
            set_time_limit(0);
            $totalCodes = $codeInfo->total_codes;
            for ($i = 1; $i <= $totalCodes; $i++) {

                $data[] = ['unique_code' => $this->_generateCode($medicine), 'medicine_info_id' => $codeInfo->id];
                //echo "<br>".$i . " = ". ($i / 500);
                if (is_int($i / 500)) {
                    // dump($data);
                    DB::table('medicine_code_details')->insert($data);
                    unset($data);
                }
            }
            // save unique number
            //dump($data);
            DB::table('medicine_code_details')->insert($data);
        } catch (\Exception $e) {
            Toastr::error($e->getMessage(), "Save Failed", $options = []);
        }
    }

    private function _printGeneratedcode($codeInfo)
    {
        $data['codes'] = $codes = DB::table('medicine_code_details')->where('medicine_info_id', $codeInfo->id)->select('unique_code')->get();
        $contents = \View::make('medicinecode.generatedcode')->with($data);
        $response = Response::make($contents, 200); // 200 = status code
        $response
            ->header('Cache-Control', "no-store, no-cache, must-revalidate")
            ->header('Cache-Control: post-check=0, pre-check=0', false)
            ->header('Pragma', "no-cache")
            ->header('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT')
            ->header('Content-Type', 'text/html');

        return $response;
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        \Assets::add(['plugins/forms/validation/validate.min.js',
            'plugins/ui/moment/moment.min.js',
            'plugins/pickers/daterangepicker.js',
            'plugins/forms/selects/select2.min.js',
            'core/libraries/jquery.form.js',
            'app/medicinecode_form_validation.js'
        ]);

        // breadcrumbs
        Breadcrumbs::addBreadcrumb(trans('trans/medicinecode.breadcrumb1'), '/medicinecode');
        Breadcrumbs::addBreadcrumb(trans('trans/medicinecode.breadcrumb2'), '#');

        $medicinecodeInfo = MedicinecodeModel::findOrFail($id);
        $data['medicines'] = MedicineModel::lists("name", 'id');
        $data['codes'] = $codes = DB::table('medicine_code_details')->where('medicine_info_id', $id)->select('unique_code')->get();

        return view('medicinecode.edit', compact('medicinecodeInfo'))->with($data);
    }

    public function destroy()
    {
        $request = json_decode(file_get_contents('php://input'));

        $stat = DB::transaction(function () use ($request) {
            DB::table('medicine_code_details')->where('medicine_info_id', $request->id)->delete();
            return MedicinecodeModel::destroy($request->id);
        });

        return response(json_encode($stat))
            ->header('Content-Type', 'application/json');
    }
}
