<?php namespace App\Http\Controllers;

use DB;
use Request;
use Crypt;
use App\Tbl_slot;
use App\Tbl_hack;
use App\Tbl_account;
use App\Classes\Compute;


class AdminMigrationController extends AdminController
{
	public function index()
	{
		$data["page"] = "Migration Maintenance";
		$data["slot_count"] = Tbl_slot::count();
		$data["hack_count"] = Tbl_hack::count();
		$data["slot_hack_count"] = Tbl_slot::where("hack_reference", "!=", 0)->count();
        return view('admin.utilities.migration', $data);
	}
	public function start()
	{
		$data["_hack"] = Tbl_hack::get();
		$update["slot_binary_left"] = 0;
		$update["slot_binary_right"] = 0;
		$update["slot_wallet"] = 0;
		$update["slot_total_withrawal"] = 0;
		$update["slot_total_earning"] = 0;
		$update["slot_personal_points"] = 0;
		$update["slot_group_points"] = 0;
		$update["slot_upgrade_points"] = 0;
		$update["slot_flushout"] = 0;
		$update["pair_flush_out_wallet"] = 0;
		$update["pairs_today"] = 0;
		$update["slot_today_income"] = 0;
		DB::table("tbl_slot")->update($update);

		return json_encode($data["_hack"]);
	}
	public function hack()
	{
		$hack = Tbl_hack::where("hack_id", Request::input("hack_id"))->first();
		$slot_info = Tbl_slot::where("hack_reference", Request::input("hack_id"))->first();

		if($hack)
		{
			if($slot_info)
			{
				/* UPDATE SLOT */
				$update["slot_binary_left"] = ($this->parse_number($hack->binary_left) / 160) * 3;
				$update["slot_binary_right"] = ($this->parse_number($hack->binary_right) / 160) * 3;
				$update["slot_wallet"] = $this->parse_number($hack->available_balance);
				$update["slot_total_withrawal"] = $this->parse_number($hack->total_withraw);
				$update["slot_total_earning"] = $this->parse_number($hack->available_balance) + $this->parse_number($hack->total_withraw);
				Tbl_slot::where("slot_id", $slot_info->slot_id)->update($update);

				/* UPDATE ACCOUNT */
				$update_account["account_password"] = Crypt::encrypt($hack->password);
				Tbl_account::where("account_id", $slot_info->slot_owner)->update($update_account);
			}
		}


		echo json_encode("success!");
	}
	public function start_rematrix()
	{
		$data["_slots"] = Tbl_slot::get();
		DB::table("tbl_tree_placement")->truncate();
		DB::table("tbl_tree_sponsor")->truncate();
		return json_encode($data["_slots"]);
	}
	public function rematrix()
	{
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
}