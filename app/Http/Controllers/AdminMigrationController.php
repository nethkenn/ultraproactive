<?php namespace App\Http\Controllers;

use DB;
use Request;
use Crypt;
use App\Tbl_slot;
use App\Tbl_hack;
use App\Tbl_account;
use App\Classes\Compute;
use App\Classes\Admin;
use App\Classes\Log;

class AdminMigrationController extends AdminController
{
	public function index()
	{
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits Migration Maintenance");
		$data["page"] = "Migration Maintenance";
		$data["slot_count"] = Tbl_slot::count();
		$data["hack_count"] = DB::table('tbl_members')->count();
		$data["slot_hack_count"] = Tbl_slot::where("hack_reference", "!=", 0)->count();
		if(isset($_POST['get_gc']))
		{
			$this->get_gc();
		}
		if(Admin::info()->admin_rank_position != 0)
		{
			return Redirect::to('/admin');
		}
        return view('admin.utilities.migration', $data);
	}
	// public function start()
	// {
	// 	Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits Start Migration");
	// 	$data["_hack"] = DB::table('tbl_members')->get();
	// 	DB::table('tbl_account')->where('account_id','!=',1)->delete();
	// 	DB::table('tbl_slot')->delete();

	// 	return json_encode($data["_hack"]);
	// }
	// public function hack()
	// {
	// 	// $hack = Tbl_hack::where("hack_id", Request::input("hack_id"))->first();
	// 	// $slot_info = Tbl_slot::where("hack_reference", Request::input("hack_id"))->first();

	// 	$id_code = Request::input('hack_id');
	// 	$g = DB::table('tbl_members')->where('id_code',$id_code)->first();

	// 	//tbl_members , tbl_binary_points , tbl_binary_pairings , tbl_encashment, tbl_bonuses
	// 	$right = DB::table('tbl_binary_points')->select('points', DB::raw('SUM(points) as total_amount'))->where('id_code',$id_code)->where('position',"right")->first();
	// 	$left  = DB::table('tbl_binary_points')->select('points', DB::raw('SUM(points) as total_amount'))->where('id_code',$id_code)->where('position',"left")->first();
	// 	$minus = DB::table('tbl_binary_pairings')->select('points', DB::raw('SUM(points) as total_amount'))->where('username',$id_code)->first();
		
	// 	$right = $right->total_amount - $minus->total_amount;
	// 	$left  = $left->total_amount - $minus->total_amount;
		
	// 	$slot_wallet  = DB::table('tbl_bonuses')   ->select('amount', DB::raw('SUM(amount) as total_amount'))->where('recepient_code',$id_code)
	// 										       ->whereIn('bonus_type',['PAIR','DSI'])
	// 										       ->first();
 //        $slot_gc      = DB::table('tbl_bonuses')   ->select('amount', DB::raw('SUM(amount) as total_amount'))->where('recepient_code',$id_code)
	// 										       ->whereIn('bonus_type',['DGC','PGC'])
	// 										       ->first();
	// 	$minus_wallet = DB::table('tbl_encashment')->select('amount', DB::raw('SUM(amount) as total_amount'))->where('id_code',$id_code)
	// 										  	   ->first();
	// 	$minus_gc 	  = DB::table('tbl_encashment')->select('gc', DB::raw('SUM(gc) as total_amount'))->where('id_code',$id_code)
	// 										  	   ->first();

	// 	$slot_wallet  = $slot_wallet->total_amount - $minus_wallet->total_amount;

	// 	$slot_gc = $slot_gc->total_amount - $minus_gc->total_amount;





	// 			$get = DB::table('tbl_members')->where('tbpi_ctr','!=',1)->get();


	// 	       	$password =   DB::table('tbl_members')->select((DB::raw("DECODE(password, 'yourtheboss2014') AS decoded")))
	// 		      									  ->selectRaw('password as encoded')
	// 											      ->where('tbpi_ctr', '=', $g->tbpi_ctr)->first();

	// 		    if($g->relationship == "NA" || $g->relationship == "-" || $g->relationship == "N/A" || $g->relationship == "n/a")
	// 		    {
	// 		    	$bene_id = null;
	// 		    	$beneficiary_id = null;
	// 		    }
	// 		    else
	// 		    {
	// 		    	$bene_id = DB::table('tbl_beneficiary_rel')->where('relation',$g->relationship)->first();
	// 		    	if(!$bene_id)
	// 		    	{
	// 		    		$bene_id = DB::table('tbl_beneficiary_rel')->where('relation',$g->relationship)->insertGetId(['relation'=>$g->relationship]);
	// 		    	}
	// 		    	else
	// 		    	{
	// 		    		$bene_id = $bene_id->beneficiary_rel_id;
	// 		    	}

	// 		    	$beneficiary_id = DB::table('tbl_beneficiary')->insertGetId(['whole_name'=>$g->beneficiary,'beneficiary_rel_id'=>$bene_id]);
	// 		    }



	// 			if($g->sex == "F")
	// 			{
	// 				$gender = "Female";
	// 			}								      
	// 			else
	// 			{
	// 				$gender = "Male";
	// 			}

	// 			if($g->address == "NA" || $g->address == "-" || $g->address == "N/A" || $g->address == "n/a")
	// 			{
	// 				$address = "";
	// 			}
	// 			else
	// 			{
	// 				$address = $g->address;
	// 			}

	// 			if($g->middlename == "NA" || $g->middlename == "N/A" || $g->middlename == "-" || $g->middlename == "n/a")
	// 			{
	// 				$fullname = $g->firstname." ".$g->lastname;
	// 			}
	// 			else
	// 			{
	// 				$fullname = $g->firstname." ".$g->middlename." ".$g->lastname;
	// 			}

	// 			if($g->landline == "NA" || $g->landline == "-" || $g->landline == "N/A" || $g->landline == "n/a")
	// 			{
	// 				$landline = "";
	// 			}
	// 			else
	// 			{
	// 				$landline = $g->landline;
	// 			}

	// 			if($g->mobile == "NA" || $g->mobile == "-" || $g->mobile == "N/A" || $g->landline == "n/a")
	// 			{
	// 				$mobile = "";
	// 			}
	// 			else
	// 			{
	// 				$mobile = $g->mobile;
	// 			}

	
	// 			$insert['account_name'] = $fullname;
	// 			$insert['account_email'] = $g->email;
	// 			$insert['account_username'] = $g->username;
	// 			$insert['account_contact_number'] = $mobile;
	// 			$insert['account_country_id'] = 
	// 			$insert['birthday'] = $g->birthdate;
	// 			$insert['telephone'] = $landline;
	// 			$insert['gender'] = $gender;
	// 			$insert['address'] = $address;
	// 			$insert['account_password'] = Crypt::encrypt($password->decoded);
	// 			$insert['custom_field_value'] = " ";
	// 			$insert['image'] = "";
	// 			$insert['account_created_from'] = "Old System";
	// 			$insert['archived'] = 0;
	// 			$insert['beneficiary_id'] = $beneficiary_id;
	// 			$insert['account_date_created'] = $g->date_registered;

	// 			$account_id = DB::table('tbl_account')->insertGetId($insert);

	// 			$insert = null;

	// 			if($g->username=="ULTRATOP")
	// 			{
	// 				$insert['slot_owner'] = $account_id;
	// 				$insert['slot_membership'] = 1;
	// 				if($g->status_type == "PAID")
	// 				{
	// 					$slot_type = "PS";
	// 				}
	// 				else if($g->status_type == "FREE")
	// 				{
	// 					$slot_type = "FS";
	// 				}
	// 				else if($g->status_type == "CD")
	// 				{
	// 					$slot_type = "CD";
	// 				}
	// 				$insert["slot_type"] = $slot_type;
	// 				$insert["slot_rank"] = 1;
	// 				$insert["slot_sponsor"] = 999999999;
	// 				$insert["slot_placement"] = 999999999;
	// 				$insert["slot_position"] = "left";
	// 				// $insert["slot_wallet"] = $slot_wallet;
	// 				$insert["slot_gc"] = $slot_gc;
	// 				$insert["slot_binary_left"] = $left;
	// 				$insert["slot_binary_right"] = $right;
	// 				$insert["membership_entry_id"] = 1;
	// 				$insert["created_at"] =  $g->date_registered;
	// 				$new_id = DB::table('tbl_slot')->insertGetId($insert);
	// 		        $log = "Amount of <b>".number_format($slot_wallet,2)." wallet </b> gained from old system.";
	// 				if($slot_wallet != 0)
	// 				{
 //        				Log::slot($new_id, $log, $slot_wallet,"Old System Wallet",$new_id);
 //    				}
	// 				if($slot_gc != 0)
	// 				{
	// 			        $log = "Amount of <b>".number_format($slot_gc,2)." GC </b> gained from old system.";
 //        				Log::slot($new_id, $log, $slot_gc,"Old System GC",$new_id,1);					
	// 				}

	// 			}
	// 			else
	// 			{
	// 				$acc_id  = Tbl_account::where('account_username',$g->upline_code)->first();
	// 				$sponsor_id  = Tbl_account::where('account_username',$g->sponsor_code)->first();
	// 				$slot_sponsor  = Tbl_slot::where('slot_owner',$sponsor_id->account_id)->first();
	// 				$slot_id = Tbl_slot::where('slot_owner',$acc_id->account_id)->first();
	// 				$insert['slot_owner'] = $account_id;
	// 				$insert['slot_membership'] = 1;
	// 				if($g->status_type == "PAID")
	// 				{
	// 					$slot_type = "PS";
	// 				}
	// 				else if($g->status_type == "FREE")
	// 				{
	// 					$slot_type = "FS";
	// 				}
	// 				else if($g->status_type == "CD")
	// 				{
	// 					$slot_type = "CD";
	// 				}
				
	// 				$insert["slot_type"] = $slot_type;
	// 				$insert["slot_rank"] = 1;
	// 				$insert["slot_sponsor"] = $slot_sponsor->slot_id;
	// 				$insert["slot_placement"] = $slot_id->slot_id;
	// 				$insert["slot_position"] = strtolower($g->upline_pos);
	// 				// $insert["slot_wallet"] = $slot_wallet;
	// 				$insert["slot_gc"] = $slot_gc;
	// 				$insert["slot_binary_left"] = $left;
	// 				$insert["slot_binary_right"] = $right;
	// 				$insert["membership_entry_id"] = 1;
	// 				$insert["created_at"] =  $g->date_registered;
	// 				$seed = DB::table('tbl_slot')->insertGetId($insert);
	// 				if($slot_wallet != 0)
	// 				{
	// 			        $log = "Amount of <b>".number_format($slot_wallet,2)." wallet </b> gained from old system.";
 //        				Log::slot($seed, $log, $slot_wallet,"Old System Wallet",$seed);					
	// 				}
	// 				if($slot_gc != 0)
	// 				{

	// 			        $log = "Amount of <b>".number_format($slot_gc,2)." GC </b> gained from old system.";
 //        				Log::slot($seed, $log, $slot_gc,"Old System GC ",$seed,1);					

	// 				}
	// 				Compute::tree($seed);
	// 			}

	// 			$insert = null;


	// 	echo json_encode("success!");
	// }
	public function start_rematrix()
	{
		$data["_slots"] = Tbl_slot::get();
		DB::table("tbl_tree_placement")->truncate();
		DB::table("tbl_tree_sponsor")->truncate();
		return json_encode($data["_slots"]);
	}
	// public function start_recompute()
	// {
	// 	$data["_slots"] = Tbl_slot::where("slot_membership", 2)->orWhere("slot_membership", 16)->get();
	// 	return json_encode($data["_slots"]);
	// }
	// public function recompute()
	// {
	// 	$slot_id = Request::input("slot_id");
	// 	Compute::entry($slot_id);
	// 	echo json_encode("success!");
	// }
	public function rematrix()
	{
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits Start Rematrix");
		$slot_id = Request::input("slot_id");
		Compute::tree($slot_id);
		echo json_encode("success!");
	}

	public function parse_number($number, $dec_point=null) {
	    if (empty($dec_point)) {
	        $locale = localeconv();
	        $dec_point = $locale['decimal_point'];
	    }
	    return floatval(str_replace($dec_point, '.', preg_replace('/[^\d'.preg_quote($dec_point).']/', '', $number)));
	}

	public function get_gc()
	{

		$get = Tbl_slot::where('slot_gc','!=',0)->get();
		foreach($get as $g)
		{
			$gc = $g->slot_gc;
			$update['slot_gc'] = 0;

			Tbl_slot::where('slot_id',$g->slot_id)->update($update);

	        $log = "Amount of <b>".number_format($gc,2)." GC </b> gained from old system.";

			Log::slot($g->slot_id, $log, $gc,"Old System Wallet",$g->slot_id,1);			
		}
			
	}
}