<?php namespace App\Http\Controllers;
use DB;
use Request;
use Redirect;
use App\Classes\Admin;
use App\Classes\Log;
use Crypt;

class AdminLoginController extends Controller
{
    public function index()
    {
        // dd(Crypt::decrypt("eyJpdiI6IjdFXC9HRGViVnhxdWtTcll0M3ZXZ21nPT0iLCJ2YWx1ZSI6ImZOVklNMDh0cGc3bVFxa3pkUmtlR0F5MUhcL1JuaENiTkh0aWt2b0wyaWJZPSIsIm1hYyI6IjNhYWNjMTc2OGY2M2QwNzU5ODhjMWU0OWY5MzQ5NjRkMGI4ODQ0MTk3M2MxYjgyYjNjNjNkZDA0MjM2YWNmODIifQ=="));
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