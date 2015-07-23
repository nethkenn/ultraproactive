<?php namespace App\Http\Controllers;
use App\Tbl_account_log;
use App\Tbl_slot;
use App\Classes\Customer;

class MemberDashboardController extends MemberController
{
	public function index()
	{
		$data["_notification"] = $this->get_notifications();
		$data["total_wallet"] = Tbl_slot::where("slot_owner", Customer::id())->sum('slot_wallet');
		$data["total_count"] = Tbl_slot::where("slot_owner", Customer::id())->count();
        return view('member.dashboard', $data);
	}
	public function get_notifications()
	{
		$_notification = Tbl_account_log::orderBy('account_log_id', 'desc')->take(6)->get();
		$data["_notification"] = null;

		foreach($_notification as $key => $notification)
		{
			$data["_notification"][$key] = $notification;
			$data["_notification"][$key]->date = date("F d, Y", strtotime($notification->account_log_date)) .  " - " . date("h:i A", strtotime($notification->account_log_date));
		}

		return $data["_notification"];
	}
}