<?php namespace App\Http\Controllers;
use DB;
use Request;
use Redirect;
use Carbon;
use Datatables;
use App\Tbl_rank;

class AdminRankingController extends AdminController
{
	public function index()
	{
        return view('admin.maintenance.ranking');
	}
	public function data()
	{
        $account = Tbl_rank::select('*');
        return Datatables::of($account)	->addColumn('edit','<a href="admin/maintenance/accounts/edit?id={{$rank_id}}">EDIT</a>')
        								->addColumn('archive','<a href="admin/maintenance/accounts/archive?id={{$rank_id}}">ARCHIVE</a>')
        								->make(true);		
	}
}