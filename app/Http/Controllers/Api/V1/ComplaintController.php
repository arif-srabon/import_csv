<?php

namespace App\Http\Controllers\Api\V1;

use App\Model\Api\ComplaintModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ComplaintController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'app_user_id' => 'required',
            'complaint_details' => 'required'
        ]);


        try {
            ComplaintModel::create($request->all());
            $data = ['success' => config('app_config.toastr_success'), 'title' => 'Add', 'message' => config('app_config.msg_save')];
        } catch (\Exception $e) {
            $data = ['error' => config('app_config.toastr_error'), 'title' => 'Error', 'message' => $e->getMessage()];
        }

        return $data;
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'app_user_id' => 'required',
            'complaint_details' => 'required'
        ]);

        $id = $request->input('id');
        if (empty($id)) {
            return;
        }

        try {
            $complaint = ComplaintModel::findOrFail($id);
            $complaint->update($request->all());
            $data = ['success' => config('app_config.toastr_success'), 'title' => 'Update', 'message' => config('app_config.msg_update')];

        } catch (\Exception $e) {
            $data = ['error' => config('app_config.toastr_error'), 'title' => 'Error', 'message' => $e->getMessage()];
        }

        return $data;
    }

    public function complaints($id)
    {
        $complaint = DB::table('complaint')
            ->leftJoin('cc_complaint_report_advice', 'cc_complaint_report_advice.id', '=', 'complaint.report_advice_id')
            ->leftJoin('cc_complaint_status', 'cc_complaint_status.id', '=', 'complaint.status_id')
            ->select('complaint.id AS id', 'complaint.complaint_details AS complaint_details', 'complaint.submit_date AS submit_date',
                'cc_complaint_report_advice.name AS complaint_report_advice', 'cc_complaint_status.name AS complaint_status', 'complaint.is_read')
            ->where('complaint.app_user_id', $id)
            ->orderBy('submit_date', 'desc')->get();

        return $complaint;
    }

    public function complaintsCount($id)
    {
        $complaint = DB::table('complaint')
            ->leftJoin('cc_complaint_report_advice', 'cc_complaint_report_advice.id', '=', 'complaint.report_advice_id')
            ->leftJoin('cc_complaint_status', 'cc_complaint_status.id', '=', 'complaint.status_id')
            ->where('complaint.app_user_id', '=', $id)
            ->where('complaint.is_read', '=', 0)
            ->whereNotNull('complaint.report_advice_id')
            ->count();

        return ['data' => $complaint];
    }
	
	public function notifications($id)
    {
        $complaint = DB::table('complaint')
            ->leftJoin('cc_complaint_report_advice', 'cc_complaint_report_advice.id', '=', 'complaint.report_advice_id')
            ->leftJoin('cc_complaint_status', 'cc_complaint_status.id', '=', 'complaint.status_id')
            ->select('complaint.id AS id', 'complaint.complaint_details AS complaint_details', 'complaint.submit_date AS submit_date',
                'cc_complaint_report_advice.name AS complaint_report_advice', 'cc_complaint_status.name AS complaint_status', 'complaint.is_read')
            ->where('complaint.app_user_id', $id)
			->whereNotNull('complaint.report_advice_id')
            ->orderBy('submit_date', 'desc')->get();

        return $complaint;
    }
	
	public function complaintByDate($date,$id)
    {
        $complaint = DB::table('complaint')
            ->leftJoin('cc_complaint_report_advice', 'cc_complaint_report_advice.id', '=', 'complaint.report_advice_id')
            ->leftJoin('cc_complaint_status', 'cc_complaint_status.id', '=', 'complaint.status_id')
            ->select('complaint.id AS id', 'complaint.complaint_details AS complaint_details', 'complaint.submit_date AS submit_date',
                'cc_complaint_report_advice.name AS complaint_report_advice', 'cc_complaint_status.name AS complaint_status', 'complaint.is_read')
            ->where('complaint.app_user_id', $id)
			->where('complaint.submit_date', $date)
            ->orderBy('submit_date', 'desc')->get();

        return $complaint;
    }

}
