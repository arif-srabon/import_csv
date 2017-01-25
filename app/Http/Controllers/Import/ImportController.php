<?php

namespace App\Http\Controllers\Import;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\ImportFileRequest;
use Illuminate\Support\Facades\DB;
use App\Model\Import\ImportFileModel;
use Response;
use Illuminate\Support\Facades\Session;
use narutimateum\Toastr\Facades\Toastr;
use mjanssen\BreadcrumbsBundle\Breadcrumbs;
use App\Http\Libraries\SentinelAuthCheck as SentinelAuth;

class ImportController extends Controller
{
    public $lang;

    public function __CONSTRUCT()
    {
        $this->middleware('auth');
        $this->lang = Session::get("locale");
        if(!isset($this->lang)){
            $this->lang = config('app.locale');
        }
    }


    public function index()
    {
        \Assets::add([
            'plugins/forms/validation/validate.min.js',
            'plugins/forms/styling/uniform.min.js',
           // 'plugins/ui/moment/moment.min.js',
            'core/libraries/jquery.form.js',
            'icons/fontawesome/styles.min.css',
            'app/import_file.js'
        ]);
        Breadcrumbs::addBreadcrumb(trans('import.breadcrumb1'), '#');
        Breadcrumbs::addBreadcrumb(trans('import.breadcrumb2'), '/import');

        return view('import.import_form');
    }

    public function store(ImportFileRequest $request){
        try{
            $inputs = $request->all();
            $type = $inputs['type'];
            $file = $request->file('import_file');
            if (!empty($file)) {
                if($file->getClientOriginalExtension() == 'csv'){
                    $uploadPath = config('app_config.import_file_path') . "$type/";
                    $fileName = time() . '.' . $file->getClientOriginalExtension();
                    $orginalfileName = $file->getclientoriginalname() ;
                    $file->move(public_path($uploadPath), $orginalfileName);
//                    $uploadFile = $uploadPath . $fileName;

                    //read file
                    $file_n = ($uploadPath.$orginalfileName);
                    $header = null;
                    $data = array();
                    if (($handle = fopen($file_n, 'r')) !== false)
                    {
                        while (($row = fgetcsv($handle, 1000, ',')) !== false)
                        {
                            if (!$header)
                                $header = $row;
                            else
                                $data[] = array_combine($header, $row);
                        }
                        fclose($handle);
                    }
                    switch($type){
                        case 'generic':
                            $headerForImportData= array("G_CODE", "G_NAME");
                            $diff = array_diff($headerForImportData, $header);
                            if(empty($diff)){
                                $this->import_genericData($data);
                            }
                            break;
                        case 'dosage':
                            $headerForImportData=array("DOS_CODE", "DOS_DESC");
                            $diff = array_diff($headerForImportData, $header);
                            if(empty($diff)) {
                                $this->import_dosageData($data);
                            }
                            break;
                        case 'medicine':
                            $headerForImportData=array("PROD_NAME","DCC_NO","DOS_CODE",
                                "G_CODE","COM_CODE");
                            $diff = array_diff($headerForImportData, $header);
                            if(empty($diff)) {
                                $this->import_medicineData($data);
                            }
                            break;
                        case 'manufacturer':
                            $headerForImportData=array("COM_CODE","COM_NAME","LIC_BIO","LIC_NON_BIO",
                                "RD_NO_NAME","HOUSE_NAME","VALID_UPTO");
                            $diff = array_diff($headerForImportData, $header);
                            if(empty($diff)) {
                                $this->import_manufacturerData($data);
                            }
                            break;
                    }
                    if($diff){
                        return view('partials.import_error',compact('diff','headerForImportData','type'));
                    }else{
                        $data = [
                            'toastr_success' => config('app_config.toastr_success'),
                            'title' => 'Upload',
                            'message' => config('app_config.msg_upload')
                        ];
                    }


                }else{
                    $data = [
                        'toastr_warning' => config('app_config.toastr_warning'),
                        'title' => 'Warning',
                        'message'=>'Invalid File format.'
                    ];
                }

            }

        }catch(\Exception $e){
            $data = ['toastr_error' => config('app_config.toastr_error'), 'title' => 'Error', 'message' => $e->getMessage()];
        }
        return Response::json($data);
    }

    public function import_genericData($data){
      if(!empty($data)){
          foreach($data as $item){
              if(!empty($item['G_CODE']) && !empty($item['G_NAME'])){
                  $importModel = new ImportFileModel();
                  $IdCheck = $importModel->CheckDuplicateValueForGeneric($item['G_CODE'], $item['G_NAME']);
                  if(empty($IdCheck)){
                      $insertData = [
                          'code' => $item['G_CODE'],
                          'name' => $item['G_NAME'],
                          'name_bn' => $item['G_NAME'],
                          'weight' => 1,
                          'is_default' => 0,
                          'is_active' => 1,
                          'created_by' => Session::get('sess_user_id'),
                          'created_at' =>date('Y-m-d H:i:s'),
                      ];
                      DB::table('cc_generic')->insert($insertData);
                  }else{
                      $updateData = [
                          'code' => $item['G_CODE'],
                          'name' => $item['G_NAME'],
                          'name_bn' => $item['G_NAME'],
                          'weight' => 1,
                          'is_default' => 0,
                          'is_active' => 1,
                          'updated_by' => Session::get('sess_user_id'),
                          'updated_at' =>date('Y-m-d H:i:s'),
                      ];
                      $DataList=DB::table('cc_generic')->where('id','=',$IdCheck[0]->id);
                      $DataList->update($updateData);
                  }

              }

          }
      }
    }
    public function import_dosageData($data){
        if(!empty($data)){
            foreach($data as $item){
                if(!empty($item['DOS_CODE']) && !empty($item['DOS_DESC'])){
                    $importModel = new ImportFileModel();
                    $IdCheck = $importModel->CheckDuplicateValueForDosage($item['DOS_CODE'], $item['DOS_DESC']);
                    if(empty($IdCheck)){
                        $insertData = [
                            'code' => $item['DOS_CODE'],
                            'name' => $item['DOS_DESC'],
                            'name_bn' => $item['DOS_DESC'],
                            'weight' => 1,
                            'is_default' => 0,
                            'is_active' => 1,
                            'created_by' => Session::get('sess_user_id'),
                            'created_at' =>date('Y-m-d H:i:s'),
                        ];
                        DB::table('cc_medicine_type')->insert($insertData);
                    }else{
                        $updateData = [
                            'code' => $item['DOS_CODE'],
                            'name' => $item['DOS_DESC'],
                            'name_bn' => $item['DOS_DESC'],
                            'weight' => 1,
                            'is_default' => 0,
                            'is_active' => 1,
                            'updated_by' => Session::get('sess_user_id'),
                            'updated_at' =>date('Y-m-d H:i:s'),
                        ];
                        $DataList=DB::table('cc_medicine_type')->where('id','=',$IdCheck[0]->id);
                        $DataList->update($updateData);

                    }

                }

            }
        }
    }
    public function import_medicineData($data){
        if(!empty($data)){
            foreach($data as $item){
                if(!empty($item['PROD_NAME'])){
                    $importModel = new ImportFileModel();
                    $checkDuplicateID=$importModel->CheckDuplicateValueForMedicineData($item['PROD_NAME'],$item['DCC_NO']);
                    if(empty($checkDuplicateID)){
                        $insertData = [
                            'name'=>$item['PROD_NAME'],
                            'code'=>$item['DCC_NO'],
                            'medicine_type_id'=>$this->medicineTypeId($item),
                            'generic_id'=>$this->genericId($item),
//                            'price'=>'',
                            'manufactuer_id'=>$this->manufactuerId($item),
                            'status'=>1,
                            'created_at'=>date('Y-m-d H:i:s'),
                            'created_by'=>Session::get('sess_user_id'),
                        ];
                        DB::table('medicine')->insert($insertData);
                    }else{
                        $updateData = [
                            'name'=>$item['PROD_NAME'],
                            'code'=>$item['DCC_NO'],
                            'medicine_type_id'=>$this->medicineTypeId($item),
                            'generic_id'=>$this->genericId($item),
//                            'price'=>'',
                            'manufactuer_id'=>$this->manufactuerId($item),
                            'status'=>1,
                            'updated_at'=>date('Y-m-d H:i:s'),
                            'updated_by'=>Session::get('sess_user_id'),
                        ];
                        $DataList=DB::table('medicine')->where('id','=',$checkDuplicateID[0]->id);
                        $DataList->update($updateData);
                    }

                }

            }
        }
    }
    public function import_manufacturerData($data){
        if(!empty($data)){
            foreach($data as $item){
                if(!empty($item['COM_CODE']) && !empty($item['COM_NAME'])){
                    $importModel = new ImportFileModel();
                    $manufacturerID=$importModel->CheckCompany($item['COM_CODE'],$item['COM_NAME']);
                    if(empty($manufacturerID)){
                        $insertData = [
                            'company_code'=>$item['COM_CODE'],
                            'code'=>$this->LicBioCode($item),
                            'code_non_bio'=>$this->LicNonBioCode($item),
                            'name'=>$item['COM_NAME'],
                            'name_bn'=>$item['COM_NAME'],
                            'address'=>$this->CompanyAddress($item),
                            'registration_dt'=>$item['VALID_UPTO'],
                            'status'=>1,
                            'created_at' =>date('Y-m-d H:i:s'),
                        ];
                        DB::table('manufacturer')->insert($insertData);
                    }else{
                        $updateData = [
                            'company_code'=>$item['COM_CODE'],
                            'code'=>$this->LicBioCode($item),
                            'code_non_bio'=>$this->LicNonBioCode($item),
                            'name'=>$item['COM_NAME'],
                            'name_bn'=>$item['COM_NAME'],
                            'address'=>$this->CompanyAddress($item),
                            'registration_dt'=>$item['VALID_UPTO'],
                            'status'=>1,
                            'updated_at' =>date('Y-m-d H:i:s'),
                        ];
                        $DataList=DB::table('manufacturer')->where('id','=',$manufacturerID[0]->id);
                        $DataList->update($updateData);
                    }

                };

            }
        };
    }

    //
    public function LicBioCode($item){
        if(empty($item['LIC_BIO'])){
            return "0000";
        }else{
            return $item['LIC_BIO'];
        }
    }
    public function LicNonBioCode($item){
        if(empty($item['LIC_NON_BIO'])){
            return "0000";
        }else{
            return $item['LIC_NON_BIO'];
        }
    }
    public function CompanyAddress($item){
        if(empty($item['RD_NO_NAME'])){
           if(empty($item['HOUSE_NAME'])){
               return 'Blank';
           }else{
               return $item['HOUSE_NAME'];
           }
        }else{
            return $item['RD_NO_NAME'];
        }
    }

    public function medicineTypeId($item){
        if($item['DOS_CODE']){
            $info = DB::table('cc_medicine_type')
                ->select('id')
                ->where('code',$item['DOS_CODE'])
                ->get();
            return $info[0]->id;
        }
    }
    public function genericId($item){
        if($item['G_CODE']){
            $info = DB::table('cc_generic')
                ->select('id')
                ->where('code',$item['G_CODE'])
                ->get();
            return $info[0]->id;
        }
    }

    public function manufactuerId($item){
        if($item['COM_CODE']){
            $info = DB::table('manufacturer')
                ->select('id')
                ->where('company_code',$item['COM_CODE'])
                ->get();
             return $info[0]->id;
        }
    }

    //
}
