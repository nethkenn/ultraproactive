<?php namespace App\Http\Controllers;
use DB;
use Request;
use Validator;
use Datatables;
use App\Tbl_position;

class AdminPositionController extends AdminController
{
	public function index()
	{
        return view('admin.utilities.position');
	}
	public function data()
	{
        $account = Tbl_position::select('*');
        return Datatables::of($account)	->addColumn('edit','<a href="admin/maintenance/accounts/edit?id={{$account_id}}">EDIT</a>')
        								->addColumn('archive','<a href="#" account-id="{{$account_id}}">ARCHIVE</a>')
        								->make(true);
	}
}