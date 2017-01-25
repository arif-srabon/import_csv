<?php

namespace App\Model\User;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;
use Request;
use Session;

class AccessLogModel extends Model
{
    protected $table = 'access_log';

    protected $dates = ['login_datetime', 'logout_datetime'];


    public function saveAccesslog()
    {
        $attributes_data = [
            'office_id' => Session::get("sess_user_office_id",0),
            'user_id' => Session::get("sess_user_id"),
            'login_ip' => Request::ip(),
            'login_datetime' => Carbon::now(),
            'browser_info' => Request::header('User-Agent'),
            'created_at' => Carbon::now()
        ];

        $id = DB::table($this->table)->insertGetId($attributes_data);
        Session::set('sess_access_log_id', $id);
    }

    public function updateAccesslog()
    {
        DB::table($this->table)
            ->where('id', Session::get('sess_access_log_id'))
            ->update(['logout_datetime' => Carbon::now(),
                        'updated_at' => Carbon::now()]);
    }


    public function getUserOfficeInfo($user_id)
    {
        $sql = "SELECT
                    offices.name AS office_name
                    , offices.id
                    , offices.division_id AS office_division_id
                    , offices.district_id AS office_district_id
                    , offices.thana_upazila_id AS office_thana_upazila_id
                    , offices.city_corp_paurasava_id AS office_city_corp_paurasava_id
                    , offices.office_type_id AS office_office_type_id
                    , users.location_type_id AS user_location_type_id
                    , users.division_id AS user_division_id
                    , users.district_id AS user_district_id
                    , users.thana_upazila_id AS user_thana_upazila_id
                    , users.city_corp_paurasava_id AS user_city_corp_paurasava_id

                    , office_users.user_id AS office_user_id
                    , office_users.is_active AS office_user_status
                    , office_users.user_id
                    , offices.name_bn AS office_name_bn
                    , offices.village_area AS office_village
                    , districts.name AS district_name_en
                    , districts.name_bn AS district_name_bn
                    , divisions.name AS division_name_en
                    , divisions.name_bn AS division_name_bn
                    , thana_upazilas.name AS upazilla_name_en
                    , thana_upazilas.name_bn AS upazilla_name_bn
                    , city_corp_paurasavas.name AS paurasavas_name_en
                    , city_corp_paurasavas.name_bn AS paurasavas_name_bn
                    , city_corp_paurasavas.type AS paurasavas_type
                FROM
                    office_users
                    LEFT JOIN users
                        ON (office_users.user_id = users.id)
                    LEFT JOIN offices
                        ON (office_users.office_id = offices.id)
                    LEFT JOIN districts
                        ON (offices.district_id = districts.id)
                    LEFT JOIN divisions
                        ON (offices.division_id = divisions.id)
                    LEFT JOIN thana_upazilas
                        ON (thana_upazilas.id = offices.thana_upazila_id)
                    LEFT JOIN city_corp_paurasavas
                        ON (city_corp_paurasavas.id = offices.city_corp_paurasava_id)
                WHERE office_users.is_active =1 AND users.id = :USER_ID";

        $results = DB::select($sql, ['USER_ID' => $user_id]);

        return $results;
    }

    public function getOfficeJuridiction($office_id)
    {
        $sql = "SELECT
                    allowance_program_id
                    ,union_ward_id
                    ,bank_id
                FROM
                    office_jurisdictions
                WHERE is_active =:IS_ACTIVE_TRUE and office_id = :OFFICE_ID";

        $results = DB::select($sql, ['IS_ACTIVE_TRUE' =>config('app_config.is_active_true'),'OFFICE_ID' => $office_id]);

        return $results;
    }


}
