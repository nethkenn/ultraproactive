<?php namespace App\Http\Controllers;
use Request;
use Redirect;
use App\Tbl_membership;
use App\Tbl_binary_pairing;
use App\Tbl_product;
use App\Tbl_indirect_setting;
use App\Tbl_unilevel_setting;
use App\Tbl_slot;
use App\Classes\Compute;
use DB;


class AdminComplanController extends AdminController
{
	public function index()
	{
        return view('admin.utilities.complan');
	}
	public function binary()
	{
		$data["_membership"] = Tbl_membership::active()->entry()->get();
		$data["_entry"] = Tbl_membership::active()->join('tbl_binary_pairing','tbl_binary_pairing.membership_id','=','tbl_membership.membership_id')
												  ->groupBy('tbl_binary_pairing.membership_id')
												  ->selectRaw('tbl_membership.membership_id, tbl_membership.membership_id')
												  ->selectRaw('count(*) as count, tbl_binary_pairing.membership_id')
												  ->selectRaw('tbl_membership.membership_name, tbl_membership.membership_name')
												  ->entry()
												  ->get();
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
			$insert["membership_id"] = Request::input("membership");
			Tbl_binary_pairing::insert($insert);
			return Redirect::to('/admin/utilities/binary/membership/binary/edit?id='.Request::input('membership'));
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
			return Redirect::to('/admin/utilities/binary/membership/binary/edit?id='.Request::input('membership'));
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
		return Redirect::to('/admin/utilities/binary/membership/binary/edit?id='.Request::input('membership'));
	}
	public function binary_membership_edit()
	{
		if(Request::isMethod("post"))
		{
			$update["membership_binary_points"] = Request::input("membership_binary_points");
			$update["max_pairs_per_day"] = Request::input("max");
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

	public function direct()
	{
		$data["_membership"] = Tbl_membership::active()->get();
		return view('admin.computation.direct', $data);
	}
	public function direct_edit()
	{
		if(Request::isMethod("post"))
		{
			$update["membership_direct_sponsorship_bonus"] = Request::input("membership_direct_sponsorship_bonus");
			Tbl_membership::where("membership_id", Request::input("id"))->update($update);
			return Redirect::to('/admin/utilities/direct');
		}
		else
		{
			$data["data"] = Tbl_membership::where("membership_id", Request::input("id"))->first();
			return view('admin.computation.direct_edit', $data);	
		}
	}
	public function indirect()
	{
		$data["_membership"] = Tbl_membership::active()->get();
		return view('admin.computation.indirect', $data);
	}
	public function indirect_edit()
	{
		if(Request::isMethod("post"))
		{
			$update["membership_indirect_level"] = Request::input("membership_indirect_level");
			Tbl_membership::where("membership_id", Request::input("id"))->update($update);

			$ctr = 0;
			Tbl_indirect_setting::where("membership_id", Request::input("id"))->delete();
			foreach(Request::input("level") as $level => $value)
			{
				$insert[$ctr]["level"] = $level;
				$insert[$ctr]["value"] = $value;
				$insert[$ctr]["membership_id"] = Request::input("id");
				$ctr++;
			}
			Tbl_indirect_setting::insert($insert);

			return Redirect::to('/admin/utilities/indirect');
		}
		else
		{
			$data["data"] = Tbl_membership::where("membership_id", Request::input("id"))->first();
			$data["_level"] = Tbl_indirect_setting::where("membership_id", Request::input("id"))->get();
			return view('admin.computation.indirect_edit', $data);	
		}
	}
	public function matching()
	{
		$data["_membership"] = Tbl_membership::active()->get();
		return view('admin.computation.matching', $data);
	}
	public function matching_edit()
	{
		if(Request::isMethod("post"))
		{
			$update["membership_matching_bonus"] = Request::input("membership_matching_bonus");
			Tbl_membership::where("membership_id", Request::input("id"))->update($update);
			return Redirect::to('/admin/utilities/matching');
		}
		else
		{
			$data["data"] = Tbl_membership::where("membership_id", Request::input("id"))->first();
			return view('admin.computation.matching_edit', $data);	
		}
	}
	public function unilevel()
	{
		$data["_membership"] = Tbl_membership::active()->get();
		return view('admin.computation.unilevel', $data);
	}
	public function unilevel_edit()
	{
		if(Request::isMethod("post"))
		{
			$update["membership_repurchase_level"] = Request::input("membership_repurchase_level");
			$update["membership_required_pv"] = Request::input("membership_required_pv");
			$update["multiplier"] = Request::input("multiplier");
			Tbl_membership::where("membership_id", Request::input("id"))->update($update);

			$ctr = 0;
			Tbl_unilevel_setting::where("membership_id", Request::input("id"))->delete();

			foreach(Request::input("level") as $level => $value)
			{
				$insert[$ctr]["level"] = $level;
				$insert[$ctr]["value"] = $value;
				$insert[$ctr]["membership_id"] = Request::input("id");
				$ctr++;
			}

			Tbl_unilevel_setting::insert($insert);

			return Redirect::to('/admin/utilities/unilevel');
		}
		else
		{
			$data["data"] = Tbl_membership::where("membership_id", Request::input("id"))->first();
			$data["_level"] = Tbl_unilevel_setting::where("membership_id", Request::input("id"))->get();
			return view('admin.computation.unilevel_edit', $data);	
		}
	}
	public function rank()
	{
		$data["_membership"] = Tbl_membership::active()->get();
		return view('admin.computation.rank', $data);
	}
	public function rank_edit()
	{
		if(Request::isMethod("post"))
		{
			$update["membership_required_upgrade"] = Request::input("membership_required_upgrade");
			$update["upgrade_via_points"] = Request::input("upgrade_via_points");
			Tbl_membership::where("membership_id", Request::input("id"))->update($update);
			return Redirect::to('/admin/utilities/rank');
		}
		else
		{
			$data["data"] = Tbl_membership::where("membership_id", Request::input("id"))->first();
			return view('admin.computation.rank_edit', $data);	
		}
	}
	public function recompute()
	{

		echo base64_decode("/wEdAAZrrO8aGTCCus/TZdechI3DVas/k2InBMdmWIvDoWXbxc2tOHisUnaEBsHG08XGrcn2ey+ClwVUuCLirNvBH1XQhrLGxMrn4FQpOnM3xdjwVvU8JWd5KFnnFaHYbyhbG4W4+gXph+J+x6Zg4UgKHR3RRuxouoDxWuvWuu+k84Jgxg==");


		if(Request::input("action") == "")
		{
			$data["_account"] = Tbl_slot::orderBy("slot_id", "asc")	->rank()
																	->membership()
																	->account()
																	->where("membership_id", 5)
																	->get();
			return view("admin.computation.recomputation", $data);
		}
		elseif(Request::input("action") == "initialize")
		{
			DB::table('tbl_tree_placement')->delete();
			DB::table('tbl_tree_sponsor')->delete();
			echo json_encode("success");
		}
		elseif(Request::input("action") == "compute")
		{
			Compute::tree(Request::input("slot_id"));
			echo json_encode("success");
		}
	}
	public function binary_entry()
	{
		$data["_pairing"] = Tbl_binary_pairing::where('membership_id',Request::input("id"))->get();
		return view('admin.computation.binary_entry', $data);	
	}
}