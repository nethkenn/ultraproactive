<?php namespace App\Http\Controllers;
use App\Tbl_membership;

class AdminComplanController extends AdminController
{
	public function index()
	{
        return view('admin.utilities.complan');
	}
	public function binary()
	{
		$data["_membership"] = Tbl_membership::active()->entry()->get();
		return view('admin.computation.binary', $data);
	}
}