<?php namespace App\Http\Controllers;
use Request;
use Redirect;
use App\Tbl_membership;
use App\Tbl_binary_pairing;

class AdminComplanController extends AdminController
{
	public function index()
	{
        return view('admin.utilities.complan');
	}
	public function binary()
	{
		$data["_membership"] = Tbl_membership::active()->entry()->get();
		$data["_pairing"] = Tbl_binary_pairing::get();
		return view('admin.computation.binary', $data);
	}
	public function binary_add()
	{
		if(Request::isMethod("post"))
		{
			$insert["pairing_point_l"] = Request::input("pairing_points_l");
			$insert["pairing_point_r"] = Request::input("pairing_points_r");
			$insert["pairing_income"] = Request::input("pairing_income");
			Tbl_binary_pairing::insert($insert);
			return Redirect::to('/admin/utilities/binary');
		}
		else
		{
			return view('admin.computation.binary_add');	
		}
	}
	public function binary_edit()
	{
		return view('admin.computation.binary_edit');
	}
	public function binary_membership_edit()
	{
	}
}