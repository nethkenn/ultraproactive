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
        $account = Tbl_account::select('*') ->join('tbl_admin','tbl_account.account_id','=','tbl_admin.account_id')
                                            ->join('tbl_admin_position','tbl_admin_position.admin_position_id','=','tbl_admin.admin_position_id');
        $text = Request::input('archived') ? 'RESTORE' : 'ARCHIVE';
        $class = Request::input('archived') ? 'restore-account' : 'archive-account';

       // return Datatables::of($account)	->addColumn('edit','<a href="admin/maintenance/accounts/edit?id={{$account_id}}">EDIT</a>')
         //   ->addColumn('archive','<a class="'.$class.'" href="#" account-id="{{$account_id}}">'.$text.'</a>')
           // ->make(true);
        return Datatables::of($account)->make(true);
    }
}