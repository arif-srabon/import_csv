<?php
namespace App\Model\Web;

use Cache;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ComplaintModel extends Model
{
	protected $table = 'complaint';

	protected $fillable = [
        'complaint_type_id',
        'complaint_details',
        'repoter_title',
        'full_name',
        'profession',
        'district_id',
        'upazilla_id',
        'union_id',
        'address',
        'postcode',
        'email',
        'phone',
        'submit_date',
        'status_id',
        'is_sms_notification'
    ];

}
