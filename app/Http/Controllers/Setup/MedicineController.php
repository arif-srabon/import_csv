<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;

use App\Http\Requests\MedicineRequest;
use App\Model\Setup\CommonConfigModel;
use App\Model\Setup\MedicineModel;
//use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use narutimateum\Toastr\Facades\Toastr;
use Response;
//use Illuminate\Support\Facades\App;
use Riesenia\Kendo\Kendo;
use App\KendoModel as kds;
use mjanssen\BreadcrumbsBundle\Breadcrumbs;
use App\Http\Libraries\SentinelAuthCheck as SentinelAuth;

class MedicineController extends Controller
{
    public $kds;
    public $lang;

    public function __CONSTRUCT()
    {
        $this->middleware('auth');
        $this->lang = Session::get("locale");

        if (!isset($this->lang)) {
            $this->lang = config('app.locale');
        }
    }

    public function index()
    {
        \Assets::add(['kendoui/kendo.common.min.css',
            'kendoui/kendo.default.min.css',
            'kendoui/kendo.all.min.js',
            'pages/components_modals.js'
        ]);

        Breadcrumbs::addBreadcrumb(trans('setup/medicine.breadcrumb1'), '#');
        Breadcrumbs::addBreadcrumb(trans('setup/medicine.breadcrumb2'), '/medicine');

        $transport_read_data = Kendo::createRead()
            ->setUrl('/medicine/read')
            ->setContentType('application/json')
            ->setType('POST');
        $transport_destroy_data = Kendo::createDestroy()
            ->setUrl('/district/destroy')
            ->setContentType('application/json')
            ->setType('POST');

        $transport_data = Kendo::createTransport()
            ->setRead($transport_read_data)
            ->setDestroy($transport_destroy_data)
            ->setParameterMap(Kendo::js('function(data) { return kendo.stringify(data); }'));

        $model_data = Kendo::createModel()
            ->addField('id');

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

        if ($this->lang == 'bn') {
            $status = '# if (status == 1) { #সক্রিয়# } else { #নিষ্ক্রিয়# } #';
        } else {
            $status = '# if (status == 1) { #Active# } else { #Inactive# } #';
        }

        $grid_district = Kendo::createGrid('#grid_medicine')
            ->setDataSource($dataSource_data)
            ->setHeight(config('app_config.grid_height'))
            ->setSortable(true)
            ->setFilterable(true)
            ->setPageable($pageable)
            ->setColumns([
                ['field' => 'medicine_name', 'title' => trans('setup/medicine.column_medicine')],
                ['field' => 'generic_name', 'title' => trans('setup/medicine.column_generic')],
                ['field' => 'manufacturer_name', 'title' => trans('setup/medicine.column_manufacture')],
                ['field' => 'status', 'title' => trans('setup/medicine.column_status'), 'width' => "11%", 'template' => $status]
            ]);

        $command = array();
        if (SentinelAuth::check('settings.medicine.edit')) {
            $btn_edit = " <div class='k-button k-grid-edit' style='min-width: 16px;' title='" . trans('setup/medicine.btn_edit') . "' ><span class='k-icon k-edit'></span></div>";
            $command_edit = ["template" => $btn_edit];
            $command [] = $command_edit;
        }

        if (SentinelAuth::check('settings.medicine.del')) {
            $btn_del = "<div class='k-button k-grid-delete' style='min-width: 16px;' title='" . trans('setup/medicine.btn_delete') . "' ><span class='k-icon k-delete'></span></div>";
            $command_del = ["template" => $btn_del];
            $command [] = $command_del;
        }

        if (SentinelAuth::check(['settings.medicine.edit', 'settings.medicine.del'])) {
            $grid_district->addColumns(null, ['command' => $command, 'title' => "&nbsp;", 'width' => "10%"]);
        }

        $data = ['js_grid_medicine' => $grid_district];

        return view('setup.medicine.medicine_list_form', $data);
    }

    public function read()
    {
        $request = json_decode(file_get_contents('php://input'));

        $table = "medicine
                    INNER JOIN cc_generic ON cc_generic.id = medicine.generic_id
                    INNER JOIN manufacturer ON manufacturer.id = medicine.manufactuer_id";

        $generic_name = "cc_generic.`name` AS generic_name";
        $manufacturer_name = "manufacturer.`name` AS manufacturer_name";
        if ($this->lang == 'bn') {
            $generic_name = "cc_generic.name_bn AS generic_name";
            $manufacturer_name = "manufacturer.name_bn AS manufacturer_name";
        }

        $properties = array("medicine.id AS id",
            "medicine.`name` AS medicine_name",
            "medicine.generic_id AS generic_id",
            $generic_name,
            "medicine.manufactuer_id AS manufacturer_id",
            $manufacturer_name,
            "medicine.price AS price",
            "medicine.`status` AS status"
        );

        $this->kds = new kds;
        $data = $this->kds->read($table, $properties, $request);
        return response(json_encode($data))
            ->header('Content-Type', 'application/json');

    }

    public function destroy()
    {
        $request = json_decode(file_get_contents('php://input'));
        $stat = MedicineModel::destroy($request->id);
        return response(json_encode($stat))
            ->header('Content-Type', 'application/json');

    }

    public function create()
    {
        \Assets::add(['plugins/forms/validation/validate.min.js',
            'plugins/forms/styling/uniform.min.js',
            'plugins/forms/selects/select2.min.js',
            'app/medicine_form_validation.js'
        ]);

        // breadcrumbs
        Breadcrumbs::addBreadcrumb(trans('setup/medicine.breadcrumb1'), '#');
        Breadcrumbs::addBreadcrumb(trans('setup/medicine.breadcrumb2'), '/medicine');
        Breadcrumbs::addBreadcrumb(trans('users/user.breadcrumb3'), '#');

        $data = [];
        $data = array_merge($data, $this->_getBasicData());

        return view('setup.medicine.create')->with($data);
    }

    private function _getBasicData()
    {
        $cConfig = new CommonConfigModel;
        $data['generic'] = $cConfig->getAllCommonConfigList('cc_generic', $this->lang);
        $data['medicine_type'] = $cConfig->getAllCommonConfigList('cc_medicine_type', $this->lang);
        $data['manufacturer'] = DB::table('manufacturer')->where('status', '=', 1)->lists('name', 'id');

        return $data;
    }

    public function store(MedicineRequest $request)
    {
        try {
            $inputs = $request->all();
            $inputs['created_by'] = Session::get('sess_user_id');
            $data = MedicineModel::create($inputs);
            $this->uploadLogo($request, $data->id);

            Toastr::success(config('app_config.msg_save'), "Save", $options = []);
            return redirect('medicine/create');

        } catch (\Exception $e) {

            Toastr::error(config('app_config.msg_failed_save'), "Save Failed", $options = []);
            return redirect('$medicine/create')
                ->with('dangerMsg', $e->getMessage());
        }
    }

    public function uploadLogo($request, $id)
    {
        $file = $request->file('user_photo');
        if (!empty($file)) {
            $uploadPath = config('app_config.medicine_upload_photo_path') . "$id/";
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path($uploadPath), $fileName);
            $uploadFile = $uploadPath . $fileName;
            // update center logo url
            $entry = MedicineModel::find($id);
            $entry->medicine_image_path = $uploadFile;
            $entry->save();
        }
    }

    public function edit($id)
    {
        \Assets::add(['plugins/forms/validation/validate.min.js',
            'plugins/forms/styling/uniform.min.js',
            'plugins/forms/selects/select2.min.js',
            'app/medicine_form_validation.js'
        ]);

        // breadcrumbs
        Breadcrumbs::addBreadcrumb(trans('setup/medicine.breadcrumb1'), '#');
        Breadcrumbs::addBreadcrumb(trans('setup/medicine.breadcrumb2'), '/medicine');
        Breadcrumbs::addBreadcrumb(trans('users/user.breadcrumb3'), '#');

        $data = [];
        $data = array_merge($data, $this->_getBasicData());
        $medicine = MedicineModel::findOrFail($id);

        return view('setup.medicine.edit', compact('medicine'))->with($data);
    }

    public function update(MedicineRequest $request, $id)
    {
        try {
            $medicine = MedicineModel::findOrFail($id);
            $medicine->updated_by = Session::get('sess_user_id');
            $medicine->update($request->all());

            $this->uploadLogo($request, $id);

            Toastr::success(config('app_config.msg_update'), "Update", $options = []);

            return redirect("medicine/$id/edit");

        } catch (\Exception $e) {

            Toastr::error(config('app_config.msg_failed_update'), "Update Failed", $options = []);

            return redirect("idscenter/$id/edit")
                ->with('dangerMsg', $e->getMessage());
        }
    }
}
