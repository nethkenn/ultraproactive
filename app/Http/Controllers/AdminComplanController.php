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
use App\Tbl_matching_bonus;
use App\Tbl_unilevel_check_match;
use App\Classes\Log;
use App\Tbl_tree_sponsor;
use App\Tbl_travel_reward;
use Validator;
use App\Tbl_travel_qualification;
use App\Tbl_compensation_rank;
use App\Classes\Admin;

class AdminComplanController extends AdminController
{
	public function index()
	{
        return view('admin.utilities.complan');
	}
	public function binary()
	{
		$data["_membership"] = Tbl_membership::active()->entry()->get();
		$data["_membership_pairs"] = Tbl_membership::active()->get();

		foreach($data['_membership_pairs'] as $key => $d)
		{
			$data['_membership_pairs'][$key]->count = DB::table('tbl_binary_pairing')->where('membership_id',$d->membership_id)->count();
		}

		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits Binary Computation");
		
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
			$id = Tbl_binary_pairing::insertGetId($insert);

			$new = DB::table('tbl_binary_pairing')->where('pairing_id',$id)->first();

			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." Add a Binary Computation Id #".$id,null,serialize($new));

			return Redirect::to('/admin/utilities/binary/membership/binary/edit?id='.Request::input('membership'));
		}
		else
		{
			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits Add Binary Computation Membership Id #".Request::input('membership'));
			return view('admin.computation.binary_add');	
		}
	}
	public function binary_edit()
	{
		if(Request::isMethod("post"))
		{
			$old = DB::table('tbl_binary_pairing')->where('pairing_id',Request::input("id"))->first();
			$update["pairing_point_l"] = Request::input("pairing_points_l");
			$update["pairing_point_r"] = Request::input("pairing_points_r");
			$update["pairing_income"] = Request::input("pairing_income");
			Tbl_binary_pairing::where("pairing_id", Request::input("id"))->update($update);
			$new = DB::table('tbl_binary_pairing')->where('pairing_id',Request::input("id"))->first();

			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." edit a Binary Computation Id #".Request::input('id'),serialize($old),serialize($new));

			return Redirect::to('/admin/utilities/binary/membership/binary/edit?id='.Request::input('membership'));
		}
		else
		{
			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits Edit Binary Computation Id #".Request::input("id"));
			$data["data"] = Tbl_binary_pairing::where("pairing_id", Request::input("id"))->first();
			return view('admin.computation.binary_edit', $data);	
		}
	}
	public function binary_delete()
	{
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." delete a Binary Computation Id #".Request::input('id'));
		Tbl_binary_pairing::where("pairing_id", Request::input("id"))->delete();
		return Redirect::to('/admin/utilities/binary/membership/binary/edit?id='.Request::input('membership'));
	}
	public function binary_membership_edit()
	{
		if(Request::isMethod("post"))
		{
			$old = DB::table('tbl_membership')->where('membership_id',Request::input('id'))->first();
			$update["membership_binary_points"] = Request::input("membership_binary_points");
			Tbl_membership::where("membership_id", Request::input("id"))->update($update);
			$new = DB::table('tbl_membership')->where('membership_id',Request::input('id'))->first();
			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." edit a Binary Points Membership Id #".Request::input('id'),serialize($old),serialize($new));
			return Redirect::to('/admin/utilities/binary');
		}
		else
		{
			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits Binary Points Membership Id #".Request::input('id'));
			$data["data"] = Tbl_membership::where("membership_id", Request::input("id"))->first();
			return view('admin.computation.binary_membership_edit', $data);	
		}
	}
	public function binary_product_edit()
	{
		if(Request::isMethod("post"))
		{
			$old = DB::table('tbl_product')->where('product_id',Request::input('id'))->first();
			$update["binary_pts"] = Request::input("binary_pts");
			Tbl_product::where("product_id", Request::input("id"))->update($update);
			$new = DB::table('tbl_product')->where('product_id',Request::input('id'))->first();
			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." edit a Product Binary Points Product Id #".Request::input('id'),serialize($old),serialize($new));
			return Redirect::to('/admin/utilities/binary');
		}
		else
		{
			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits Product Binary Points Product Id #".Request::input('id'));
			$data["data"] = Tbl_product::where("product_id", Request::input("id"))->first();
			return view('admin.computation.binary_product_edit', $data);
		}	
	}

	public function direct()
	{
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits DIRECT SPONSOR BONUS PER MEMBERSHIP");
		$data["_membership"] = Tbl_membership::active()->get();
		return view('admin.computation.direct', $data);
	}
	public function direct_edit()
	{
		if(Request::isMethod("post"))
		{
			$old = DB::table('tbl_membership')->where('membership_id',Request::input('id'))->first();

			$number = preg_replace("/[^A-Za-z0-9 ]/", '', Request::input("membership_direct_sponsorship_bonus"));
			$update["membership_direct_sponsorship_bonus"] = $number;
			$string = preg_replace('/\s+/', '', Request::input("membership_direct_sponsorship_bonus"));
			$percentage = substr($string, -1);
			if($percentage == "%")
			{
				$update["if_matching_percentage"] = 1;
			}
			else
			{
				$update["if_matching_percentage"] = 0;
			}
			Tbl_membership::where("membership_id", Request::input("id"))->update($update);

			$new = DB::table('tbl_membership')->where('membership_id',Request::input('id'))->first();

			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." edit a DIRECT SPONSORSHIP BONUS / UPDATE MEMBERSHIP ID #".Request::input('id'),serialize($old),serialize($new));
			
			return Redirect::to('/admin/utilities/direct');
		}
		else
		{
			$data["data"] = Tbl_membership::where("membership_id", Request::input("id"))->first();
			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits EDIT DIRECT SPONSOR BONUS PER MEMBERSHIP ID #".Request::input('id'));
			return view('admin.computation.direct_edit', $data);	
		}
	}
	public function indirect()
	{
		$data["_membership"] = Tbl_membership::active()->get();
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits INDIRECT LEVEL BONUS PER MEMBERSHIP");
		return view('admin.computation.indirect', $data);
	}
	public function indirect_edit()
	{
		if(Request::isMethod("post"))
		{
			$update["membership_indirect_level"] = Request::input("membership_indirect_level");
			Tbl_membership::where("membership_id", Request::input("id"))->update($update);
			$old = DB::table('tbl_indirect_setting')->where('membership_id',Request::input('id'))->get();
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

			$new = DB::table('tbl_indirect_setting')->where('membership_id',Request::input('id'))->get();

			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." edit INDIRECT LEVEL BONUS / UPDATE / MEMBERSHIP ID #".Request::input('id'),serialize($old),serialize($new));
			return Redirect::to('/admin/utilities/indirect');
		}
		else
		{

			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits EDIT INDIRECT LEVEL BONUS / UPDATE / MEMBERSHIP ID #".Request::input('id'));
			$data["data"] = Tbl_membership::where("membership_id", Request::input("id"))->first();
			$data["_level"] = Tbl_indirect_setting::where("membership_id", Request::input("id"))->get();
			return view('admin.computation.indirect_edit', $data);	
		}
	}

	public function travel_reward()
	{
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits TRAVEL REWARD");
		if(Request::input('status') == "archived")
		{
			$data["_reward"] = Tbl_travel_reward::where('archived',1)->get();
		}
		else
		{
			$data["_reward"] = Tbl_travel_reward::where('archived',0)->get();
		}

		return view('admin.computation.travel_reward', $data);
	}

	public function travel_reward_edit()
	{
		$data['_error'] = null;
		$data['data'] = Tbl_travel_reward::where('travel_reward_id',Request::input('id'))->first();
		if(Request::isMethod("post"))
		{
				$rules['travel_reward_name'] = 'required|unique:tbl_membership,membership_name|regex:/^[A-Za-z0-9\s-_]+$/';
				$rules['required_points'] = 'numeric|min:1';
				$validator = Validator::make(Request::input(),$rules);
				if (!$validator->fails())
				{
					$old = DB::table('tbl_travel_reward')->where('travel_reward_id',Request::input('id'))->first();

					$update['travel_reward_name'] = Request::input('travel_reward_name');
					$update['required_points'] = Request::input('required_points');
					Tbl_travel_reward::where('travel_reward_id',Request::input('id'))->update($update);	

					$new = DB::table('tbl_travel_reward')->where('travel_reward_id',Request::input('id'))->first();

					Log::Admin(Admin::info()->account_id,Admin::info()->account_username." edit EDIT REWARD ID #".Request::input('id'),serialize($old),serialize($new));	
					return Redirect::to('/admin/utilities/travel_reward');
				}
				else
				{	
					$errors =  $validator->errors();
					$data['_error']['travel_reward_name'] = $errors->get('travel_reward_name');
					$data['_error']['required_points'] = $errors->get('required_points');
				}			
		}
		else
		{
			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits EDIT REWARD ID #".Request::input('id'));
		}

		return view('admin.computation.travel_reward_edit',$data);	
	}

	public function travel_reward_add()
	{	
		$data['_error'] = null;
		if(Request::isMethod("post"))
		{
				$rules['travel_reward_name'] = 'required|unique:tbl_membership,membership_name|regex:/^[A-Za-z0-9\s-_]+$/';
				$rules['required_points'] = 'numeric|min:1';
				$validator = Validator::make(Request::input(),$rules);
				if (!$validator->fails())
				{

					$insert['travel_reward_name'] = Request::input('travel_reward_name');
					$insert['required_points'] = Request::input('required_points');
					$id = Tbl_travel_reward::insertGetId($insert);

					$new = DB::table('tbl_travel_reward')->where('travel_reward_id',$id)->first();

					Log::Admin(Admin::info()->account_id,Admin::info()->account_username." ADD REWARD ID #".$id,null,serialize($new));	
					return Redirect::to('/admin/utilities/travel_reward');
				}
				else
				{	
					$errors =  $validator->errors();
					$data['_error']['travel_reward_name'] = $errors->get('travel_reward_name');
					$data['_error']['required_points'] = $errors->get('required_points');
				}			
		}
		else
		{
			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits ADD REWARD");
		}

		return view('admin.computation.travel_reward_add',$data);	
	}

	public function travel_reward_delete()
	{
		Tbl_travel_reward::where('travel_reward_id',Request::input('id'))->update(['archived'=>1]);	
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." archive REWARD ID #".Request::input('id'));
		return Redirect::to('/admin/utilities/travel_reward');
	}

	public function travel_reward_restore()
	{
		Tbl_travel_reward::where('travel_reward_id',Request::input('id'))->update(['archived'=>0]);	
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." restore REWARD ID #".Request::input('id'));
		return Redirect::to('/admin/utilities/travel_reward?status=archived');
	}

	public function travel_qualification()
	{
		if(Request::input('status') == "archived")
		{
			$data["_qualification"] = Tbl_travel_qualification::where('archived',1)->get();
		}
		else
		{
			$data["_qualification"] = Tbl_travel_qualification::where('archived',0)->get();
		}
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits TRAVEL QUALIFICATION");

		return view('admin.computation.travel_qualification', $data);
	}

	public function travel_qualification_edit()
	{
		$data['_error'] = null;
		$data['data'] = Tbl_travel_qualification::where('travel_qualification_id',Request::input('id'))->first();
		if(Request::isMethod("post"))
		{
				$rules['travel_qualification_name'] = 'required|unique:tbl_membership,membership_name|regex:/^[A-Za-z0-9\s-_]+$/';
				$rules['item'] = 'numeric|min:1';
				$rules['points'] = 'numeric|min:1';
				$validator = Validator::make(Request::input(),$rules);
				if (!$validator->fails())
				{
					$old = DB::table('tbl_travel_qualification')->where('travel_qualification_id',Request::input('id'))->first();

					$update['travel_qualification_name'] = Request::input('travel_qualification_name');
					$update['item'] = Request::input('item');
					$update['points'] = Request::input('points');
					Tbl_travel_qualification::where('travel_qualification_id',Request::input('id'))->update($update);

					$new = DB::table('tbl_travel_qualification')->where('travel_qualification_id',Request::input('id'))->first();

					Log::Admin(Admin::info()->account_id,Admin::info()->account_username." edit EDIT QUALIFICATION ID #".Request::input('id'),serialize($old),serialize($new));	
				
					return Redirect::to('/admin/utilities/travel_qualification');
				}
				else
				{	
					$errors =  $validator->errors();
					$data['_error']['travel_qualification_name'] = $errors->get('travel_qualification_name');
					$data['_error']['item'] = $errors->get('item');
					$data['_error']['points'] = $errors->get('points');
				}			
		}
		else
		{
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits EDIT QUALIFICATION ID #".Request::input('id'));
		}

		return view('admin.computation.travel_qualification_edit',$data);	
	}

	public function travel_qualification_add()
	{	
		$data['_error'] = null;
		if(Request::isMethod("post"))
		{
				$rules['travel_qualification_name'] = 'required|unique:tbl_membership,membership_name|regex:/^[A-Za-z0-9\s-_]+$/';
				$rules['item'] = 'numeric|min:1';
				$rules['points'] = 'numeric|min:1';
				$validator = Validator::make(Request::input(),$rules);
				if (!$validator->fails())
				{
					$insert['travel_qualification_name'] = Request::input('travel_qualification_name');
					$insert['item'] = Request::input('item');
					$insert['points'] = Request::input('points');
					$id = Tbl_travel_qualification::insertGetId($insert);	
				
					$new = DB::table('tbl_travel_qualification')->where('travel_qualification_id',$id)->first();

					Log::Admin(Admin::info()->account_id,Admin::info()->account_username." ADD QUALIFICATION ID #".$id,null,serialize($new));	

					return Redirect::to('/admin/utilities/travel_qualification');
				}
				else
				{	
					$errors =  $validator->errors();
					$data['_error']['travel_qualification_name'] = $errors->get('travel_qualification_name');
					$data['_error']['item'] = $errors->get('item');
					$data['_error']['points'] = $errors->get('points');
				}			
		}
		else
		{
				Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits ADD QUALIFICATION");
		}

		return view('admin.computation.travel_qualification_add',$data);	
	}

	public function travel_qualification_delete()
	{
		Tbl_travel_qualification::where('travel_qualification_id',Request::input('id'))->update(['archived'=>1]);	
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." archive QUALIFICATION ID #".Request::input('id'));
		return Redirect::to('/admin/utilities/travel_qualification');
	}

	public function travel_qualification_restore()
	{
		Tbl_travel_qualification::where('travel_qualification_id',Request::input('id'))->update(['archived'=>0]);	
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." restore QUALIFICATION ID #".Request::input('id'));
		return Redirect::to('/admin/utilities/travel_qualification?status=archived');
	}

	public function matching()
	{
		$data["_membership"] = Tbl_membership::active()->get();
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits MENTOR BONUS PERCENTAGE PER MEMBERSHIP ");
		return view('admin.computation.matching', $data);
	}
	public function matching_edit()
	{
		if(Request::isMethod("post"))
		{
			$old = DB::table('tbl_matching_bonus')->where('membership_id',Request::input('id'))->get();

			Tbl_matching_bonus::where("membership_id", Request::input("id"))->delete();
			foreach(Request::input("level")["level"] as $level => $value)
			{
				$insert["membership_id"] = Request::input('id');
				$insert["matching_percentage"] = Request::input("level")["level"][$level];
				$insert["matching_requirement_count"] = Request::input("level")["count"][$level];
				// $insert["matching_requirement_membership_id"] = Request::input("level")["member"][$level];
				$insert["level"] = $level;
				Tbl_matching_bonus::where("membership_id", Request::input("id"))->insert($insert);
			}
			Tbl_membership::where("membership_id", Request::input("id"))->update(["membership_mentor_level"=>$level]);


			$new = DB::table('tbl_matching_bonus')->where('membership_id',Request::input('id'))->get();

			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." edit MENTOR BONUS/ UPDATE / MEMBERSHIP ID #".Request::input('id'),serialize($old),serialize($new));

			

			return Redirect::to('/admin/utilities/matching');
		}
		else
		{
			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits MENTOR BONUS/ UPDATE / MEMBERSHIP ID #".Request::input('id'));

			$data["data"] = Tbl_membership::where("membership_id", Request::input("id"))->first();
			$data["member"] = Tbl_membership::where("archived",0)->select('membership_id','membership_name')->get();
			$data["_member"] = Tbl_membership::where("archived",0)->select('membership_id','membership_name')->get();
			$data["member"] = json_encode($data['member']);
			$data["_level"] = Tbl_matching_bonus::where("membership_id", Request::input("id"))->get();
			return view('admin.computation.matching_edit', $data);	
		}
	}

	public function unilevel_check_match()
	{
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits UNILEVEL CHECK MATCH");
		$data["_membership"] = Tbl_membership::active()->get();
		return view('admin.computation.unilevel_check_match', $data);
	}
	public function unilevel_check_match_edit()
	{
		if(Request::isMethod("post"))
		{
			$old = DB::table('tbl_unilevel_check_match')->where('membership_id',Request::input('id'))->get();

			$update["check_match_level"] = Request::input("check_match_level");
			// $update["membership_required_pv"] = Request::input("membership_required_pv");
			// $update["membership_required_gpv"] = Request::input("membership_required_gpv");
			// $update["multiplier"] = Request::input("multiplier");
			Tbl_membership::where("membership_id", Request::input("id"))->update($update);

			$ctr = 0;
			Tbl_unilevel_check_match::where("membership_id", Request::input("id"))->delete();

			foreach(Request::input("level") as $level => $value)
			{
				$insert[$ctr]["level"] = $level;
				$insert[$ctr]["value"] = $value;
				$insert[$ctr]["membership_id"] = Request::input("id");
				$ctr++;
			}

			Tbl_unilevel_check_match::insert($insert);

			$new = DB::table('tbl_unilevel_check_match')->where('membership_id',Request::input('id'))->get();

			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." edit UNILEVEL CHECK MATCH / UPDATE ID #".Request::input('id'),serialize($old),serialize($new));
			return Redirect::to('/admin/utilities/unilevel_check_match');
		}
		else
		{
			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits UNILEVEL CHECK MATCH / UPDATE ID #".Request::input('id'));
			$data["data"] = Tbl_membership::where("membership_id", Request::input("id"))->first();
			$data["_level"] = Tbl_unilevel_check_match::where("membership_id", Request::input("id"))->get();
			return view('admin.computation.unilevel_check_match_edit', $data);	
		}
	}

	public function unilevel()
	{
		$data["_membership"] = Tbl_membership::active()->get();
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits UNILEVEL BONUS PERCENTAGE PER MEMBERSHIP");

		return view('admin.computation.unilevel', $data);
	}
	public function unilevel_edit()
	{
		if(Request::isMethod("post"))
		{
			$old = DB::table('tbl_unilevel_setting')->where('membership_id',Request::input('id'))->get();
			$update["membership_repurchase_level"] = Request::input("membership_repurchase_level");
			$update["membership_required_pv"] = Request::input("membership_required_pv");
			// $update["membership_required_gpv"] = Request::input("membership_required_gpv");
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
			$new = DB::table('tbl_unilevel_setting')->where('membership_id',Request::input('id'))->get();

			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." edit UNILEVEL BONUS PERCENTAGE / UPDATE ID #".Request::input('id'),serialize($old),serialize($new));
			return Redirect::to('/admin/utilities/unilevel');
		}
		else
		{
			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits UNILEVEL BONUS PERCENTAGE / UPDATE ID #".Request::input('id'));
			$data["data"] = Tbl_membership::where("membership_id", Request::input("id"))->first();
			$data["_level"] = Tbl_unilevel_setting::where("membership_id", Request::input("id"))->get();
			return view('admin.computation.unilevel_edit', $data);	
		}
	}

	public function leadership_bonus()
	{
		$data["_membership"] = Tbl_membership::active()->get();
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits LEADERSHIP BONUS PERCENTAGE PER MEMBERSHIP");

		return view('admin.computation.leadership_bonus', $data);
	}
	public function leadership_bonus_edit()
	{
		if(Request::isMethod("post"))
		{
			$old = DB::table('tbl_membership')->where('membership_id',Request::input('id'))->first();
			$update["leadership_bonus"] = Request::input("leadership_bonus");
			// $update["membership_required_pv"] = Request::input("membership_required_pv");
			// $update["membership_required_gpv"] = Request::input("membership_required_gpv");
			// $update["multiplier"] = Request::input("multiplier");
			Tbl_membership::where("membership_id", Request::input("id"))->update($update);

			
			$new = DB::table('tbl_membership')->where('membership_id',Request::input('id'))->first();
			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." edit LEADERSHIP BONUS PERCENTAGE / UPDATE ID #".Request::input('id'),serialize($old),serialize($new));

			return Redirect::to('/admin/utilities/leadership_bonus');
		}
		else
		{

			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits LEADERSHIP BONUS PERCENTAGE / UPDATE #".Request::input('id'));

			$data["data"] = Tbl_membership::where("membership_id", Request::input("id"))->first();
			$data["_level"] = Tbl_unilevel_check_match::where("membership_id", Request::input("id"))->get();
			return view('admin.computation.leadership_bonus_edit', $data);	
		}
	}


	/* BREAKAWAY BONUS */
	public function breakaway_bonus()
	{
		$data["_membership"] = Tbl_membership::active()->get();
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits BREAKAWAY BONUS PERCENTAGE PER MEMBERSHIP");

		return view('admin.utilities.breakaway_bonus', $data);
	}


	public function breakaway_bonus_edit()
	{
		if(Request::isMethod("post"))
		{
			$update["breakaway_bonus_level"] = Request::input("breakaway_bonus_level");
			// $update["membership_required_pv"] = Request::input("membership_required_pv");
			// $update["membership_required_gpv"] = Request::input("membership_required_gpv");
			// $update["multiplier"] = Request::input("multiplier");
			Tbl_membership::where("membership_id", Request::input("id"))->update($update);

			$update["membership_repurchase_level"] = Request::input("membership_repurchase_level");
			$update["membership_required_pv"] = Request::input("membership_required_pv");
			// $update["membership_required_gpv"] = Request::input("membership_required_gpv");
			$update["multiplier"] = Request::input("multiplier");
			Tbl_membership::where("membership_id", Request::input("id"))->update($update);

			$ctr = 0;
			$old = DB::table('tbl_breakaway_bonus_setting')->where('membership_id',Request::input('id'))->get();
			DB::table('tbl_breakaway_bonus_setting')->where("membership_id", Request::input("id"))->delete();

			foreach(Request::input("level") as $level => $value)
			{
				$insert[$ctr]["level"] = $level;
				$insert[$ctr]["value"] = $value;
				$insert[$ctr]["membership_id"] = Request::input("id");
				$ctr++;
			}

			DB::table('tbl_breakaway_bonus_setting')->insert($insert);

			
			$new = DB::table('tbl_breakaway_bonus_setting')->where('membership_id',Request::input('id'))->get();

			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." edit BREAKAWAY BONUS PERCENTAGE / UPDATE ID #".Request::input('id'),serialize($old),serialize($new));
			return Redirect::to('/admin/utilities/breakaway_bonus');
		}
		else
		{
			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits BREAKAWAY BONUS PERCENTAGE / UPDATE ID #".Request::input('id'));
			$data["data"] = Tbl_membership::where("membership_id", Request::input("id"))->first();
			$data["_level"] = DB::table('tbl_breakaway_bonus_setting')->where("membership_id", Request::input("id"))->get();
			return view('admin.utilities.breakaway_bonus_edit', $data);	
		}
	}

	public function rank()
	{
		$data["_membership"] = Tbl_membership::active()->get();
		foreach($data["_membership"] as $key => $d)
		{
			$data["_membership"][$key]->required_leg = Tbl_membership::active()->where('membership_id',$d->membership_unilevel_leg_id)->first();
			if($data["_membership"][$key]->required_leg)
			{
				$data["_membership"][$key]->required_leg = $data["_membership"][$key]->required_leg->membership_name;

			}
		}
		return view('admin.computation.rank', $data);
	}

	public function rank_edit()
	{
		if(Request::isMethod("post"))
		{
			if(Request::input("unilevel"))
			{
				$update["membership_required_unilevel_leg"] = 1;
				$update["membership_unilevel_leg_id"] = Request::input("member");
			}
			else
			{
				$update["membership_required_unilevel_leg"] = 0;
				$update["membership_unilevel_leg_id"] = null;
			}

			$update["membership_required_direct"] = Request::input("membership_required_direct");
			$update["membership_required_pv_sales"] = Request::input("membership_required_pv_sales");
			$update["membership_required_month_count"] = Request::input("membership_required_month_count");
			Tbl_membership::where("membership_id", Request::input("id"))->update($update);
			return Redirect::to('/admin/utilities/rank');
		}
		else
		{
			$data["member"] = Tbl_membership::where("archived",0)->select('membership_id','membership_name')->get();
			$data["member"] = json_encode($data['member']);
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
		$data["data"] = Tbl_membership::where("membership_id", Request::input("id"))->first();

		if(Request::isMethod("post"))
		{
			$old = DB::table('tbl_membership')->where('membership_id',Request::input('id'))->first();
			$update["max_pairs_per_day"] = Request::input("max");
			$update["every_gc_pair"] = Request::input("every_gc_pair");
			Tbl_membership::where("membership_id", Request::input("id"))->update($update);
			$new = DB::table('tbl_membership')->where('membership_id',Request::input('id'))->first();
			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." Edit Pairing Combination Membership Id #".Request::input('id'),serialize($old),serialize($new));


			return Redirect::to('/admin/utilities/binary');
		}
		else
		{
			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." View Pairing Combination Membership Id #".Request::input('id'));
		}
		
		return view('admin.computation.binary_entry', $data);	
	}
	
	
	public function compensation_rank()
	{
		$data["_compensation"] = Tbl_compensation_rank::get();

		return view('admin.computation.compensation_rank', $data);
	}

	public function compensation_rank_edit()
	{
		$rank_id = Request::input("id");
		if(Request::isMethod("post"))
		{

			$request['compensation_rank_name']			 = Request::input("compensation_rank_name");			
			$request['required_group_pv']				 = Request::input("required_group_pv");		
			$request['required_personal_pv']			 = Request::input("required_personal_pv");			
			$request['required_personal_pv_maintenance'] = Request::input("required_personal_pv_maintenance");						
			$request['rank_max_pairing']				 = Request::input("rank_max_pairing");		
			
			$rules['compensation_rank_name']			 = "required";
			$rules['required_group_pv'] 				 = "required|numeric";
			$rules['required_personal_pv']				 = "required|numeric";
			$rules['required_personal_pv_maintenance']	 = "required|numeric";
			$rules['rank_max_pairing']					 = "required|numeric";
			
			$validator = Validator::make($request, $rules);

	        if ($validator->fails())
	        {
	            return redirect("admin/utilities/rank/compensation/edit?id=".$rank_id)
	                        ->withErrors($validator)
	                        ->withInput(Request::input());
	        }
	        else
	        {
	        	Tbl_compensation_rank::where("compensation_rank_id",$rank_id)->update($request);
	        	return redirect("admin/utilities/rank/compensation/");
	        }

		}
		else
		{
			$data["rank"] = Tbl_compensation_rank::where("compensation_rank_id",$rank_id)->first();
			return view('admin.computation.compensation_rank_edit', $data);	
		}
	}
}