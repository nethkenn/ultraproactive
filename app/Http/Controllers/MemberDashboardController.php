<?php namespace App\Http\Controllers;
use App\Tbl_account_log;
use App\Tbl_slot;
use App\Tbl_slot_log;
use App\Tbl_lead;
use App\Tbl_membership;
use App\Classes\Customer;
use DB;
use App\Tbl_product_code;
class MemberDashboardController extends MemberController
{
	public function index()
	{
		$data["_notification"] = $this->get_notifications(false);
		$data["total_wallet"] = Tbl_slot::where("slot_owner", Customer::id())->sum('slot_wallet');
		$data["total_count"] = Tbl_slot::where("slot_owner", Customer::id())->count();
		$data['leadc'] = Tbl_lead::where('lead_account_id',Customer::id())->count();
		$data['code'] = DB::table('tbl_membership_code')  ->where('tbl_membership_code.archived',0)
														  ->where('tbl_membership_code.blocked',0)
														  ->where('tbl_membership_code.used',0)
														  ->join('tbl_account','tbl_account.account_id','=','tbl_membership_code.account_id')
														  ->join('tbl_code_type','tbl_code_type.code_type_id','=','tbl_membership_code.code_type_id')
														  ->join('tbl_membership','tbl_membership.membership_id','=','tbl_membership_code.membership_id')
														  ->leftjoin('tbl_product_package','tbl_product_package.product_package_id','=','tbl_membership_code.product_package_id')
														  ->where('tbl_membership_code.account_id','=',Customer::id())
														  ->orderBy('tbl_membership_code.code_pin','ASC')
														  ->count();
		$data['prod'] = Tbl_product_code::where("account_id", Customer::id())->where('tbl_product_code.used',0)->voucher()->product()->orderBy("product_pin", "desc")->unused()->count();													  
		$data['count_log'] = Tbl_account_log::orderBy('account_log_id', 'desc')->where('account_id',Customer::id())->count();
		$data["_slot_log"] = Tbl_slot_log::		select('tbl_slot_log.*', DB::raw('sum(slot_log_wallet_update) as total'))
							                 	->where("slot_id", Customer::slot_id())
							                 	->groupBy('slot_log_key')
							                 	->get();
		$joined_date = Customer::info()->account_date_created;
		$data['joined_date'] = date("M d,Y", strtotime($joined_date));
		

		$slot_info = Tbl_slot::membership()->id(Customer::slot_id())->first();
		if($slot_info)
		{
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
		$_notification = Tbl_account_log::orderBy('account_log_id', 'desc');

		if(!$all)
		{
			$_notification->take(6);
		}
		$_notification = $_notification->where('account_id', Customer::id());
		$_notification = $_notification->get();



		$data["_notification"] = null;

		foreach($_notification as $key => $notification)
		{
			$data["_notification"][$key] = $notification;
			$data["_notification"][$key]->date = date("F d, Y", strtotime($notification->account_log_date)) .  " - " . date("h:i A", strtotime($notification->account_log_date));
		}

		return $data["_notification"];
	}
}