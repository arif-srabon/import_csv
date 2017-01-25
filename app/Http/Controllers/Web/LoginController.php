<?php

namespace App\Http\Controllers\Web;

use App\Http\Requests\LoginRequest;
use App\Model\User\AccessLogModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class LoginController extends Controller
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
     * Display the form page for public login
     */
    public function index()
    {
        if (Sentinel::check()) {
            return redirect('dashboard');
        }
        return view('web.login');
    }


    /**
     * @param LoginRequest $request
     * @param AccessLogModel $accessLog
     * @return mixed
     */
    public function logincheck(LoginRequest $request, AccessLogModel $accessLog)
    {
        //return redirect('/dashboard');
        $credentials = [
            'email' => trim($request->input('email')),
            'password' => $request->input('password'),
        ];
        $remember = ($request->input('email') == 'yes') ? true : false;

        try {
            if ($auth = Sentinel::authenticate($credentials, $remember)) {
                //return 'auth success';
                Session::set("user_auth", $auth);
                Session::set("sess_user_id", $auth->id);
                Session::set("sess_user_desg_id", $auth->designation_id);
                Session::set("sess_user_full_name", $auth->full_name);
                Session::set("sess_user_image", $auth->user_photo);

                // save access log
                $accessLog->saveAccesslog();

                return redirect('/home');
            } else {
                throw new \Exception('Invalid username or password. Try again !!!');
            }
        } catch (Cartalyst\Sentinel\Checkpoints\ThrottlingException $ex) {
            //echo "Too many attempts!";
            return redirect()->back()
                ->withInput()
                ->withErrors("Too many attempts!");

        } catch (Cartalyst\Sentinel\Checkpoints\NotActivatedException $ex) {
            return redirect()->back()
                ->withInput()
                ->withErrors("Please activate your account before trying to log in");

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors($e->getMessage());
        }
    }

    public function logout(AccessLogModel $accessLog)
    {
        // save access log
        $accessLog->updateAccesslog();

        Sentinel::logout(null, true);
        Session::flush();
        Session::regenerate();
        return redirect('/home')
            ->header('Last-Modified', gmdate("D, d M Y H:i:s") . " GMT")
            ->header('Cache-Control', "no-store, no-cache, must-revalidate")
            ->header('Cache-Control: post-check=0, pre-check=0', false)
            ->header('Pragma', "no-cache");
    }
}
