<?php namespace App\Http\Controllers;
use Request;
use Datatables;
use DB;
use App\Tbl_account;
use App\Tbl_admin;

class AdminAdminController extends AdminController
{
	public function index()
	{
        return view('admin.utilities.admin');
	}

    public function data()
    {
     //   $account = Tbl_account::select('*')->where('tbl_account.admin_id', Request::input('admin_id'))->leftJoin("tbl_admin","tbl_account.admin_id", "=", "tbl_admin.admin_id");
        $account = DB::table('tbl_account')
            ->join('tbl_admin','tbl_account.admin_id','=','tbl_admin.admin_id')
            ->select('tbl_admin.admin_id','account_name','account_email','admin_position_id');

        $account2 = $users = DB::table('tbl_admin')->select(['admin_id','account_id','admin_position_id']);

        $text = Request::input('archived') ? 'RESTORE' : 'ARCHIVE';
        $class = Request::input('archived') ? 'restore-account' : 'archive-account';

       // return Datatables::of($account)	->addColumn('edit','<a href="admin/maintenance/accounts/edit?id={{$account_id}}">EDIT</a>')
         //   ->addColumn('archive','<a class="'.$class.'" href="#" account-id="{{$account_id}}">'.$text.'</a>')
           // ->make(true);
        return Datatables::of($account2)->make(true);
    }
}