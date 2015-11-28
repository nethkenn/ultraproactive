<?php namespace App\Http\Controllers;
use DB;
use Request;
use Redirect;
use App\Classes\Admin;
use App\Classes\Log;
class AdminLoginController extends Controller
{
    public function index()
    {
        $data['_error'] = null;
        
        
        if(isset($_POST['username']))
        {
            $admin = Admin::authenticate(Request::input('username'), Request::input('password'));
            if($admin)
            {
                Admin::login($admin->account_username, Request::input('password'));
                Log::Admin($admin->account_id,$admin->account_username." Logged in");
                return Redirect::to("admin");
            }
            else
            {
                $data['_error'] = "Username or password is incorrect.";
            }
        }


        return view('admin.login', $data);
    }


    public function login()
    {
        // dd();


    }
    public function hack()
    {
 
    }
}