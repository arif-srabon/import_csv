<?php

namespace App\Http\Controllers\Web;

use App\Http\Requests\RegisterRequest;
use App\Model\Setup\DistrictModel;
use App\Model\Setup\ThanaUpazillaModel;
use App\Model\Setup\UnionWardModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Model\Setup\ThanaUpazillaModel as ThanaUpazilla;
use App\Model\Setup\UnionWardModel as UnionWard;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Validator;
use Response;
use App\Model\User\UserModel as User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public $lang;

    public function __construct()
    {
        $this->lang = Session::get("locale");
        if (!isset($this->lang)) {
            $this->lang = config('app.locale');
        }
    }

    /**
     * Display the form page for public registration
     */
    public function index()
    {
        /**
         * Load necessary assets specific to this UI
         */
        \Assets::add([
                'plugins/bootstrap3-typeahead.min.js'
            ]);

        $district = DistrictModel::lists('name', 'id');

        return view('web.register', compact('district'));
    }

    public function store(RegisterRequest $request)
    {
        try {
            $user = $this->_registerUser($request);
            $userInfo = User::findOrFail($user->id);
            $userInfo->update($request->all());

            // save user roles
            // web_user_role
            $userRoleIds[] = config('app_config.web_user_role');
            if (is_array($userRoleIds) && count($userRoleIds)) {
                $user->roles()->sync($userRoleIds);
            }

            return redirect('register')->with('successMsg', 'Register successfully');

        } catch (\Exception $e) {
            return redirect('register')
                ->with('dangerMsg', $e->getMessage());
        }

    }

    private function _registerUser($request)
    {
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        // check user activation status
        $activation = true;

        if ($user = Sentinel::register($credentials, $activation)) {
            return $user;
        }
        return false;
    }

    public function getThanaUpazillaByDistrict($districtId = null)
    {
        $disId = $districtId;
        if ($this->lang == "en") {
            $thanaUpazillas = ThanaUpazilla::where('district_id', '=', $disId)
                ->orderBy('name', 'asc')->select('name AS name', 'id')
                ->get();
        } else {
            $thanaUpazillas = ThanaUpazilla::where('district_id', '=', $disId)
                ->orderBy('name', 'asc')->select('name_bn AS name', 'id')
                ->get();
        }

        return Response::json($thanaUpazillas);
    }

    public function getUnionByThana($thanaUpazillaId = null)
    {
        $thanaId = $thanaUpazillaId;

        if ($this->lang == "en") {
            $unions = UnionWard::where('thana_upazila_id', '=', $thanaId)
                ->where('location_type_id' , '=',1)
                ->orderBy('name', 'asc')->select('name AS name','id')
                ->get();
        } else{
            $unions = UnionWard::where('thana_upazila_id', '=', $thanaId)
                ->where('location_type_id' , '=',1)
                ->orderBy('name', 'asc')->select('name_bn AS name','id')
                ->get();
        }
        return Response::json($unions);
    }

    public function changepassword()
    {
        return view('web.changepassword');
    }

    public function updatePasswd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|min:5',
            'password' => 'required|min:5|confirmed',
            'password_confirmation' => 'required|min:5',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput()
                ->withErrors($validator);
        }

        // change password
        try {
            $hasher = Sentinel::getHasher();

            $oldPassword = $request->input('old_password');
            $password = $request->input('password');
            $passwordConf = $request->input('password_confirmation');

            $user = Sentinel::getUser();

            if (!$hasher->check($oldPassword, $user->password) || $password != $passwordConf) {
                throw new \Exception('Old Password does not match. Try again !!!');
            }

            Sentinel::update($user, array('password' => $password));

            return redirect('change-password')->with('successMsg', config('app_config.msg_update'));

        } catch (\Exception $e) {

            return redirect("change-password")->with('dangerMsg', $e->getMessage());
        }
    }

    public function edit()
    {
        $id = Session::get("sess_user_id");
        $user = User::findOrFail($id);

        if ($this->lang == 'bn') {
            $name = 'name_bn';
        } else {
            $name = 'name';
        }

        $data['district'] = DistrictModel::lists($name, 'id');
        $data['upazilla'] = ThanaUpazillaModel::where('district_id', $user->district_id)->lists($name, 'id');
        $data['union']    = UnionWardModel::where('thana_upazila_id', $user->upazilla_id)->lists($name, 'id');

        return view('web.myprofile', compact('user'))->with($data);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|min:2|unique:users,email,'.$request->id,
            'full_name' => 'required|min:5',
            'profession'  => 'required|min:2',
            'mobile'  => 'required|min:6',
            'district_id'=> 'required|integer',
            'upazilla_id'=> 'required|integer',
            'address'  => 'required|min:3',
        ]);

        $id = Session::get("sess_user_id");

        try {
            $user = User::findOrFail($id);
            $user->updated_by = Session::get('sess_user_id');
            $user->update($request->all());
            return redirect("myprofile")->with('successMsg', config('app_config.msg_update'));
        } catch (\Exception $e) {
            return redirect("myprofile")
                ->with('dangerMsg', config('app_config.msg_failed_update'));
        }
    }


    /**
     * AutoComplete
     * @param  string $table  Table name.
     * @param  string $select Field name to select.
     * @param  string $string String to search.
     * @return array          One dimensional array.
     * ---------------------------------------------------------------------
     */
    private function autocomplete($table, $select, $string) {
        // get original model
        $fetchMode = DB::getFetchMode();

        // set mode to fetch associative arrays instead of objects
        DB::setFetchMode(\PDO::FETCH_ASSOC);

        $fetched_data = DB::table($table)
                            ->select($select)
                            ->where($select, 'like', "%$string%")
                            ->limit(10)
                            ->get();

        // restore mode the original
        DB::setFetchMode($fetchMode);        

        $collection = collect($fetched_data);
        $collapsed  = $collection->flatten(); //flatten them to one dimensional array
        $values     = $collapsed->all();

        return $values;
    }


    /**
     * AutoComplete : Profession
     * ---------------------------------------------------------------------
     */
    public function autoProfession(Request $request) {
        $search = $request->input('search');

        return $this->autocomplete( 'cc_profession', 'name', $search );
    }

}
