<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use narutimateum\Toastr\Facades\Toastr;
use Riesenia\Kendo\Kendo;
use App\KendoModel as kds;
use mjanssen\BreadcrumbsBundle\Breadcrumbs;
use App\Http\Libraries\SentinelAuthCheck as SentinelAuth;

class RoleController extends Controller
{
    public $kds;

    public function __construct()
    {
        $this->middleware('auth');
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

        // breadcrumbs
        Breadcrumbs::addBreadcrumb(trans('users/role.breadcrumb1'), '/role');
        Breadcrumbs::addBreadcrumb(trans('users/role.breadcrumb2'), '#');

        $transport_create_data = Kendo::createTransportCreate()
            ->setUrl('/role/create')
            ->setContentType('application/json')
            ->setType('POST');

        $transport_read_data = Kendo::createTransportRead()
            ->setUrl('/role/read')
            ->setContentType('application/json')
            ->setType('POST');

        $transport_update_data = Kendo::createTransportUpdate()
            ->setUrl('/role/update')
            ->setContentType('application/json')
            ->setType('POST');

        $transport_data = Kendo::createTransport()
            ->setRead($transport_read_data)
            ->setCreate($transport_create_data)
            ->setUpdate($transport_update_data)
            ->setParameterMap(Kendo::js('function(data) { return kendo.stringify(data); }'));


        $model_data = Kendo::createModel()
            ->setId('id')
            ->addField('name', ['type' => 'string', 'validation' => ['required' => true]])
            ->addField('slug', ['type' => 'string', 'validation' => ['required' => true]]);

        $schema_data = Kendo::createSchema()
            ->setData('data')
            ->setErrors('errors')
            ->setModel($model_data)
            ->setTotal('total');

        $dataSource_data = Kendo::createDataSource()
            ->setTransport($transport_data)
            ->setSchema($schema_data)
            ->setError(Kendo::js('onError'))
            ->setRequestEnd(Kendo::js('onRequestEnd'))
            ->setPageSize(config('app_config.num_paging_row'))
            ->setServerSorting(true)
            ->setServerPaging(true)
            ->setServerFiltering(true);



        $pageable = Kendo::createPageable();
        $pageable->setRefresh(true)
            ->setPageSizes(config('app_config.grid_page_sizes'))
            ->setButtonCount(config('app_config.grid_button_count'));

        $grid_data = Kendo::createGrid('#grid_data')
            ->setDataSource($dataSource_data)
            ->setHeight(config('app_config.grid_height'))
            ->setEditable('inline')
            ->setSortable(true)
            ->setFilterable(true)
            ->setPageable($pageable)
            ->setColumns([
                ['field' => 'name', 'title' => trans('users/role.lbl_name')],
                ['field' => 'slug', 'title' => trans('users/role.lbl_slug')]
            ]);

        if (SentinelAuth::check('dss.security.role.add')) {
            $btnAdd = [['name' => 'create', 'text' => trans('users/role.btn_add')]];
            $grid_data->setToolbar($btnAdd);
        }

        $command = [];
        if (SentinelAuth::check('dss.security.role.permission')) {
            $command_permission = ["click" => Kendo::js('commandPermission'), "text" => trans('users/role.btn_permission')];
            $command[] = $command_permission;
        }

        if (SentinelAuth::check('dss.security.role.edit')) {
            $command[] = 'edit';
        }

        if (SentinelAuth::check('dss.security.role.del')) {
            $command_del = ["click" => Kendo::js('commandDelete'), "text" => trans('users/role.btn_delete')];
            $command[] = $command_del;
        }

        $grid_data->addColumns(null, ['command' => $command, 'title' => "&nbsp;", 'width' => "250px"]);
        $data = ['js_grid_data' => $grid_data];
        return view('user.role.list', $data);
    }


    public function operation($type)
    {
        $request = json_decode(file_get_contents('php://input'));
        $columns = array('id', 'name', 'slug');
        $this->kds = new kds;

        switch ($type) {
            case 'create':
                $columns[]='created_at';
                $request->created_at = date('Y-m-d H:i:s');
                $result = $this->kds->create('roles', $columns, $request, 'id');
                if(isset($result['errors'])) {
                    echo 0; // error track
                }
                break;
            case 'read':
                $result = $this->kds->read('roles', $columns, $request);
                break;
            case 'update':
                $columns[]='updated_at';
                $request->updated_at = date('Y-m-d H:i:s');
                $result = $this->kds->update('roles', $columns, $request, 'id');
                break;
            case 'destroy':
                $result = $this->kds->destroy('roles', $request, 'id');
                break;
        }

        return response(json_encode($result))->header('Content-Type', 'application/json');
    }

   }
