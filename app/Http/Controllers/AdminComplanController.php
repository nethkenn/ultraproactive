<?php namespace App\Http\Controllers;
use Request;
use Redirect;
use App\Tbl_membership;
use App\Tbl_binary_pairing;
use App\Tbl_product;

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
		$data["_product"] = Tbl_product::active()->get();
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
		if(Request::isMethod("post"))
		{
			$update["pairing_point_l"] = Request::input("pairing_points_l");
			$update["pairing_point_r"] = Request::input("pairing_points_r");
			$update["pairing_income"] = Request::input("pairing_income");
			Tbl_binary_pairing::where("pairing_id", Request::input("id"))->update($update);
			return Redirect::to('/admin/utilities/binary');
		}
		else
		{
			$data["data"] = Tbl_binary_pairing::where("pairing_id", Request::input("id"))->first();
			return view('admin.computation.binary_edit', $data);	
		}
	}
	public function binary_delete()
	{
		Tbl_binary_pairing::where("pairing_id", Request::input("id"))->delete();
		return Redirect::to('/admin/utilities/binary');
	}
	public function binary_membership_edit()
	{
		if(Request::isMethod("post"))
		{
			$update["membership_binary_points"] = Request::input("membership_binary_points");
			Tbl_membership::where("membership_id", Request::input("id"))->update($update);
			return Redirect::to('/admin/utilities/binary');
		}
		else
		{
			$data["data"] = Tbl_membership::where("membership_id", Request::input("id"))->first();
			return view('admin.computation.binary_membership_edit', $data);	
		}

	}
	public function binary_product_edit()
	{
		if(Request::isMethod("post"))
		{
			$update["binary_pts"] = Request::input("binary_pts");
			Tbl_product::where("product_id", Request::input("id"))->update($update);
			return Redirect::to('/admin/utilities/binary');
		}
		else
		{
			$data["data"] = Tbl_product::where("product_id", Request::input("id"))->first();
			return view('admin.computation.binary_product_edit', $data);
		}	
	}
}