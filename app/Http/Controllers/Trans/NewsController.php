<?php

namespace App\Http\Controllers\Trans;

use App\Http\Requests\NewsRequest;
use App\Model\Trans\NewsModel;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use narutimateum\Toastr\Facades\Toastr;
use Riesenia\Kendo\Kendo;
use App\KendoModel as kds;
use mjanssen\BreadcrumbsBundle\Breadcrumbs;

use App\Http\Libraries\SentinelAuthCheck as SentinelAuth;

class NewsController extends Controller
{

    public $kds;
    public $lang;

    public function __construct()
    {
        $this->middleware('auth');
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
        \Assets::add(['kendoui/kendo.common.min.css',
            'kendoui/kendo.default.min.css',
            'kendoui/kendo.all.min.js'
        ]);

        Breadcrumbs::addBreadcrumb(trans('setup/news.breadcrumb1'), '#');
        Breadcrumbs::addBreadcrumb(trans('setup/news.breadcrumb3'), '/news');

        $transport_read_data = Kendo::createRead()
            ->setUrl('/news/read')
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

        if ($this->lang == 'bn') {
            $status = '# if (status == 1) { #সক্রিয়# } else { #নিষ্ক্রিয়# } #';
        } else {
            $status = '# if (status == 1) { #Active# } else { #Inactive# } #';
        }


        $grid_allowance_program = Kendo::createGrid('#grid_allowance_program')
            ->setDataSource($dataSource_data)
            ->setHeight(config('app_config.grid_height'))
            ->setSortable(true)
            ->setFilterable(true)
            ->setPageable($pageable)
            ->setColumns([
                ['field' => 'title', 'title' => trans('setup/news.col_title')],
                ['field' => 'type', 'title' => trans('setup/news.col_type'), 'width' => "14%",],
                ['field' => 'status', 'title' => trans('setup/news.col_status'), 'width' => "11%", 'template' => $status]
            ]);

        $command = [];
        if (SentinelAuth::check('transactions.news.edit')) {
            $btn_edit = " <div class='k-button k-grid-edit' style='min-width: 16px;' title='" . trans('office.btn_edit') . "' ><span class='k-icon k-edit'></span></div>";
            $command [] = ["template" => $btn_edit];
        }
        if (SentinelAuth::check('transactions.news.del')) {
            $btn_del = "<div class='k-button k-grid-delete' style='min-width: 16px;' title='" . trans('office.btn_delete') . "' ><span class='k-icon k-delete'></span></div>";
            $command [] = ["template" => $btn_del];
        }
        if (SentinelAuth::check(['transactions.news.edit', 'transactions.news.del'])) {
            $grid_allowance_program->addColumns(null, ['command' => $command, 'title' => "&nbsp;", 'width' => "100px"]);
        }
        $data = ['js_grid_allowance_program' => $grid_allowance_program];
        return view('news.list', $data);
    }

    public function read()
    {
        $request = json_decode(file_get_contents('php://input'));
        $table = 'news';
        $properties = array('id',
            'title',
            'type',
            'status',
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
            'plugins/forms/styling/uniform.min.js',
            'plugins/ui/moment/moment.min.js',
            'plugins/pickers/daterangepicker.js',
            'plugins/editors/summernote/summernote.min.js',
            'app/news_form_validation.js'
        ]);

        // breadcrumbs
        Breadcrumbs::addBreadcrumb(trans('setup/news.breadcrumb1'), '/news');
        Breadcrumbs::addBreadcrumb(trans('setup/news.breadcrumb4'), '/news');

        return view('news.add');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewsRequest $request)
    {
        try {
            $inputs = $request->all();
            $inputs['created_by'] = Session::get('sess_user_id');
            NewsModel::create($inputs);

            Toastr::success(config('app_config.msg_save'), "Save", $options = []);
            return redirect('news/create');

        } catch (\Exception $e) {

            Toastr::error(config('app_config.msg_failed_save'), "Save Failed", $options = []);
            return redirect('news/create')
                ->with('dangerMsg', $e->getMessage());
        }
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
            'plugins/forms/styling/uniform.min.js',
            'plugins/ui/moment/moment.min.js',
            'plugins/pickers/daterangepicker.js',
            'plugins/editors/summernote/summernote.min.js',
            'app/news_form_validation.js'
        ]);

        // breadcrumbs
        Breadcrumbs::addBreadcrumb(trans('setup/news.breadcrumb1'), '/lettertemplate');
        Breadcrumbs::addBreadcrumb(trans('setup/news.breadcrumb4'), '/lettertemplate');

        $news = NewsModel::findOrFail($id);

        return view('news.edit', compact('news'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(NewsRequest $request, $id)
    {
        try {
            $news = NewsModel::findOrFail($id);
            $news->updated_by = Session::get('sess_user_id');
            $news->update($request->all());

            Toastr::success(config('app_config.msg_update'), "Update", $options = []);
            return redirect("news/$id/edit");

        } catch (\Exception $e) {
            Toastr::error(config('app_config.msg_failed_update'), "Update Failed", $options = []);
            return redirect("news/$id/edit")
                ->with('dangerMsg', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $request = json_decode(file_get_contents('php://input'));
        $stat = NewsModel::destroy($request->id);
        return response(json_encode($stat))
            ->header('Content-Type', 'application/json');
    }


}
