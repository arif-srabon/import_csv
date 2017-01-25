<?php

namespace App\Http\Controllers\Setup;



use App\Http\Libraries\SentinelAuthCheck as SentinelAuth;
use App\Model\Setup\CommonConfigModel;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Schema;
use mjanssen\BreadcrumbsBundle\Breadcrumbs;
use narutimateum\Toastr\Facades\Toastr;
use Riesenia\Kendo\Kendo;
use App\KendoModel as kds;
use Session;
use Validator;


class CommonConfigController extends Controller
{
    public $kds;
    public $lang;
    public function __construct(){

        $this->middleware('auth');
        $this->kds = new kds;
        $this->lang = Session::get("locale");
        if(!isset($this->lang)){
            $this->lang =config('app.locale');
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

        Breadcrumbs::addBreadcrumb(trans('setup/common_config.breadcrumb1'), '#');
        Breadcrumbs::addBreadcrumb(trans('setup/common_config.breadcrumb2'), '/commonconfig');

        $cConfig = new CommonConfigModel;
        $commonconfigmaps = $cConfig->getCommonConfigMapList($this->lang);



        return view('setup/common_config', compact('commonconfigmaps'));
    }

    public function commonConfigList($category_id){

        $cConfig = new CommonConfigModel;
        $common_config_map = $cConfig->getCommonConfigMap($category_id, $this->lang);


        if (!Schema::hasTable($common_config_map->table_name))
        {
            echo "Please contact system admin to set " . $common_config_map->table_name . " in database.";
            return;
        }

        $table_name = $common_config_map->table_name;

        $title = $common_config_map->display_name;
        if($this->lang =='bn'){
            $title = $common_config_map->display_name_bn;
        }

        $transport_create_data = Kendo::createTransportCreate()
            ->setUrl('/commonconfig/create/'.$table_name)
            ->setContentType('application/json')
            ->setType('POST');
        $transport_read_data = Kendo::createTransportRead()
            ->setUrl('/commonconfig/read/'.$table_name)
            ->setContentType('application/json')
            ->setType('POST');
        $transport_update_data = Kendo::createTransportUpdate()
            ->setUrl('/commonconfig/update/'.$table_name)
            ->setContentType('application/json')
            ->setType('POST');

        $transport_data = Kendo::createTransport()
            ->setRead($transport_read_data)
            ->setCreate($transport_create_data)
            ->setUpdate($transport_update_data)
            ->setParameterMap(Kendo::js('function(data) { return kendo.stringify(data); }'));


        $model_data = Kendo::createModel()
            ->setId('id')
            ->addField('code', ['type' => 'string','validation' =>['required' =>true] ])
            ->addField('name', ['type' => 'string','validation' =>['required' =>true] ])
            ->addField('name_bn', ['type' => 'string'])
            ->addField('weight', ['type' => 'number'])
            ->addField('is_default', ['type' => 'number'])
            ->addField('is_active', ['type' => 'number']);

        $schema_data = Kendo::createSchema()
            ->setData('data')
            ->setErrors('errors')
            ->setModel($model_data)
            ->setTotal('total');



        $dataSource_data = Kendo::createDataSource()
            ->setTransport($transport_data)
            ->setSchema($schema_data)
            ->setPageSize(config('app_config.num_paging_row'))
            ->setError(Kendo::js('onError'))
            ->setRequestEnd(Kendo::js('onRequestEnd'))
            ->setServerSorting(true)
            ->setServerPaging(true)
            ->setServerFiltering(true);


        if($this->lang == 'bn'){
            $yes = 'হ্যাঁ';
            $no = 'না';
            $active = 'সক্রিয়';
            $inactive = 'নিষ্ক্রিয়';
            $btnAdd =[['name' =>'create','text' =>$title.' '.trans('setup/common_config.btn_add')]];
            $is_default =  '# if (is_default == 1) { #হ্যাঁ# } else { #না# } #';
            $is_active =  '# if (is_active == 1) { #সক্রিয়# } else { #নিষ্ক্রিয়# } #';
        }else{
            $yes = 'Yes';
            $no = 'No';
            $active = 'Active';
            $inactive = 'Inactive';
            $btnAdd =[['name' =>'create','text' =>trans('setup/common_config.btn_add').' '.$title]];
            $is_default =  '# if (is_default == 1) { #Yes# } else { #No# } #';
            $is_active =  '# if (is_active == 1) { #Active# } else { #Inactive# } #';
        }

        $pageable = Kendo::createPageable();
        $pageable->setRefresh(true)
            ->setPageSizes(config('app_config.grid_page_sizes'))
            ->setButtonCount(config('app_config.grid_button_count'));

        $defaultData[] = array('value' => '0', 'text' => $no);
        $defaultData[] = array('value' => '1', 'text' => $yes);

        $isActiveData[] = array('value' => '0', 'text' => $inactive);
        $isActiveData[] = array('value' => '1', 'text' => $active);

        $grid_common_config = Kendo::createGrid('#grid_common_config')
            ->setDataSource($dataSource_data)
            ->setHeight(config('app_config.grid_height'))
            ->setEditable('inline')
            ->setSortable(true)
            ->setFilterable(true)
            ->setPageable($pageable)
            ->setColumns([
                ['field' => 'code', 'title' => trans('setup/common_config.column_code'),'filterable' =>false,'sortable' =>false,'width'=>"8%"],
                ['field' => 'name', 'title' => trans('setup/common_config.column_name')],
                ['field' => 'name_bn', 'title' => trans('setup/common_config.column_name_bn')],
                ['field' => 'weight', 'title' => trans('setup/common_config.column_weight'),'filterable' =>false,'sortable' =>false,'width'=>"7%"],
                ['field' => 'is_default', 'title' => trans('setup/common_config.column_default'), 'values' => $defaultData, 'template' => $is_default, 'filterable' => false, 'sortable' => false, 'width' => "9%"],
                ['field' => 'is_active', 'title' => trans('setup/common_config.column_status'), 'values' => $isActiveData, 'template' => $is_active, 'filterable' => false, 'sortable' => false, 'width' => "9%"]
            ]);

        if(SentinelAuth::check('dss.settings.commonconfig.add')) {
            $grid_common_config->setToolbar($btnAdd);
        }

        $command = array();
        if(SentinelAuth::check('dss.settings.commonconfig.edit')){
            $command[] = 'edit';
        }
        if(SentinelAuth::check('dss.settings.commonconfig.del')) {
            $command_del = ["click" => Kendo::js('commandDelete'), "text" => trans('setup/common_config.btn_delete')];
            $command[] = $command_del;
        }
        if(SentinelAuth::check(['dss.settings.commonconfig.edit', 'dss.settings.commonconfig.del'])) {
            $grid_common_config->addColumns(null, ['command' => $command, 'title' => "&nbsp;", 'width' => "18%"]);
        }

        $data =['js_grid_common_config' =>$grid_common_config,'table_name'=>$table_name ];

        return view('setup/common_config_list')->with($data);


    }

    public function commonConfigData($type, $table_name)
    {
        $request = json_decode(file_get_contents('php://input'));

        $columns = array('id', 'code', 'name', 'name_bn','weight','is_default','is_active');

        switch($type) {
            case 'create':

                $request->is_active = (int)$request->is_active;
                $request->is_default = (int)$request->is_default;

                $columns[]='created_by';
                $request->created_by = Session::get('sess_user_id');
                $columns[]='created_at';
                $request->created_at = date('Y-m-d H:i:s');
                $result = $this->kds->create($table_name, $columns, $request, 'id');

                $result = response(json_encode($result,JSON_NUMERIC_CHECK))
                ->header('Content-Type', 'application/json');

                break;
            case 'read':

                $result = $this->kds->read($table_name, $columns, $request);
                $result = response(json_encode($result))
                    ->header('Content-Type', 'application/json');
                break;
            case 'update':

                $request->is_active = (int)$request->is_active;
                $request->is_default = (int)$request->is_default;
                $columns[]='updated_by';
                $request->updated_by = Session::get('sess_user_id');
                $columns[]='updated_at';
                $request->updated_at = date('Y-m-d H:i:s');
                $result = $this->kds->update($table_name, $columns, $request, 'id');
                $result = response(json_encode($result,JSON_NUMERIC_CHECK))
                    ->header('Content-Type', 'application/json');
                break;
            case 'destroy':
                $result = $this->kds->destroy($table_name, $request, 'id');
                $result = response(json_encode($result))
                    ->header('Content-Type', 'application/json');
                break;
        }

        return $result;

    }

}
