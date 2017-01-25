<?php

namespace App\Model\Trans;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ComplaintModel extends Model
{
    protected $table = 'complaint';

    protected $fillable = [
        'status_id',
        'report_advice_id',
        'name',
        'name_bn'
    ];

    public function getComplaintInfo($id)
    {
        $sql = "SELECT
                      complaint.id,
                      DATE_FORMAT(
                        complaint.submit_date,
                        '%M %d, %Y'
                      ) AS submit_date,
                      complaint.status_id,
                      complaint.report_advice_id,
                      complaint.repoter_title,
                      complaint.full_name,
                      complaint.address,
                      complaint.profession,
                      complaint.division_id,
                      complaint.district_id,
                      complaint.upazilla_id,
                      complaint.union_id,
                      complaint.postcode,
                      complaint.email,
                      complaint.phone,
                      complaint.complaint_details,
                      divisions.`name` AS division_name,
                      divisions.name_bn AS division_name_bn,
                      districts.`name` AS district_name,
                      districts.name_bn AS district_name_bn,
                      thana_upazilas.`name` AS upazilla_name,
                      thana_upazilas.name_bn AS upazilla_name_bn,
                      union_wards.`name` AS union_name,
                      union_wards.name_bn AS union_name_bn,
                      cc_complaint_types.name AS complaint_type,
                      cc_complaint_types.name_bn AS complaint_type_bn,
                      complaint.is_sms_notification
                    FROM
                      complaint
                      LEFT JOIN divisions
                        ON divisions.id = complaint.division_id
                      LEFT JOIN districts
                        ON districts.id = complaint.district_id
                      LEFT JOIN thana_upazilas
                        ON thana_upazilas.id = complaint.upazilla_id
                      LEFT JOIN union_wards
                        ON union_wards.id = complaint.union_id
                      LEFT JOIN cc_complaint_types
                        ON cc_complaint_types.id = complaint.complaint_type_id
                    WHERE complaint.id = :COMPLAINT_ID";

        $results = DB::select($sql, ['COMPLAINT_ID' => $id]);
        return $results;
    }
}
