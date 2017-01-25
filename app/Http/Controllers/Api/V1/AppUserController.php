<?php

namespace App\Http\Controllers\Api\V1;

use App\Model\Api\AppuserModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AppUserController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
        ]);

        try {

            $user = AppuserModel::create($request->all());
            $data = ['success' => config('app_config.toastr_success'), 'title' => 'Add', 'message' => config('app_config.msg_save'), 'user_id' => $user->id];

        } catch (\Exception $e) {
            $data = ['error' => config('app_config.toastr_error'), 'title' => 'Error', 'message' => $e->getMessage()];
        }

        return $data;
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
        ]);


        $id = $request->input('id');
        if(empty($id)) {
            return;
        }

        try
        {
            $appUser = AppuserModel::findOrFail($id);
            $appUser->update($request->all());
            $data = ['success' => config('app_config.toastr_success'), 'title' => 'Update', 'message' => config('app_config.msg_update')];

        } catch (\Exception $e) {
            $data = ['error' => config('app_config.toastr_error'), 'title' => 'Error', 'message' => $e->getMessage()];
        }

        return $data;
    }

    public function userInfo($id)
    {
        $user = AppuserModel::where('id', $id)->get();
        return ['data' => $user];
    }
}
