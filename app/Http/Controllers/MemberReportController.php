<?php namespace App\Http\Controllers;
use App\Tbl_account_log;
use App\Tbl_slot;
use App\Tbl_slot_log;
use App\Tbl_lead;
use App\Tbl_membership;
use App\Tbl_compensation_rank;
use App\Classes\Customer;
use App\Classes\Compute;
use DB;
use App\Tbl_product_code;
use App\Tbl_tree_placement;
use App\Tbl_wallet_logs;
use App\Tbl_account_encashment_history;
use App\Tbl_pv_logs;
use Session;
use Request;
use Redirect;
use Carbon\Carbon;
class MemberReportController extends MemberController
{
	public function breakdown()
	{
		$keycode = Request::input('breakdown_name');
		$type = Request::input('type');
		$name_type = Request::input('type');
		$data['name'] = null;
		if($keycode == 'binary' || $keycode == 'direct' || $keycode == 'Old System Wallet' || $keycode == 'Old System GC' || $keycode|| 'matching' || $keycode == 'Dynamic Compression')
		{	
			if($type == 1)
			{
				$type = 'Wallet';
			}
			elseif($type == 2)
			{
				$type = 'GC';
			}	
			else
			{
				return Redirect::to('/member/reports/income_summary');
			}

			$name = Request::input('breakdown_name');

			if($keycode == 'binary' && $name_type == 2)
			{
				$name = 'Matching GC';
			}
			elseif($keycode == 'direct' && $name_type == 2)
			{
				$name = "Sponsor GC";
			}
			elseif($keycode == 'Old System Wallet' && $name_type == 1)
			{
				$name = "Old Wallet";
			}
			elseif($keycode == 'Old System GC' && $name_type == 2)
			{
				$name = "Old GC";
			}
			elseif($keycode == 'matching' && $name_type == 1)
			{
				$name = "Mentor";
			}
			elseif($keycode == 'binary' && $name_type == 1)
			{
				$name = "Matching";
			}
			elseif($keycode == 'Dynamic Compression' && $name_type == 1)
			{
				$name = "Dynamic Compression";
			}
			elseif($keycode == 'Global Pool Sharing' && $name_type == 1)
			{
				$name = "Global Pool Sharing";
			}

			if($keycode == 'Dynamic Compression')
			{
				$data['logs']['dynamic']     = Tbl_wallet_logs::where('keycode','=',$keycode)->where('slot_id',Session::get('currentslot'))->where('wallet_type',$type)->where('wallet_amount','>',0)->get();
				$data['total']['dynamic']    = Tbl_wallet_logs::where('keycode','=',$keycode)->where('slot_id',Session::get('currentslot'))->where('wallet_type',$type)->sum('wallet_amount');
				
				$data['logs']['checkmatch']  = Tbl_wallet_logs::where('keycode','=','Unilevel Check Match')->where('slot_id',Session::get('currentslot'))->where('wallet_type',$type)->where('wallet_amount','>',0)->get();
				$data['total']['checkmatch'] = Tbl_wallet_logs::where('keycode','=','Unilevel Check Match')->where('slot_id',Session::get('currentslot'))->where('wallet_type',$type)->sum('wallet_amount');
				
				$data['logs']['breakaway']   = Tbl_wallet_logs::where('keycode','=','Breakaway Bonus')->where('slot_id',Session::get('currentslot'))->where('wallet_type',$type)->where('wallet_amount','>',0)->get();
				$data['total']['breakaway']  = Tbl_wallet_logs::where('keycode','=','Breakaway Bonus')->where('slot_id',Session::get('currentslot'))->where('wallet_type',$type)->sum('wallet_amount');
	
				$data['logs']['leadership']  = Tbl_wallet_logs::where('keycode','=','Leadership Bonus')->where('slot_id',Session::get('currentslot'))->where('wallet_type',$type)->where('wallet_amount','>',0)->get();
				$data['total']['leadership'] = Tbl_wallet_logs::where('keycode','=','Leadership Bonus')->where('slot_id',Session::get('currentslot'))->where('wallet_type',$type)->sum('wallet_amount');
			}
			else
			{
				$data['logs'] = Tbl_wallet_logs::where('keycode','=',$keycode)->where('slot_id',Session::get('currentslot'))->where('wallet_type',$type)->where('wallet_amount','>',0)->get();
				$data['total'] = Tbl_wallet_logs::where('keycode','=',$keycode)->where('slot_id',Session::get('currentslot'))->where('wallet_type',$type)->sum('wallet_amount');
			}
			$data['name'] = $name;				
		}
		else
		{
			return Redirect::to('/member/reports/income_summary');
		}
        
        return view('member.income_breakdown', $data);
	}	

	public function summary()
	{
		
		$data['matching_gc'] = Tbl_wallet_logs::where('keycode','=','binary')->where('slot_id',Session::get('currentslot'))->where('wallet_type','GC')->sum('wallet_amount');
		$data['sponsor_gc']  = Tbl_wallet_logs::where('keycode','=','direct')->where('slot_id',Session::get('currentslot'))->where('wallet_type','GC')->sum('wallet_amount');
		$data['old_wallet']  = Tbl_wallet_logs::where('keycode','=','Old System Wallet')->where('slot_id',Session::get('currentslot'))->sum('wallet_amount');
		$data['old_gc']      = Tbl_wallet_logs::where('keycode','=','Old System GC')->where('slot_id',Session::get('currentslot'))->sum('wallet_amount');
		$data['mentor']      = Tbl_wallet_logs::where('keycode','=','matching')->wallet()->where('slot_id',Session::get('currentslot'))->sum('wallet_amount');
		$data['matching']    = Tbl_wallet_logs::where('keycode','=','binary')->wallet()->where('slot_id',Session::get('currentslot'))->sum('wallet_amount');
		$data['sponsor']     = Tbl_wallet_logs::where('keycode','=','direct')->wallet()->where('slot_id',Session::get('currentslot'))->sum('wallet_amount');
		$data['dynamic']     = Tbl_wallet_logs::where('keycode','=','Dynamic Compression')->where('slot_id',Session::get('currentslot'))->orWhere('keycode','Breakaway Bonus')->orWhere('keycode','Unilevel Check Match')->orWhere('keycode','Leadership Bonus')->sum('wallet_amount');
		$data['gps']	     = Tbl_wallet_logs::where('keycode','=','Global Pool Sharing')->wallet()->where('slot_id',Session::get('currentslot'))->sum('wallet_amount');
		$data['total']       = $data['old_wallet']+$data['mentor']  + $data['matching']+$data['sponsor'] +$data['dynamic'];
		 


        return view('member.income_summary', $data);
	}

	public function genealogy_list()
	{
		$id 		   = Session::get('currentslot');

		$tree 		   = Tbl_tree_placement::where("placement_tree_parent_id",$id)->orderBy('placement_tree_level','ASC')
									->join("tbl_slot","tbl_slot.slot_id","=","tbl_tree_placement.placement_tree_child_id")
									->join("tbl_account","tbl_account.account_id","=","tbl_slot.slot_owner")
									->select("placement_tree_level","tbl_slot.slot_id","tbl_tree_placement.placement_tree_child_id","account_id","slot_owner","account_name","slot_personal_points","placement_tree_position","slot_type")
									->get();
		$data["_tree"] = $tree;
		return view('member.genealogy_list', $data);
	}

	public function encashment_history()
	{
		$id 		     = Session::get('currentslot');

		$encash 		 = Tbl_account_encashment_history::where("slot_id",$id)->get();
		$data["_encash"] = $encash;

		return view('member.encashment_history', $data);
	}
	
	public function upcoin_report()
	{
		$id 		      = Session::get('currentslot');
		$slot_info 		  = Tbl_slot::where("slot_id",$id)->first();
		$current_year     = date("Y-", strtotime(Carbon::now()));
		
		
		$data["_logs"]	  = Tbl_pv_logs::where("owner_slot_id",$id)->get();
		
		
		$data["january"]		= Tbl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."01")->where("used_for_redeem",0)->sum("amount") != null ? bl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."01")->where("used_for_redeem",0)->sum("amount") : 0;	
		$data["february"]		= Tbl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."02")->where("used_for_redeem",0)->sum("amount") != null ? bl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."02")->where("used_for_redeem",0)->sum("amount") : 0;	
		$data["march"]			= Tbl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."03")->where("used_for_redeem",0)->sum("amount") != null ? bl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."03")->where("used_for_redeem",0)->sum("amount") : 0;	
		$data["april"]			= Tbl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."04")->where("used_for_redeem",0)->sum("amount") != null ? bl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."04")->where("used_for_redeem",0)->sum("amount") : 0;	
		$data["may"]			= Tbl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."05")->where("used_for_redeem",0)->sum("amount") != null ? bl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."05")->where("used_for_redeem",0)->sum("amount") : 0;	
		$data["june"]			= Tbl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."06")->where("used_for_redeem",0)->sum("amount") != null ? bl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."06")->where("used_for_redeem",0)->sum("amount") : 0;	
		$data["july"]			= Tbl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."07")->where("used_for_redeem",0)->sum("amount") != null ? bl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."07")->where("used_for_redeem",0)->sum("amount") : 0;	
		$data["august"]			= Tbl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."08")->where("used_for_redeem",0)->sum("amount") != null ? bl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."08")->where("used_for_redeem",0)->sum("amount") : 0;	
		$data["september"]		= Tbl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."09")->where("used_for_redeem",0)->sum("amount") != null ? bl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."09")->where("used_for_redeem",0)->sum("amount") : 0;	
		$data["october"]		= Tbl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."10")->where("used_for_redeem",0)->sum("amount") != null ? bl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."10")->where("used_for_redeem",0)->sum("amount") : 0;	
		$data["november"]		= Tbl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."11")->where("used_for_redeem",0)->sum("amount") != null ? bl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."11")->where("used_for_redeem",0)->sum("amount") : 0;	
		$data["december"]		= Tbl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."12")->where("used_for_redeem",0)->sum("amount") != null ? bl_pv_logs::where("owner_slot_id",$id)->where("date_created","LIKE",$current_year."12")->where("used_for_redeem",0)->sum("amount") : 0;	
		
		$data["subtotal"] = Tbl_pv_logs::where("owner_slot_id",$id)->where("used_for_redeem",0)->sum("amount") != null ? Tbl_pv_logs::where("owner_slot_id",$id)->where("used_for_redeem",0)->sum("amount") : 0;
		$data["redeem"]   = Tbl_pv_logs::where("owner_slot_id",$id)->where("used_for_redeem",1)->sum("amount") != null ? Tbl_pv_logs::where("owner_slot_id",$id)->where("used_for_redeem",1)->sum("amount") : 0;
		$data["gpv"]      = Compute::count_gpv($id);
		$data["total"]    = $data["subtotal"] - (-1 * $data["redeem"]);
		
		$data["match"]    = Tbl_compensation_rank::where("compensation_rank_id",$slot_info->current_rank)->first()->rank_max_pairing;
		return view('member.upcoin_report',$data);
		
	}
}