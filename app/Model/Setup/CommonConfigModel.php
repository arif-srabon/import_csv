<?php  namespace App\Model\Setup;

use Cache;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;

class CommonConfigModel extends Model
{

    public function getAllCommonConfigList($table_name, $lang = 'en')
    {
        $name = "name as name";
        $cache_file ='cache_dataList_'.$table_name;
        if(isset($lang) && $lang !='en'){
            $name = "name_".$lang." as name";
            $cache_file ="cache_dataList_".$table_name."_".$lang;

        }

        $value = Cache::remember($cache_file, config('app_config.cache_time_limit'), function() use($table_name,$name) {
            return DB::table($table_name)
                ->where('is_active', 1)
                ->orderBy('weight', 'desc')
                ->lists($name, 'id');
        });

        return $value;
    }

    public function getAllCommonConfigDataList($table_name, $lang = 'en')
    {
        $name = "name as name";
        $cache_file ='cache_CommonConfigdataList_'.$table_name;
        if(isset($lang) && $lang !='en'){
            $name = "name_".$lang." as name";
            $cache_file ="cache_CommonConfigdataList_".$table_name."_".$lang;

        }

        $value = Cache::remember($cache_file, config('app_config.cache_time_limit'), function() use($table_name,$name) {
            return DB::table($table_name)
                ->select($name, 'id', 'code', 'weight')
                ->where('is_active', 1)
                ->orderBy('weight', 'desc')
                ->get();
        });

        return $value;
    }


    public function getAllCommonConfigCodeListList($table_name, $lang = 'en')
    {
        return DB::table($table_name)
                ->where('is_active', 1)
                ->where('code', 9)
                ->orderBy('weight', 'desc')
                ->orderBy('name', 'asc')
                ->value('code');
//        $name = "name as name";
//        $cache_file ='cache_dataList_code_'.$table_name;
//        if(isset($lang) && $lang !='en'){
//            $name = "name_".$lang." as name";
//            $cache_file ="cache_dataList_code_".$table_name."_".$lang;
//
//        }
//
//        $value = Cache::remember($cache_file, config('app_config.cache_time_limit'), function() use($table_name,$name) {
//            return DB::table($table_name)
//                ->where('is_active', 1)
//                ->where('code', 9)
//                ->orderBy('weight', 'desc')
//                ->orderBy('name', 'asc')
//                ->pluck('code');
//        });

        return $value;
    }
    public function getCommonConfigMapList($lang = 'en')
    {
        $field = "display_name as name";
        $cache_file ='cache_commonConfigMapList';
        if(isset($lang) && $lang !='en'){
            $field = "display_name_".$lang." as name";
            $cache_file ="cache_commonConfigMapList_".$lang;
        }
        $data = Cache::remember($cache_file, config('app_config.cache_time_limit'), function () use ($field) {
            return DB::table('common_config_maps')
                ->where('is_active', 1)
                ->orderBy('weight', 'desc')
                //->orderBy($field, 'asc')
                ->lists($field, 'id');
        });

        return $data;

    }
    public function getCommonConfigMap($category_id, $lang = 'en')
    {
//        $name = 'display_name as display_name';
//        if($lang =='bn'){
//            $name = 'display_name_bn as display_name';
//        }
//        echo $name;
//        ->select('id',$name,'table_name')
//        exit;
        $rs = DB::table('common_config_maps')->where('id', $category_id)->first();
        return $rs;

    }

    public function make_dir($path, $rights = 0775)
    {
        $folder_path = array(strstr($path, '.') ? dirname($path) : $path);
        while (!@is_dir(dirname(end($folder_path))) && dirname(end($folder_path)) != '/' && dirname(end($folder_path)) != '.' && dirname(end($folder_path)) != '') {
            array_push($folder_path, dirname(end($folder_path)));
        }

        while ($parent_folder_path = array_pop($folder_path)) {
            if (!@mkdir($parent_folder_path, $rights)) {
                //user_error("Can't create folder \"$parent_folder_path\".");
            }
        }
    }

    public function base64_to_jpeg($base64_string, $id, $path)
    {
        //dd($base64_string);
        $uploadPath = $path . $id;
        $fileName = time() . '.jpg';
        $output_file = $uploadPath . "/" . $fileName;
        $this->make_dir($uploadPath, 0770);
        $ifp = fopen($output_file, "wb");
        $data = explode(',', $base64_string);
        fwrite($ifp, base64_decode($data[1]));
        fclose($ifp);
        return $output_file;
    }

    // For Calculating age from date of birth
    public function CalculateAge($DOB, $CreatedDate)
    {
        $date_reg = Carbon::createFromFormat('d-m-Y', $DOB)->format('Y-m-d');
        $date_reg = explode('-', $date_reg);
        $age1 = Carbon::createFromDate($date_reg[0], $date_reg[1], $date_reg[2])->diff($CreatedDate)->format('%y');
        $age2 = Carbon::createFromDate($date_reg[0], $date_reg[1], $date_reg[2])->diff($CreatedDate)->format('%m');
        $age=$age1.'.'.$age2;
        $age=(FLOAT)$age;
        return $age;
    }
}