<?php namespace App\Http\Controllers;
use DB;
use Request;
use Redirect;
use Carbon;
use Datatables;
use App\Tbl_slot;
use App\Tbl_account;
use App\Tbl_membership;
use App\Tbl_country;
use App\Tbl_rank;
use Crypt;
use Validator;


class AdminSlotController extends AdminController
{
	public function index()
	{
        return view('admin.maintenance.slot');
	}
	public function data()
	{
        $account = Tbl_slot::rank()->membership()->account()->get();
        return Datatables::of($account)	->addColumn('edit','<a href="admin/maintenance/accounts/edit?id={{$slot_id}}">EDIT</a>')
        								->addColumn('archive','<a href="admin/maintenance/accounts/archive?id={{$slot_id}}">ARCHIVE</a>')
        								->make(true);
	}
	public function add()
	{
		$data["slot"] = Tbl_slot::rank()->membership()->account()->first();
		return view('admin.maintenance.slot_add', $data);
	}
	public function add_form()
	{
		$data["page"] = "Slot Add Form";
		$data["position"] = Request::input("position");
		$data["placement"] = Request::input("placement");
		$data["_account"] = Tbl_account::get();
		$data["_membership"] = Tbl_membership::get();
		$data["_rank"] = Tbl_rank::get();
		$data["_country"] = Tbl_country::get();
		$data["slot_number"] = Tbl_slot::max("slot_id") + 1;
		return view('admin.maintenance.slot_add_form', $data);
	}
	public function edit_form()
	{
		$data["page"] = "Slot Add Form";
		$data["slot"] = Tbl_slot::rank()->membership()->account()->id(Request::input("slot_id"))->first();
		$data["position"] = Request::input("position");
		$data["placement"] = Request::input("placement");
		$data["_account"] = Tbl_account::get();
		$data["_membership"] = Tbl_membership::get();
		$data["_rank"] = Tbl_rank::get();
		$data["_country"] = Tbl_country::get();
		$data["slot_number"] = Tbl_slot::max("slot_id") + 1;
		return view('admin.maintenance.slot_edit_form', $data);
	}
	public function add_form_submit()
	{
		$return["message"] = "";
		$data["message"] = "";
		
		if(Request::input("account_id") == 0)
		{
			$data = $this->add_form_submit_new_account($data);
			$account_id = $data["account_id"];
		}
		else
		{
			$account_id = Request::input("account_id");
		}

		$check_placement = Tbl_slot::checkposition(Request::input("placement"), strtolower(Request::input("slot_position")))->first();
		$check_id = Tbl_slot::id(Request::input("slot_number"))->first();

		if($check_placement)
		{
			$return["message"] = "The position you're trying to use is already occupied";
		}
		elseif($data["message"] != "")
		{
			$return["message"] = $data["message"];
		}
		else
		{
			$insert["slot_membership"] =  Request::input("slot_membership");
			$insert["slot_type"] =  Request::input("slot_type");
			$insert["slot_rank"] =  Request::input("rank");
			$insert["slot_wallet"] =  Request::input("wallet");
			$insert["slot_sponsor"] =  Request::input("sponsor");
			$insert["slot_placement"] =  Request::input("placement");
			$insert["slot_position"] =  strtolower(Request::input("slot_position"));
			$insert["slot_binary_left"] =  Request::input("binary_left");
			$insert["slot_binary_right"] =  Request::input("binary_right");
			$insert["slot_personal_points"] =  Request::input("personal_pv");
			$insert["slot_group_points"] =  Request::input("group_pv");
			$insert["slot_upgrade_points"] =  Request::input("upgrade_points");
			$insert["slot_total_withrawal"] =  Request::input("total_withrawal");
			$insert["slot_total_earning"] =  Request::input("total_earning");
			$insert["slot_owner"] =  $account_id;
			Tbl_slot::insert($insert);

			$return["placement"] = Request::input("placement");
		}
		
		echo json_encode($return);
	}
	public function add_form_submit_new_account($data)
	{
		$insert["account_name"] = Request::input("name");
		$validation["account_name"] = "required|min:5|unique:tbl_account,account_name";
		$insert["account_username"] = trim(Request::input("un"));
		$validation["account_username"] = "required|unique:tbl_account,account_username|alpha_num";
		$insert["account_contact_number"] = "000";
		$validation["account_contact_number"] = "required";
		$insert["account_country_id"] = Request::input("country");
		$validation["account_country_id"] = "required|exists:tbl_country,country_id";
		$insert["account_date_created"] = Carbon\Carbon::now();
		$validation["account_date_created"] = "required";
		$insert["account_password"] = Crypt::encrypt(Request::input("pw"));
		$validation["account_password"] = "required";
		$insert["account_created_from"] = "Quick Slot";
		$validation["account_created_from"] = "required";

		$validator = Validator::make($insert, $validation);

		if($validator->fails())
		{
			$messages = $validator->messages();
			$data["message"] = $messages->all()[0];
			$data["account_id"] = 0;
		}
		else
		{
			$data["message"] = "";
			$data["account_id"] = Tbl_account::insertGetId($insert);
		}

		return $data;
	}
	public function edit_form_submit()
	{
		$return["message"] = "";

		$data["slot"] = Tbl_slot::id(Request::input("slot_id"))->first();
		
		$update["slot_owner"] = Request::input("account_id");
		$update["slot_binary_left"] = Request::input("binary_left");
		$update["slot_binary_right"] = Request::input("binary_right");
		$update["slot_personal_points"] = Request::input("group_pv");
		$update["slot_group_points"] = Request::input("personal_pv");
		$update["slot_membership"] = Request::input("slot_membership");
		$update["slot_type"] = Request::input("slot_type");
		$update["slot_upgrade_points"] = Request::input("upgrade_points");
		$update["slot_wallet"] = Request::input("wallet");
		$update["slot_total_withrawal"] =  Request::input("total_withrawal");
		$update["slot_total_earning"] =  Request::input("total_earning");
		Tbl_slot::where('slot_id', Request::input("slot_id"))->update($update);

		$return["placement"] = $data["slot"]->slot_placement;

		echo json_encode($return);
	}
	public function downline()
	{
		$slot_id = Request::input("id");

		echo '	<ul>
					' . $this->downline_tree($slot_id, "left") . '
					' . $this->downline_tree($slot_id, "right") . '
		        </ul>';
	}
	public function downline_tree($slot_id, $position)
	{
		$slot_info = Tbl_slot::where("slot_placement", $slot_id)->where("slot_position", $position)->membership()->account()->first();

		if($slot_info)
		{
			$return = 	'<li class="width-reference">
                            <span class="parent parent-reference ' . $slot_info->slot_type . '" placement=' . $slot_id . ' position="' . $position . '" slot_id="' . $slot_info->slot_id . '">   
                                <div class="id">' . $slot_info->slot_id . '</div>
                                <div class="name">' . $slot_info->account_name . '</div>
                                <div class="membership">' . $slot_info->membership_name . ' (' . $slot_info->slot_type . ')</div>
                                <div class="wallet">' . number_format($slot_info->slot_wallet, 2) . '</div>
                                <div class="view-downlines">&#8659;</div>
                            </span>
                            <div class="child-container"></div>
	                    </li>';
		}
		else
		{
			$return = 	'<li class="width-reference">
			                <span class="parent parent-reference VC"> 
			                    <div placement="' . $slot_id . '" position="' . $position . '" class="button add-new-slot">+</div>  
			                </span>                    
			            </li>';
		}



		return $return;
	}
}