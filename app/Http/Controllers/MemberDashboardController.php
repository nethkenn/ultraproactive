<?php namespace App\Http\Controllers;
use App\Tbl_account_log;
use App\Tbl_slot;
use App\Tbl_slot_log;
use App\Tbl_lead;
use App\Tbl_membership;
use App\Classes\Customer;
use DB;
use App\Tbl_product_code;
use App\Tbl_tree_placement;
use App\Tbl_wallet_logs;
use Session;
use App\Classes\Compute;
class MemberDashboardController extends MemberController
{
	public function index()
	{
		
		$data["_notification"] = $this->get_notifications(false);
		$data["total_wallet"] = Tbl_wallet_logs::id(Session::get('currentslot'))->wallet()->sum('wallet_amount');
		$data["total_count"] = Tbl_slot::where("slot_owner", Customer::id())->count();
		$data['leadc'] = Tbl_lead::where('lead_account_id',Customer::id())->count();
		$data['code'] = DB::table('tbl_membership_code')  ->where('tbl_membership_code.archived',0)
														  ->where('tbl_membership_code.blocked',0)
														  ->where('tbl_membership_code.used',0)
														  ->where('tbl_membership_code.account_id','=',Customer::id())
														  ->count();

		$data['left_side'] = Tbl_tree_placement::where('placement_tree_parent_id',Customer::slot_id())->where('placement_tree_position','left')->count(); 												  
		$data['right_side'] = Tbl_tree_placement::where('placement_tree_parent_id',Customer::slot_id())->where('placement_tree_position','right')->count();
		$data['prod'] = Tbl_product_code::where("account_id", Customer::id())->where('tbl_product_code.used',0)->voucher()->product()->orderBy("product_pin", "desc")->unused()->count();													  
		$data['count_log'] = Tbl_wallet_logs::where('hide', 0)->where('slot_id',Session::get('currentslot'))->count();
		$data["_slot_log"] = Tbl_slot_log::		select('tbl_slot_log.*', DB::raw('sum(slot_log_wallet_update) as total'))
							                 	->where("slot_id", Customer::slot_id())
							                 	->groupBy('slot_log_key')
							                 	->get();
		$joined_date = Customer::info()->account_date_created;
		$data['joined_date'] = date("M d,Y", strtotime($joined_date));
		

		$slot_info = Tbl_slot::membership()->id(Customer::slot_id())->first();
		if($slot_info)
		{
			$data["group_upcoins"]				= Compute::count_gpv($slot_info->slot_id);
			$data["personal_upcoins"]	     	= DB::table("tbl_pv_logs")->where("owner_slot_id",$slot_info->slot_id)->where("used_for_redeem",0)->where("type","PPV")->sum("amount");
			if($slot_info->slot_type == "CD")
			{
				$data["personal_upcoins"]	    = 0;	
			}
			$data["current_rank"]				= DB::table("tbl_compensation_rank")->where("compensation_rank_id",$slot_info->permanent_rank_id)->first()->compensation_rank_name;
			// $data["maxpairing"]			     	= DB::table("tbl_compensation_rank")->where("compensation_rank_id",$slot_info->current_rank)->first()->rank_max_pairing;
			$data["maxpairing"]			     	= DB::table("tbl_membership")->where("membership_id",$slot_info->slot_membership)->first()->max_pairs_per_day;
			$travel = Compute::compute_travel($slot_info);
			$data['points'] = $travel['points'];
			$data['reward'] = $travel['reward'];
			$data['oldwallet'] = Tbl_wallet_logs::id(Session::get('currentslot'))->where('keycode','Old System Wallet')->wallet()->sum('wallet_amount');	
			$data["next_membership"] = Tbl_membership::where("membership_required_upgrade", ">",  $slot_info->membership_required_upgrade)->orderBy("membership_required_upgrade", "asc")->first();			
		}
		
        
        return view('member.dashboard', $data);
	}
	public function notification()
	{

		$data["_notification"] = $this->get_notifications(true);
        return view('member.notification', $data);
	}
	public function get_notifications($all)
	{
		$_notification = Tbl_wallet_logs::where("tbl_wallet_logs.hide", 0)->orderBy('wallet_logs_id', 'desc');

		if(!$all)
		{
			$_notification->take(6);
		}
		$_notification = $_notification->where('slot_id', Session::get('currentslot'));
		$_notification = $_notification->get();



		$data["_notification"] = null;

		foreach($_notification as $key => $notification)
		{
			$data["_notification"][$key] = $notification;
			$data["_notification"][$key]->date = date("F d, Y", strtotime($notification->created_at)) .  " - " . date("h:i A", strtotime($notification->created_at));
		}

		return $data["_notification"];
	}
}