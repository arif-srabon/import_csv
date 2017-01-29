<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Session;

class CcReligionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data = [
            [
                'code' => 11,
                'name' => "Muslims",
                'name_bn' => "Muslims",
                'weight' => 3,
                'is_default' => 1,
                'is_active' => 1,
                'created_by' => Session::get('sess_user_id'),
                'updated_by' => Session::get('sess_user_id')
            ],
            [
                'code' => 12,
                'name' => "Hindu",
                'name_bn' => "Hindu",
                'weight' => 2,
                'is_default' => 1,
                'is_active' => 1,
                'created_by' => Session::get('sess_user_id'),
                'updated_by' => Session::get('sess_user_id')
            ],
            [
                'code' => 13,
                'name' => "Christian",
                'name_bn' => "Christian",
                'weight' => 1,
                'is_default' => 1,
                'is_active' => 1,
                'created_by' => Session::get('sess_user_id'),
                'updated_by' => Session::get('sess_user_id')
            ],
            [
                'code' => 13,
                'name' => "Buddhis",
                'name_bn' => "Buddhis",
                'weight' => 1,
                'is_default' => 1,
                'is_active' => 1,
                'created_by' => Session::get('sess_user_id'),
                'updated_by' => Session::get('sess_user_id')
            ],
        ];
        DB::table('cc_religion')->truncate();
        foreach ($data as $value) {
            DB::table('cc_religion')->insert([
                'code'=>$value['code'],
                'name' => $value['name'],
                'name_bn' => $value['name_bn'],
                'weight' => $value['weight'],
                'is_default' => $value['is_default'],
                'is_active' => $value['is_active'],
                'created_by' => $value['created_by'],
                'updated_by' => $value['updated_by'],
            ]);
        }
    }
}
