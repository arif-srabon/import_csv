<?php

namespace App\Http\Controllers;

use App\Model\Dashboard\DashboardModel;
use App\Model\User\UserModel;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class DashboardController extends Controller
{
    public $lang;

    public function __construct()
    {
        $this->middleware('auth');
        $this->lang = Session::get("locale");
        if (!isset($this->lang)) {
            $this->lang = config('app.locale');
        }
    }

    public function index()
    {
        return view('dashboard_blank');
    }



}
