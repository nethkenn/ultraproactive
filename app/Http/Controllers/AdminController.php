<?php namespace App\Http\Controllers;
use Request;
use App\Tbl_account;
use App\Tbl_admin;
use DB;

class AdminController extends Controller
{
	public function __construct()
	{
	}
	public function index()
	{
        return view('admin.dashboard.dashboard');
       // return "me";
	}

    /**
     * admin login
     */
    public function postLogin()
    {
        //check credentials in the database
        $input['username'] = Request::input("username");
        $input['password'] = Request::input("password");
     //   $account = Tbl_admin::find(1);
        $account = DB::table('tbl_account')
            ->join('tbl_admin','tbl_account.admin_id','=','tbl_admin.admin_id')
            ->select('tbl_admin.admin_id','account_name','account_email','admin_position_id')->get();
        return $account;
    }
}