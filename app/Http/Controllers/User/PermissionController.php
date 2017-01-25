<?php

namespace App\Http\Controllers\User;

use App\Model\User\PermissionModel;
use App\Model\User\RoleModel;
use App\Model\User\UserModel;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use mjanssen\BreadcrumbsBundle\Breadcrumbs;
use narutimateum\Toastr\Facades\Toastr;

class PermissionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        \Assets::add([
            'plugins/forms/styling/uniform.min.js',
            'app/permission_validation.js'
        ]);

        // breadcrumbs
        Breadcrumbs::addBreadcrumb(trans('users/permission.breadcrumb1'), '/role');
        Breadcrumbs::addBreadcrumb(trans('users/permission.breadcrumb2'), '/role');
        Breadcrumbs::addBreadcrumb(trans('users/permission.breadcrumb3'), '#');

        $data['modules'] = PermissionModel::orderBy('weight', 'desc')->distinct()->pluck('module');
        $data['role'] = $role = RoleModel::findOrFail($id);
        $data['flag'] = "role";

        $appliedPermission = (array)json_decode($role->permissions);
        $data['appliedPermissions'] = array_keys($appliedPermission);

        return view('user.role.premission', $data)->with('permission', new PermissionModel);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->input('id');
        try {
            $chkPermission = $request->all()['chkPermission'];
            // align permission to Sentinel
            $permissions = array();
            foreach ($chkPermission as $key => $value) {
                $permissions[$value] = true;
            }
            // update role permissions
            $role = Sentinel::findRoleById($id);
            $role->permissions = $permissions;
            $role->save();

            Toastr::success(config('app_config.msg_update'), "Update", $options = []);

            return redirect("permission/$id/edit");

        } catch (\Exception $e) {

            Toastr::error(config('app_config.msg_failed_update'), "Update Failed", $options = []);

            return redirect("permission/$id/edit")
                ->with('dangerMsg', $e->getMessage());
        }
    }


    public function editUserPermission($id)
    {
        \Assets::add([
            'plugins/forms/styling/uniform.min.js',
            'app/permission_validation.js'
        ]);

        // breadcrumbs
        Breadcrumbs::addBreadcrumb(trans('users/permission.breadcrumb1'), '/role');
        Breadcrumbs::addBreadcrumb(trans('users/permission.breadcrumb2'), '/role');
        Breadcrumbs::addBreadcrumb(trans('users/permission.breadcrumb3'), '#');

        $data['modules'] = PermissionModel::orderBy('weight', 'desc')->distinct()->pluck('module');
        $data['role'] = $user = UserModel::findOrFail($id);
        $data['flag'] = "user";

        ///////////////////////
        $appliedPermissions = $this->_getUserAllRolesPermissions($user);
        //  echo "<br>User All Roles Permission<br>";
        // dump($appliedPermissions);
        // get user assigned permissions
        $userAppliedPermissions = (array)json_decode($user->permissions);
        //echo "<br>User Permission<br>";
        // dump($userAppliedPermissions);

        $appliedPermissions = array_merge($appliedPermissions, $userAppliedPermissions);
        // unset all false permissions
        foreach ($appliedPermissions as $key => $value) {
            if ($value == false) {
                unset($appliedPermissions[$key]);
            }
        }

        //dd($appliedPermissions);
        $data['appliedPermissions'] = array_keys($appliedPermissions);
        //////////////////////

        return view('user.role.premission', $data)->with('permission', new PermissionModel);;
    }


    public function updateUserPermssion(Request $request)
    {
        $id = $request->input('id');
        try {
            $chkPermission = $request->all()['chkPermission'];
            // align permission to Sentinel
            $permissions = array();
            foreach ($chkPermission as $key => $value) {
                $permissions[$value] = true;
            }
            //echo "<br>User Permission<br>";
            //dump($permissions);

            $user = UserModel::findOrFail($id);
            $appliedPermissions = $this->_getUserAllRolesPermissions($user);
            // echo "<br>User All Roles Permission<br>";
            //dump($appliedPermissions);

            $deny = array_diff_assoc($appliedPermissions, $permissions);
            // echo "<br>Deny Permission<br>";
            // dump($deny);

            array_walk($deny, function ($value, $key) use (&$deny) {
                $deny[$key] = false;
            });
            // echo "<br>Deny Permission - false<br>";
            //dump($deny);

            // echo "<br>Final Permissions<br>";
            $finalPermissions = array_merge($permissions, $deny);
            //dd($finalPermissions);

            // update user permissions
            $user = Sentinel::findById($id);
            $user->permissions = $finalPermissions;
            $user->save();

            Toastr::success(config('app_config.msg_update'), "Update", $options = []);

            return redirect("userpermission/$id/edit");

        } catch (\Exception $e) {

            Toastr::error(config('app_config.msg_failed_update'), "Update Failed", $options = []);

            return redirect("userpermission/$id/edit")
                ->with('dangerMsg', $e->getMessage());
        }
    }

    /**
     * @param $user
     * @param $data
     * @return mixed
     */
    private function _getUserAllRolesPermissions($user)
    {
        // get user all assigned roles permissions
        $userRoles = $user->assigned_roles_list->toArray();
        //dump($userRoles);
        $roles = Sentinel::getRoleRepository()->createModel()->whereIn('id', $userRoles)->get();
        $appliedPermissions = [];
        foreach ($roles as $role) {
            $appliedPermissions = array_merge($role->permissions, $appliedPermissions);
        }
        //dump($appliedPermissions);
        return $appliedPermissions;
    }


}
