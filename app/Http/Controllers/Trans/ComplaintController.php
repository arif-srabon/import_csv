<?php

namespace App\Http\Controllers\Trans;

use App\Model\Setup\CommonConfigModel;
use App\Model\Trans\ComplaintModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use narutimateum\Toastr\Facades\Toastr;
use Riesenia\Kendo\Kendo;
use App\KendoModel as kds;
use mjanssen\BreadcrumbsBundle\Breadcrumbs;
use App\Http\Libraries\SentinelAuthCheck as SentinelAuth;

class ComplaintController extends Controller
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
            'kendoui/kendo.all.min.js'
        ]);

        Breadcrumbs::addBreadcrumb(trans('trans/complaint.breadcrumb1'), '#');


        $transport_read_data = Kendo::createRead()
            ->setUrl('/complaint/read')
            ->setContentType('application/json')
            ->setType('POST');
        $transport_destroy_data = Kendo::createDestroy()
            ->setUrl('/complaint/destroy')
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

        $grid_district = Kendo::createGrid('#grid_complaint')
            ->setDataSource($dataSource_data)
            ->setHeight(config('app_config.grid_height'))
            ->setSortable(true)
            ->setFilterable(true)
            ->setPageable($pageable)
            ->setColumns([
                ['field' => 'submit_date', 'title' => trans('trans/complaint.col_submit_dt')],
                ['field' => 'district_name', 'title' => trans('trans/complaint.col_district')],
                ['field' => 'reporter_name', 'title' => trans('trans/complaint.col_reporter_name')],
                ['field' => 'profession', 'title' => trans('trans/complaint.col_profession')],
                ['field' => 'status', 'title' => trans('trans/complaint.col_status'), 'width' => "11%"]
            ]);

        $command = array();
        if (SentinelAuth::check('transactions.complaint.edit')) {
            $btn_edit = " <div class='k-button k-grid-edit' style='min-width: 16px;' title='" . trans('setup/medicine.btn_edit') . "' ><span class='k-icon k-edit'></span></div>";
            $command_edit = ["template" => $btn_edit];
            $command [] = $command_edit;
        }

        if (SentinelAuth::check('transactions.complaint.print')) {
            $btn_del = "<div class='k-button k-grid-print' style='min-width: 16px;' title='Print' ><span class='k-icon k-print'></span></div>";
            $command_del = ["template" => $btn_del];
            $command [] = $command_del;
        }

        if (SentinelAuth::check(['transactions.complaint.edit', 'transactions.complaint.print'])) {
            $grid_district->addColumns(null, ['command' => $command, 'title' => "&nbsp;", 'width' => "10%"]);
        }

        $data = ['kd_grid' => $grid_district];
        return view('complaint.list', $data);
    }

    public function read()
    {
        $request = json_decode(file_get_contents('php://input'));

        $table = "complaint
                    LEFT JOIN districts ON districts.id = complaint.district_id
                    LEFT JOIN cc_complaint_status ON cc_complaint_status.id = complaint.status_id";

        $district_name = "districts.`name` AS district_name";
        $status = "cc_complaint_status.`name` AS `status`";
        if ($this->lang == 'bn') {
            $district_name = "districts.name_bn AS district_name";
            $status = "cc_complaint_status.name_bn AS status";
        }

        $properties = array("complaint.id AS id",
            "DATE_FORMAT(complaint.submit_date,'%d-%b-%Y') AS submit_date",
            $district_name,
            $status,
            "CONCAT(complaint.repoter_title,' ',complaint.full_name) AS reporter_name",
            "complaint.profession AS profession");

        $this->kds = new kds;
        $data = $this->kds->read($table, $properties, $request);

        return response(json_encode($data))
            ->header('Content-Type', 'application/json');
    }

    public function edit($id)
    {
        \Assets::add([
            'plugins/forms/validation/validate.min.js',
            'plugins/forms/styling/uniform.min.js',
            'plugins/forms/selects/select2.min.js',
            'app/medicine_form_validation.js'
        ]);

        // breadcrumbs
        Breadcrumbs::addBreadcrumb(trans('trans/complaint.breadcrumb1'), '#');
        Breadcrumbs::addBreadcrumb(trans('users/user.breadcrumb3'), '#');

        $data = [];
        $complaint = new ComplaintModel;
        $complaints = ComplaintModel::findOrFail($id);
        $data['complaintInfo'] = $complaint->getComplaintInfo($id);

        $cConfig = new CommonConfigModel;
        $data['complaintStatus']       = $cConfig->getAllCommonConfigList('cc_complaint_status', $this->lang);
        $data['complaintReportAdvice'] = $cConfig->getAllCommonConfigList('cc_complaint_report_advice', $this->lang);
        $data['complaintTypes']        = $cConfig->getAllCommonConfigList('cc_complaint_types', $this->lang);

        return view('complaint.edit', compact('complaints'))->with($data);
    }

    public function update(Request $request, $id)
    {
        try {
            $complaint = ComplaintModel::findOrFail($id);
            $complaint->updated_by = Session::get('sess_user_id');
            $complaint->update($request->all());

            Toastr::success(config('app_config.msg_update'), "Update", $options = []);

            return redirect("complaint/$id/edit");

        } catch (\Exception $e) {

            Toastr::error(config('app_config.msg_failed_update'), "Update Failed", $options = []);

            return redirect("complaint/$id/edit")
                ->with('dangerMsg', $e->getMessage());
        }
    }

    public function printComplaint($id)
    {
        \Assets::add([
            'plugins/forms/styling/uniform.min.js',
            'plugins/forms/selects/select2.min.js'
        ]);

        // breadcrumbs
        Breadcrumbs::addBreadcrumb(trans('trans/complaint.breadcrumb1'), '#');
        Breadcrumbs::addBreadcrumb(trans('users/user.breadcrumb3'), '#');

        $data = [];
        $complaint = new ComplaintModel;
        $complaints = ComplaintModel::findOrFail($id);
        $data['complaintInfo'] = $complaint->getComplaintInfo($id);

        $cConfig = new CommonConfigModel;
        $data['complaintStatus']       = $cConfig->getAllCommonConfigList('cc_complaint_status', $this->lang);
        $data['complaintReportAdvice'] = $cConfig->getAllCommonConfigList('cc_complaint_report_advice', $this->lang);
        $data['complaintTypes']        = $cConfig->getAllCommonConfigList('cc_complaint_types', $this->lang);

        return view('complaint.print', compact('complaints'))->with($data);
    }


}
