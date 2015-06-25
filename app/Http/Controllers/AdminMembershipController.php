<?php namespace App\Http\Controllers;
use DB;
use Request;
use Redirect;
use Carbon;
use Datatables;
use App\Tbl_membership;

class AdminMembershipController extends AdminController
{
	public function index()
	{
        return view('admin.maintenance.membership');
	}
	public function data()
	{
        $account = Tbl_membership::select('*');
        return Datatables::of($account)	->addColumn('edit','<a href="admin/maintenance/accounts/edit?id={{$membership_id}}">EDIT</a>')
        								->addColumn('archive','<a href="admin/maintenance/accounts/archive?id={{$membership_id}}">ARCHIVE</a>')
        								->make(true);		
	}
	public function add()
	{
		return view('admin.maintenance.membership_add');
	}
}