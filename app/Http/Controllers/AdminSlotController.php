<?php namespace App\Http\Controllers;
use DB;
use Request;
use Redirect;
use Carbon;
use Datatables;
use App\Tbl_slot;
use App\Tbl_account;
use App\Tbl_membership;
use App\Tbl_voucher;
use App\Tbl_compensation_rank;
use App\Tbl_pv_logs;
use App\Tbl_country;
use App\Tbl_rank;
use Crypt;
use Excel;
use Validator;
use App\Classes\Compute;
use Session;
use App\Tbl_wallet_logs;
use App\Classes\Log;
use App\Classes\Admin;

class AdminSlotController extends AdminController
{
	public function index()
	{

		// dd("AdminSlotController");
		$data['membership'] = Tbl_membership::where('archived',0)->get();
		$data['slot_limit'] = DB::table('tbl_settings')->where('key','slot_limit')->first();
		$data["_compensation_rank"] =Tbl_compensation_rank::get();
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits Slot Maintenance");
		if(!$data['slot_limit'])
		{
			DB::table('tbl_settings')->insert(['key'=>'slot_limit','value'=>1]);
		}
		
		if(isset($_POST['slot_limit']))
		{
			$old = DB::table('tbl_settings')->where('key','slot_limit')->first();
			DB::table('tbl_settings')->where('key','slot_limit')->update(['key'=>'slot_limit','value'=>Request::input('slot_limit')]);
			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." change slot limit ".$old->value.' to '.Request::input('slot_limit'));
		    return Redirect::to('admin/maintenance/slots');
		}

		if(isset($_POST['rank_adjustment']))
		{
			$update["permanent_rank_id"] = $_POST["rank_adjustment"];
			$slot_id                = $_POST["slot_id"];
			$slot_inf				= Tbl_slot::where("slot_id",$slot_id)->first();
			Tbl_slot::where("slot_id",$slot_id)->update($update);
			Compute::check_compensation_rank_manual($slot_id);
			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." update Slot ID".$slot_id." from rank id ".$slot_inf->current_rank." to ". $update["permanent_rank_id"]);
		    return Redirect::to('admin/maintenance/slots');
		}
		
		if(isset($_POST['slot_id_to_fs']))
		{
			$message = $this->change_cd_to_fs($_POST['slot_id_to_fs']);

			$data["name_message"] = $message;

		}

        return view('admin.maintenance.slot',$data);
	}
	public function data()
	{
		$membership = Request::input('memid');

		if($membership == "")
		{
	        $_account = 		Tbl_slot::select(array("tbl_slot.*", "tbl_account.account_name", "tbl_membership.membership_name"))
	        						->rank()->membership()->account()->get();
		}
		else
		{
	        $_account = 		Tbl_slot::select(array("tbl_slot.*", "tbl_account.account_name", "tbl_membership.membership_name"))
	        					->rank()->membership()->account()->where('slot_membership',$membership)->get();
		}
		
	        return Datatables::of($_account)->addColumn('gen','<a href="admin/maintenance/slots/add?id={{$slot_id}}">GENE</a>/</br><a href="admin/maintenance/slots/view?id={{$slot_id}}">INFO</a>')
	        								->addColumn('info','<a href="admin/maintenance/slots/view?id={{$slot_id}}">INFO</a>')
	        								->addColumn('wallet','<a style="cursor:pointer;" class="adjust-slot" slot-id="{{$slot_id}}">{{App\Tbl_wallet_logs::id("$slot_id")->wallet()->sum("wallet_amount")}}</a>')
	        								->addColumn('slot_wallet_gc','<a style="cursor:pointer;" class="adjust-slot-gc" slot-id="{{$slot_id}}">{{App\Tbl_wallet_logs::id("$slot_id")->GC()->sum("wallet_amount")}}</a>')
	        								->addColumn('pup','<a style="cursor:pointer;" class="adjust-slot-PUP" slot-id="{{$slot_id}}">{{App\Tbl_pv_logs::where("owner_slot_id","$slot_id")->where("used_for_redeem",0)->where("type","PPV")->sum("amount") != 0 && $slot_type != "CD" ? App\Tbl_pv_logs::where("owner_slot_id","$slot_id")->where("used_for_redeem",0)->where("type","PPV")->sum("amount") : 0}}</a>')
	        								->addColumn('gup','{{App\Classes\Compute::count_gpv($slot_id)}}')
	        								->addColumn('sponsor','{{App\Tbl_slot::id("$slot_sponsor")->account()->first() == null ? "---" : "Slot #".App\Tbl_slot::id("$slot_sponsor")->account()->first()->slot_id."(".App\Tbl_slot::id("$slot_sponsor")->account()->first()->account_name.")"}}')
	        								->addColumn('placement','{{App\Tbl_slot::id("$slot_placement")->account()->first() == null ? "---" : "Slot #".App\Tbl_slot::id("$slot_placement")->account()->first()->slot_id."(".App\Tbl_slot::id("$slot_placement")->account()->first()->account_name.")"}}')
	        								->addColumn('position','{{App\Tbl_slot::id("$slot_placement")->account()->first() == null ? "---" : strtoupper($slot_position)}}')
	        								->addColumn('rank','<a style="cursor:pointer;" class="adjust-rank" slot-id="{{$slot_id}}" rank_id="{{$permanent_rank_id}}">{{App\Tbl_compensation_rank::where("compensation_rank_id","$permanent_rank_id")->first()->compensation_rank_name}}</a>')
	        								->addColumn('login','<form method="POST" form action="admin/maintenance/accounts" target="_blank"><input type="hidden" class="token" name="_token" value="{{ csrf_token() }}"><button name="login" type="submit" value="{{$slot_owner}}" class="form-control">Login</button></form>')
	        								->make(true);

	}
	public function add()
	{

		if(Request::input("id") != "")
		{
			$data["slot"] = Tbl_slot::rank()->membership()->account()->id(Request::input("id"))->first();
			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." Visits Slot Genealogy of slot #".Request::input('id'));
		}
		else
		{
			$data["slot"] = Tbl_slot::rank()->membership()->account()->first();
			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." Visits Slot Genealogy of slot #".$data["slot"]->slot_id);
		}
		
		return view('admin.maintenance.slot_add', $data);
	}
	public function add_form()
	{
		$data["page"] = "Slot Add Form";
		$data["position"] = Request::input("position");
		$data["placement"] = Request::input("placement");
		$data["_account"] = Tbl_account::get();
		$data["_membership"] = Tbl_membership::where('membership_entry',1)->get();
		$data["_rank"] = Tbl_rank::get();
		$data["_country"] = Tbl_country::get();
		$data["slot_number"] = Tbl_slot::max("slot_id") + 1;

		return view('admin.maintenance.slot_add_form', $data);
	}
	public function edit_form()
	{
		$data["page"] = "Slot Add Form";
		$data["slot"] = Tbl_slot::rank()->membership()->account()->id(Request::input("slot_id"))->first();
		$data["wallet"] = Tbl_wallet_logs::id(Request::input('slot_id'))->wallet()->sum('wallet_amount');
		$data["position"] = Request::input("position");
		$data["placement"] = Request::input("placement");
		$data["_account"] = Tbl_account::get();
		$data["_membership"] = Tbl_membership::get();
		$data["_rank"] = Tbl_rank::get();
		$data["_country"] = Tbl_country::get();
		$data["slot_number"] = Tbl_slot::max("slot_id") + 1;

		$data["allow_button"] = DB::table('tbl_settings')->where('key','allow_update')->first();

		if(!$data['allow_button'])
		{
			DB::table('tbl_settings')->insert(["key"=>"allow_update","value"=>"developer"]);
			$data["allow_button"] = DB::table('tbl_settings')->where('key','allow_update')->first();
		}
		$data["allow_button"] = DB::table('tbl_settings')->where('key','allow_update')->first()->value;
		$data['user'] = Session::get('admin')['username'];
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." view Slot #".Request::input('slot_id'));
		return view('admin.maintenance.slot_edit_form', $data);
	}
	public function add_form_submit()
	{

		$return["message"] = "";
		$data["message"] = "";

	 	$limit = DB::table('tbl_settings')->where('key','slot_limit')->first();
		$count = Tbl_slot::where('slot_owner',Request::input("account_id"))->count();
		if($limit->value <=  $count)
		{
			$data["message"] = "This account is already reach the max slot per account. Max slot per account is ".$limit->value.".";
		}

		$get_price = Tbl_membership::where('membership_id',Request::input("slot_membership"))->first();

		$amount_of_wallet = Request::input("wallet");

		if(Request::input("slot_type") == "CD")
		{
			if(Request::input("wallet") < 0)
			{
				$amount_of_wallet = Request::input("wallet");
			}
			else
			{

				$amount_of_wallet = 0 - $get_price->membership_price;
			}
		}	

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
			// $insert["slot_wallet"] =  Request::input("wallet");
			$insert["slot_sponsor"] =  Request::input("sponsor");
			$insert["slot_placement"] =  Request::input("placement");
			$insert["slot_position"] =  strtolower(Request::input("slot_position"));
			$insert["slot_binary_left"] =  Request::input("binary_left");
			$insert["slot_binary_right"] =  Request::input("binary_right");
			$insert["slot_personal_points"] =  Request::input("personal_pv");
			$insert["slot_group_points"] =  Request::input("group_pv");
			$insert["slot_upgrade_points"] =  Request::input("upgrade_points");
			$insert["slot_total_withrawal"] =  Request::input("total_withrawal");
			$insert["membership_entry_id"] = Request::input("slot_membership");
			$insert["slot_total_earning"] =  Request::input("total_earning");
			$insert["distributed"] =  0;
			$insert["slot_owner"] = $account_id;
			$insert["created_at"] = Carbon\Carbon::now();
			$slot_id = Tbl_slot::insertGetId($insert);

			$logs = "Your slot #".$slot_id." is created by admin (".Admin::info()->account_name.").";
			Log::slot($slot_id, $logs,$amount_of_wallet, "New Slot",$slot_id);

			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." create new slot #".$slot_id,null,serialize($insert));
			
			Compute::tree($slot_id);
			Compute::entry($slot_id,"SLOT CREATION");

			Tbl_slot::where('slot_id',$slot_id)->update(['distributed'=>1]);
			$return["placement"] = Request::input("placement");
		}
		
		echo json_encode($return);
	}
	public function add_form_submit_message()
	{	

		$return["message"] = "";
		$data["message"] = "";
		
		if(Request::input("account_id") == 0)
		{
			// $data = $this->add_form_submit_new_account($data);
			// $account_id = $data["account_id"];
		}
		else
		{
			$account_id = Request::input("account_id");
		}

		$check_placement = Tbl_slot::checkposition(Request::input("placement"), strtolower(Request::input("slot_position")))->first();
		$check_id = Tbl_slot::id(Request::input("slot_number"))->first();
		$check_username = Tbl_account::where('account_username',Request::input('un'))->first();
		if($check_placement)
		{
			$return["message"] = "The position you're trying to use is already occupied";
		}
		elseif($check_username)
		{
			$return["message"] = "This username is already taken.";
		}
		elseif($data["message"] != "")
		{
			$return["message"] = $data["message"];
		}
		else
		{
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
			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." create new account #".$data["account_id"],null,serialize($insert));
		}

		return $data;
	}
	public function edit_form_submit()
	{
		$return["message"] = "";

		$data["slot"] = Tbl_slot::id(Request::input("slot_id"))->first();
		$old  = DB::table('tbl_slot')->where('slot_id',Request::input('slot_id'))->first();
		$update["slot_owner"] = Request::input("account_id");
		$update["slot_binary_left"] = Request::input("binary_left");
		$update["slot_binary_right"] = Request::input("binary_right");
		$update["slot_personal_points"] = Request::input("group_pv");
		$update["slot_group_points"] = Request::input("personal_pv");
		$update["slot_membership"] = Request::input("slot_membership");
		$update["slot_type"] = Request::input("slot_type");
		$update["slot_upgrade_points"] = Request::input("upgrade_points");
		// $update["slot_wallet"] = Request::input("wallet");
		$update["slot_total_withrawal"] =  Request::input("total_withrawal");
		$update["slot_total_earning"] =  Request::input("total_earning");
		$update["hack_reference"] = Request::input("hack_reference");
		Tbl_slot::where('slot_id', Request::input("slot_id"))->update($update);

		$logs = "Your slot #".Request::input('slot_id')." update your slot wallet to <b>".number_format(Request::input("wallet"),2)." wallet</br> (".Admin::info()->account_name.").";
		$wallet = Tbl_wallet_logs::id(Request::input('slot_id'))->wallet()->sum('wallet_amount');
		$wallet =  Request::input('wallet') - $wallet;
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." edit Slot #".Request::input("slot_id"),serialize($old),serialize($update));
		
		if(Request::input('wallet') != 0)
		{
			Log::slot(Request::input("slot_id"), $logs,$wallet, "Update Slot",Request::input("slot_id"));			
		}

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
			$sum_of_wallet = Tbl_wallet_logs::wallet()->where('slot_id',$slot_info->slot_id)->sum('wallet_amount');
			
			$return = 	'<li class="width-reference">
                            <span class="parent parent-reference ' . $slot_info->slot_type . '" placement=' . $slot_id . ' position="' . $position . '" slot_id="' . $slot_info->slot_id . '">   
                                <div class="id">' . $slot_info->slot_id . '</div>
                                <div class="name">' . $slot_info->account_name . '</div>
                                <div class="membership">' . $slot_info->membership_name . ' (' . $slot_info->slot_type . ')</div>
                                <div class="wallet">' . number_format($sum_of_wallet, 2) . '</div>
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
	public function delete()
	{
		$return["message"] = "";
		$slot_info = Tbl_slot::id(Request::input("slot_id"))->first();
		$return["placement"] = $slot_info->slot_placement;

		$check_downline_exist = Tbl_slot::where("slot_placement", Request::input("slot_id"))->first();

 		if($check_downline_exist)
 		{
 			$return["message"] = "You can't delete a slot with downline(s).";
 		}
 		else
 		{
 			Compute::delete_slot(Request::input('slot_id'));
 			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." delete Slot #".Request::input("slot_id"),serialize($slot_info));
 			Tbl_slot::id(Request::input("slot_id"))->delete();
 		}

		echo json_encode($return);
	}

	public function confirm_delete()
	{


		$password = Crypt::decrypt(Admin::info()->account_password);

 		if($password != Request::input('password'))
 		{
 			$return["message"] = "Wrong password.";
 		}
 		else
 		{
 			$return["message"] = null;
 		}

		echo json_encode($return);
	}

	public function info()
	{
		$data["page"] = "Slot";
		$data["slot"] = Tbl_slot::rank()->membership()->account()->id(Request::input("id"))->first();
		$data["slot"]->slot_wallet = Tbl_wallet_logs::id(Request::input('id'))->wallet()->sum('wallet_amount');

		if(isset($_POST['slot_id']))
		{
			$slot = Tbl_slot::rank()->membership()->account()->id(Request::input("id"))->first();
			if($slot->slot_type == "CD")
			{
				$wallet = Tbl_wallet_logs::id(Request::input('id'))->wallet()->sum('wallet_amount');
				$slot_id = Request::input('id');
				$wallet = -1 * $wallet;
                $update["slot_type"] = "PS";
                $message = "Your slot #".$slot_id." becomes a paid slot.";

                Log::slot($slot_id, $message, $wallet, "CD to PS",$slot_id);

                $vouch = DB::table('tbl_voucher')->where('slot_id',$slot_id)->first();
                if($vouch)
                {
                    $check = Tbl_voucher::where('tbl_voucher.voucher_id',$vouch->voucher_id)->update(["status"=>"unclaimed"]);
                }

                Compute::binary($slot_id, "CD TO PS");
                Compute::direct($slot_id, "CD TO PS");
                Tbl_slot::where('slot_id',$slot_id)->update($update);
                $new_slot = Tbl_slot::rank()->membership()->account()->id(Request::input("id"))->first();
				Log::Admin(Admin::info()->account_id,Admin::info()->account_username." used the Convert to PS on slot #".Request::input('id'),serialize($slot),serialize($new_slot));
                

                return Redirect::to('/admin/maintenance/slots');
			}
			else
			{
				dd("This slot is not a CD.");
			}
		}
		// $data["position"] = Request::input("position");
		// $data["placement"] = Request::input("placement");
		// $data["_account"] = Tbl_account::get();
		// $data["_membership"] = Tbl_membership::get();
		// $data["_rank"] = Tbl_rank::get();
		// $data["_country"] = Tbl_country::get();
		// $data["slot_number"] = Tbl_slot::max("slot_id") + 1;

		return view('admin.maintenance.slot_info',$data);
	}

	public function computeAdjustmentAjax()
	{

		$slot_id = Request::input('slot_id');
		$slot_adjustment = Request::input('wallet_adjustment');
		$wallet_adjustment_amount  = Request::input('wallet_adjustment_amount');
		
		$data = $this->computeAdjustment($slot_id, $slot_adjustment, $wallet_adjustment_amount);
		return json_encode($data);

	}

	public function adjustWallet()
	{
		$data['errors'] = [];

		$slot_id = Request::input('slot_id');
		$slot_adjustment = Request::input('wallet_adjustment');
		$wallet_adjustment_amount  = (double) Request::input('wallet_adjustment_amount');
		$wallet_adjustment_amount_formated = number_format($wallet_adjustment_amount, 2);
		
		$rules['slot_id'] = 'required|exists:tbl_slot,slot_id';
		$rules['wallet_adjustment_amount'] = 'required|numeric|min:1';
		$rules['wallet_adjustment'] = 'foo';
		$messages['wallet_adjustment.foo'] = "Invalid wallet ajustment method.";
		Validator::extend('foo', function($attribute, $value, $parameters, $validator) {
            return $value == 'add' || $value == 'deduct';
        });

		$validator = validator::make(Request::input(), $rules, $messages);
		if ($validator->fails()) {

			$data['errors'] = $validator->errors()->all();
  
        }
        else
        {
	        $data = $this->computeAdjustment($slot_id, $slot_adjustment, $wallet_adjustment_amount);
	        $data['errors'] = [];
	      
			switch ($slot_adjustment)
			{
				case 'add':
					$logs = "Added $wallet_adjustment_amount_formated from system adjustment.";
					break;
				
				default:
					$logs = "Deducted $wallet_adjustment_amount_formated from system adjustment.";
					$wallet_adjustment_amount = (double) ("-".$wallet_adjustment_amount);
					/* Deduct */
					break;
			}
			
			Log::slot($slot_id, $logs, $wallet_adjustment_amount, "System Adjusment" , 1);
        }


        return json_encode($data);
	}


	public function computeAdjustment($slot_id, $slot_adjustment, $wallet_adjustment_amount)
	{
		$wallet_adjustment_amount = (double) $wallet_adjustment_amount;
		$current_wallet_amount = DB::table('tbl_wallet_logs')->where('slot_id', $slot_id)->where('wallet_type', 'Wallet')->sum('wallet_amount');

		switch ($slot_adjustment)
		{
			case 'add':
				$current_wallet_amount = $current_wallet_amount + $wallet_adjustment_amount;
				break;
			
			default:
				/* Deduct */
				$current_wallet_amount = $current_wallet_amount - $wallet_adjustment_amount;
				break;
		}

		$data['slot_id'] = $slot_id;
		$data['slot_adjustment'] = $slot_adjustment;
		$data['wallet_adjustment_amount'] = $wallet_adjustment_amount;
		$data['current_wallet_amount'] = $current_wallet_amount;

		return $data;
	}



	public function computeAdjustmentAjaxGC()
	{

		$slot_id = Request::input('slot_id');
		$slot_adjustment = Request::input('wallet_adjustment_gc');
		$wallet_adjustment_amount  = Request::input('wallet_adjustment_amount_gc');
		
		$data = $this->computeAdjustmentGC($slot_id, $slot_adjustment, $wallet_adjustment_amount);
		return json_encode($data);

	}

	public function adjustWalletGC()
	{
		$data['errors'] = [];

		$slot_id = Request::input('slot_id');
		$slot_adjustment = Request::input('wallet_adjustment_gc');
		$wallet_adjustment_amount  = (double) Request::input('wallet_adjustment_amount_gc');
		$wallet_adjustment_amount_formated = number_format($wallet_adjustment_amount, 2);
		
		$rules['slot_id'] = 'required|exists:tbl_slot,slot_id';
		$rules['wallet_adjustment_amount_gc'] = 'required|numeric|min:1';
		$rules['wallet_adjustment_gc'] = 'foo';
		$messages['wallet_adjustment_gc.foo'] = "Invalid wallet ajustment method.";
		Validator::extend('foo', function($attribute, $value, $parameters, $validator) {
            return $value == 'add' || $value == 'deduct';
        });

		$validator = validator::make(Request::input(), $rules, $messages);
		if ($validator->fails()) {

			$data['errors'] = $validator->errors()->all();
  
        }
        else
        {
	        $data = $this->computeAdjustment($slot_id, $slot_adjustment, $wallet_adjustment_amount);
	        $data['errors'] = [];
	      
			switch ($slot_adjustment)
			{
				case 'add':
					$logs = "Added $wallet_adjustment_amount_formated GC from system adjustment.";
					break;
				
				default:
					$logs = "Deducted $wallet_adjustment_amount_formated GC from system adjustment.";
					$wallet_adjustment_amount = (double) ("-".$wallet_adjustment_amount);
					/* Deduct */
					break;
			}
			
			Log::slot($slot_id, $logs, $wallet_adjustment_amount, "System Adjusment" , 1,1);
        }


        return json_encode($data);
	}


	public function computeAdjustmentGC($slot_id, $slot_adjustment, $wallet_adjustment_amount)
	{
		$wallet_adjustment_amount = (double) $wallet_adjustment_amount;
		$current_wallet_amount = DB::table('tbl_wallet_logs')->where('slot_id', $slot_id)->where('wallet_type', 'GC')->sum('wallet_amount');

		switch ($slot_adjustment)
		{
			case 'add':
				$current_wallet_amount = $current_wallet_amount + $wallet_adjustment_amount;
				break;
			
			default:
				/* Deduct */
				$current_wallet_amount = $current_wallet_amount - $wallet_adjustment_amount;
				break;
		}

		$data['slot_id'] = $slot_id;
		$data['slot_adjustment_gc'] = $slot_adjustment;
		$data['wallet_adjustment_amount_gc'] = $wallet_adjustment_amount;
		$data['current_wallet_amount_gc'] = $current_wallet_amount;

		return $data;
	}







	public function computeAdjustmentAjaxPUP()
	{

		$slot_id = Request::input('slot_id');
		$slot_adjustment = Request::input('wallet_adjustment_PUP');
		$wallet_adjustment_amount  = Request::input('wallet_adjustment_amount_PUP');
		
		$data = $this->computeAdjustmentPUP($slot_id, $slot_adjustment, $wallet_adjustment_amount);
		return json_encode($data);

	}

	public function adjustWalletPUP()
	{
		$data['errors'] = [];

		$slot_id = Request::input('slot_id');
		$slot_adjustment = Request::input('wallet_adjustment_PUP');
		$wallet_adjustment_amount  = (double) Request::input('wallet_adjustment_amount_PUP');
		$wallet_adjustment_amount_formated = number_format($wallet_adjustment_amount, 2);
		
		$rules['slot_id'] = 'required|exists:tbl_slot,slot_id';
		$rules['wallet_adjustment_amount_PUP'] = 'required|numeric|min:1';
		$rules['wallet_adjustment_PUP'] = 'foo';
		$messages['wallet_adjustment_PUP.foo'] = "Invalid wallet personal UPcoins method.";
		Validator::extend('foo', function($attribute, $value, $parameters, $validator) {
            return $value == 'add' || $value == 'deduct';
        });

		$validator = validator::make(Request::input(), $rules, $messages);
		if ($validator->fails()) {

			$data['errors'] = $validator->errors()->all();
  
        }
        else
        {
	        $data = $this->computeAdjustmentPUP($slot_id, $slot_adjustment, $wallet_adjustment_amount);
	        $data['errors'] = [];
	      
			switch ($slot_adjustment)
			{
				case 'add':
					$logs = "Added $wallet_adjustment_amount_formated Personal UPcoins from system adjustment.";
					break;
				
				default:
					$logs = "Deducted $wallet_adjustment_amount_formated Personal UPcoins from system adjustment.";
					$wallet_adjustment_amount = (double) ("-".$wallet_adjustment_amount);
					/* Deduct */
					break;
			}

			Log::slot($slot_id, $logs, 0, "System Adjusment" , 1);
				        
	        $insert_personal["owner_slot_id"]   = $slot_id;
	        $insert_personal["amount"]          = $wallet_adjustment_amount;
	        $insert_personal["detail"]          = $logs;
	        $insert_personal["date_created"]    = Carbon\Carbon::now();
	        $insert_personal["type"]            = "PPV";
	        
	        $slot_info = Tbl_slot::where("slot_id",$slot_id)->first();
	        if($slot_info->slot_type != "CD")
	        {
	    	   DB::table("tbl_pv_logs")->insert($insert_personal);
	        }
	        Compute::compensation_rank($slot_id);
	        // Compute::check_compensation_rank($slot_id);
        }
        
        return json_encode($data);
	}

	public function computeAdjustmentPUP($slot_id, $slot_adjustment, $wallet_adjustment_amount)
	{
		$wallet_adjustment_amount = (double) $wallet_adjustment_amount;
		$current_wallet_amount = DB::table('tbl_pv_logs')->where('owner_slot_id', $slot_id)->where("used_for_redeem",0)->where('type', 'PPV')->sum('amount');

		switch ($slot_adjustment)
		{
			case 'add':
				$current_wallet_amount = $current_wallet_amount + $wallet_adjustment_amount;
				break;
			
			default:
				/* Deduct */
				$current_wallet_amount = $current_wallet_amount - $wallet_adjustment_amount;
				break;
		}

		$data['slot_id'] = $slot_id;
		$data['slot_adjustment_PUP'] = $slot_adjustment;
		$data['wallet_adjustment_amount_PUP'] = $wallet_adjustment_amount;
		$data['current_wallet_amount_PUP'] = $current_wallet_amount;

		return $data;
	}
	
	public function change_cd_to_fs($id)
	{
		$message = "";
		$check	 = Tbl_slot::where("slot_id",$id)->first();
		if($check)
		{
			if($check->slot_type == "CD")
			{
				$update["slot_type"] = "FS";
									   Tbl_slot::where("slot_id",$id)->update($update);
				$new_check			 = Tbl_slot::where("slot_id",$id)->first();
				Log::Admin(Admin::info()->account_id,Admin::info()->account_username." converted slot #".$id." to FS",serialize($check),serialize($new_check));
				
				$message = "Success";
			}
			else
			{
				$message = "This slot cannot be converted to FS";
			}
		}
		else
		{
			$message = "Slot doesn't exists";
		}
		return $message;
	}	
	
	public function dl_member()
	{
		 $_slot      = Tbl_slot::select(array("tbl_slot.*", "tbl_account.account_name", "tbl_membership.membership_name"))->rank()->membership()->account()->get();          

		 Excel::create("1", function($excel) use($_slot)
		 {
             $excel->sheet('Account Slot', function($sheet) use($_slot)
             {
             	   $sheet->appendRow(1, array("Slot","Owner","Placement","Position","Sponsor","Type","Wallet","GC","P UP","G UP","Rank"));
             	   $ctr = 2;
             	   foreach($_slot as $slot)
             	   {
             	   	 $sheet->appendRow
             	   	 ($ctr, 
             	   		array(
             	   			$slot->slot_id,
             	   			$slot->account_name,
             	   			Tbl_slot::id($slot->slot_placement)->account()->first() == null ? "---" : "Slot #".Tbl_slot::id($slot->slot_placement)->account()->first()->slot_id."(".Tbl_slot::id($slot->slot_placement)->account()->first()->account_name.")",
             	   			$slot->slot_position,
             	   			Tbl_slot::id($slot->slot_sponsor)->account()->first() == null ? "---" : "Slot #".Tbl_slot::id($slot->slot_sponsor)->account()->first()->slot_id."(".Tbl_slot::id($slot->slot_sponsor)->account()->first()->account_name.")",
             	   			$slot->slot_type,
             	   			Tbl_wallet_logs::id($slot->slot_id)->wallet()->sum("wallet_amount") == null ? "0" : Tbl_wallet_logs::id($slot->slot_id)->wallet()->sum("wallet_amount"),
             	   			Tbl_wallet_logs::id($slot->slot_id)->GC()->sum("wallet_amount") == null ? "0" : Tbl_wallet_logs::id($slot->slot_id)->GC()->sum("wallet_amount"),
             	   			Tbl_pv_logs::where("owner_slot_id",$slot->slot_id)->where("used_for_redeem",0)->where("type","PPV")->sum("amount") != 0 && $slot->slot_type != "CD" ? Tbl_pv_logs::where("owner_slot_id",$slot->slot_id)->where("used_for_redeem",0)->where("type","PPV")->sum("amount") : 0,
             	   			Compute::count_gpv($slot->slot_id),
             	   			Tbl_compensation_rank::where("compensation_rank_id",$slot->permanent_rank_id)->first()->compensation_rank_name
             	   			)
             	   	 );
             	   	 $ctr++;
             	   }
             	   
             });
         })->export('xls');	
		
		
		
		dd("Success");
		
		
		
		/* COUNT */
		 //$current_number    = 2;
		 //$current_slot_id   = null;
		 //$divided           = 13;
		 //$_slot             = null;
		 //$_slot2			= null;
		 //$_slot3			= null;
		 //$_slot4			= null;
		 //$_slot5			= null;
		 //$_slot6			= null;
		 //$_slot7			= null;
		 //$_slot8			= null;
		 //$_slot9			= null;
		 //$_slot10			= null;
		 //$_slot11			= null;
		 //$_slot12			= null;
		 //$_slot13			= null;
		 //$_slot14			= null;
		 
  	// 	 $_slot                = Tbl_slot::select(array("tbl_slot.*", "tbl_account.account_name", "tbl_membership.membership_name"))->rank()->membership()->account()->take(1000)->get();          
 		
 		
 		//  $current_slot_id      = end($_slot);
		 //if($current_slot_id)
		 //{
	 	//  	$current_slot_id   = end($current_slot_id);
		 //	$current_slot_id   = $current_slot_id = $current_slot_id->slot_id;
		 //}
		
		 //if($current_slot_id)
		 //{
			//  $_slot2               = Tbl_slot::where("slot_id",">",$current_slot_id)->select(array("tbl_slot.*", "tbl_account.account_name", "tbl_membership.membership_name"))->rank()->membership()->account()->take(1000)->get();  
	  //		 $current_slot_id      = end($_slot2);
			//  if($current_slot_id)
			//  {
		 //	 	$current_slot_id   = end($current_slot_id);
			//  	$current_slot_id   = $current_slot_id = $current_slot_id->slot_id;
			//  }
		 //}
		
		 //if($current_slot_id)
		 //{
			//  $_slot3               = Tbl_slot::where("slot_id",">",$current_slot_id)->select(array("tbl_slot.*", "tbl_account.account_name", "tbl_membership.membership_name"))->rank()->membership()->account()->take(1000)->get();  
	  //		 $current_slot_id      = end($_slot3);
			//  if($current_slot_id)
			//  {
		 //	 	$current_slot_id   = end($current_slot_id);
			//  	$current_slot_id   = $current_slot_id = $current_slot_id->slot_id;
			//  }
		 //}
		
		 //if($current_slot_id)
		 //{
			//  $_slot4               = Tbl_slot::where("slot_id",">",$current_slot_id)->select(array("tbl_slot.*", "tbl_account.account_name", "tbl_membership.membership_name"))->rank()->membership()->account()->take(1000)->get();  
	  //		 $current_slot_id      = end($_slot4);
			//  if($current_slot_id)
			//  {
		 //	 	$current_slot_id   = end($current_slot_id);
			//  	$current_slot_id   = $current_slot_id = $current_slot_id->slot_id;
			//  }
		 //}
		
		 //if($current_slot_id)
		 //{
			//  $_slot5               = Tbl_slot::where("slot_id",">",$current_slot_id)->select(array("tbl_slot.*", "tbl_account.account_name", "tbl_membership.membership_name"))->rank()->membership()->account()->take(1000)->get();  
	  //		 $current_slot_id      = end($_slot5);
			//  if($current_slot_id)
			//  {
		 //	 	$current_slot_id   = end($current_slot_id);
			//  	$current_slot_id   = $current_slot_id = $current_slot_id->slot_id;
			//  }
		 //}
		
		 //if($current_slot_id)
		 //{
			//  $_slot6               = Tbl_slot::where("slot_id",">",$current_slot_id)->select(array("tbl_slot.*", "tbl_account.account_name", "tbl_membership.membership_name"))->rank()->membership()->account()->take(1000)->get();  
	  //		 $current_slot_id      = end($_slot6);
			//  if($current_slot_id)
			//  {
		 //	 	$current_slot_id   = end($current_slot_id);
			//  	$current_slot_id   = $current_slot_id = $current_slot_id->slot_id;
			//  }
		 //}
		
		 //if($current_slot_id)
		 //{
			//  $_slot7               = Tbl_slot::where("slot_id",">",$current_slot_id)->select(array("tbl_slot.*", "tbl_account.account_name", "tbl_membership.membership_name"))->rank()->membership()->account()->take(1000)->get();  
	  //		 $current_slot_id      = end($_slot7);
			//  if($current_slot_id)
			//  {
		 //	 	$current_slot_id   = end($current_slot_id);
			//  	$current_slot_id   = $current_slot_id = $current_slot_id->slot_id;
			//  }
		 //}
		
		 //if($current_slot_id)
		 //{
			//  $_slot8               = Tbl_slot::where("slot_id",">",$current_slot_id)->select(array("tbl_slot.*", "tbl_account.account_name", "tbl_membership.membership_name"))->rank()->membership()->account()->take(1000)->get();  
	  //		 $current_slot_id      = end($_slot8);
			//  if($current_slot_id)
			//  {
		 //	 	$current_slot_id   = end($current_slot_id);
			//  	$current_slot_id   = $current_slot_id = $current_slot_id->slot_id;
			//  }
		 //}
		
		 //if($current_slot_id)
		 //{
			//  $_slot9               = Tbl_slot::where("slot_id",">",$current_slot_id)->select(array("tbl_slot.*", "tbl_account.account_name", "tbl_membership.membership_name"))->rank()->membership()->account()->take(1000)->get();  
	  //		 $current_slot_id      = end($_slot9);
			//  if($current_slot_id)
			//  {
		 //	 	$current_slot_id   = end($current_slot_id);
			//  	$current_slot_id   = $current_slot_id = $current_slot_id->slot_id;
			//  }
		 //}
		
		 //if($current_slot_id)
		 //{
			//  $_slot10               = Tbl_slot::where("slot_id",">",$current_slot_id)->select(array("tbl_slot.*", "tbl_account.account_name", "tbl_membership.membership_name"))->rank()->membership()->account()->take(1000)->get();  
	  //		 $current_slot_id      = end($_slot10);
			//  if($current_slot_id)
			//  {
		 //	 	$current_slot_id   = end($current_slot_id);
			//  	$current_slot_id   = $current_slot_id = $current_slot_id->slot_id;
			//  }
		 //}
		
		 //if($current_slot_id)
		 //{
			//  $_slot11               = Tbl_slot::where("slot_id",">",$current_slot_id)->select(array("tbl_slot.*", "tbl_account.account_name", "tbl_membership.membership_name"))->rank()->membership()->account()->take(1000)->get();  
	  //		 $current_slot_id      = end($_slot11);
			//  if($current_slot_id)
			//  {
		 //	 	$current_slot_id   = end($current_slot_id);
			//  	$current_slot_id   = $current_slot_id = $current_slot_id->slot_id;
			//  }
		 //}
		
		 //if($current_slot_id)
		 //{
			//  $_slot12               = Tbl_slot::where("slot_id",">",$current_slot_id)->select(array("tbl_slot.*", "tbl_account.account_name", "tbl_membership.membership_name"))->rank()->membership()->account()->take(1000)->get();  
	  //		 $current_slot_id      = end($_slot12);
			//  if($current_slot_id)
			//  {
		 //	 	$current_slot_id   = end($current_slot_id);
			//  	$current_slot_id   = $current_slot_id = $current_slot_id->slot_id;
			//  }
		 //}
		
		 //if($current_slot_id)
		 //{
			//  $_slot13               = Tbl_slot::where("slot_id",">",$current_slot_id)->select(array("tbl_slot.*", "tbl_account.account_name", "tbl_membership.membership_name"))->rank()->membership()->account()->take(1000)->get();  
	  //		 $current_slot_id      = end($_slot13);
			//  if($current_slot_id)
			//  {
		 //	 	$current_slot_id   = end($current_slot_id);
			//  	$current_slot_id   = $current_slot_id = $current_slot_id->slot_id;
			//  }
		 //}
		
		 //if($current_slot_id)
		 //{
			//  $_slot14               = Tbl_slot::where("slot_id",">",$current_slot_id)->select(array("tbl_slot.*", "tbl_account.account_name", "tbl_membership.membership_name"))->rank()->membership()->account()->take(1000)->get();  
	  //		 $current_slot_id      = end($_slot14);
			//  if($current_slot_id)
			//  {
		 //	 	$current_slot_id   = end($current_slot_id);
			//  	$current_slot_id   = $current_slot_id = $current_slot_id->slot_id;
			//  }
		 //}
 	// ==================================================
 	
 	
 	     //dd($_slot,$_slot2,$_slot3,$_slot4,$_slot5,$_slot6,$_slot7,$_slot8,$_slot9,$_slot10,$_slot11,$_slot12,$_slot13,$_slot14);
		 //for($x = 1;$x<$divided; $x++)
		 //{
		 //	if(!isset($_slot.$current_number))
		 //	{
			//  	if($current_slot_id != null)
			//  	{
	
			//  		$_slot.$current_number = Tbl_slot::where("slot_id",">",$current_slot_id)->select(array("tbl_slot.*", "tbl_account.account_name", "tbl_membership.membership_name"))->rank()->membership()->account()->take(1000)->get();  
			//  		$current_slot_id        = end($_slot[$current_number]);
				
			// 		if($current_slot_id)
			// 		{
			// 	 		$current_slot_id    = end($current_slot_id);
			// 			$current_slot_id    = $current_slot_id = $current_slot_id->slot_id;
			// 		}
			// 		else
			// 		{
			// 			break;	
			// 		}
			//  	}
			//  	else
			//  	{
			//  		$_slot.$current_number = Tbl_slot::select(array("tbl_slot.*", "tbl_account.account_name", "tbl_membership.membership_name"))->rank()->membership()->account()->take(1000)->get();          
			//  		$current_slot_id        = end($_slot[$current_number]);
				
			// 		if($current_slot_id)
			// 		{
			// 	 		$current_slot_id    = end($current_slot_id);
			// 			$current_slot_id    = $current_slot_id = $current_slot_id->slot_id;
			// 		}
			// 		else
			// 		{
			// 			break;	
			// 		}
			//  	}
			//  	$current_number++;
		 //	}
		 //}
		 
		 
   //      $_slot = 		    Tbl_slot::select(array("tbl_slot.*", "tbl_account.account_name", "tbl_membership.membership_name"))
   //     							->rank()->membership()->account()->take(1000)->get();   
        							
        							
		 //$_slot2 = 		    Tbl_slot::select(array("tbl_slot.*", "tbl_account.account_name", "tbl_membership.membership_name"))
   //     							->rank()->membership()->account()->take(1000)->get();

		// ->addColumn('wallet','<a style="cursor:pointer;" class="adjust-slot" slot-id="{{$slot_id}}">{{App\Tbl_wallet_logs::id("$slot_id")->wallet()->sum("wallet_amount")}}</a>')
		// ->addColumn('slot_wallet_gc','<a style="cursor:pointer;" class="adjust-slot-gc" slot-id="{{$slot_id}}">{{App\Tbl_wallet_logs::id("$slot_id")->GC()->sum("wallet_amount")}}</a>')
		// ->addColumn('pup','<a style="cursor:pointer;" class="adjust-slot-PUP" slot-id="{{$slot_id}}">{{App\Tbl_pv_logs::where("owner_slot_id","$slot_id")->where("used_for_redeem",0)->where("type","PPV")->sum("amount") != 0 && $slot_type != "CD" ? App\Tbl_pv_logs::where("owner_slot_id","$slot_id")->where("used_for_redeem",0)->where("type","PPV")->sum("amount") : 0}}</a>')
		// ->addColumn('gup','{{App\Classes\Compute::count_gpv($slot_id)}}')
		// ->addColumn('sponsor','{{App\Tbl_slot::id("$slot_sponsor")->account()->first() == null ? "---" : "Slot #".App\Tbl_slot::id("$slot_sponsor")->account()->first()->slot_id."(".App\Tbl_slot::id("$slot_sponsor")->account()->first()->account_name.")"}}')
		// ->addColumn('placement','{{App\Tbl_slot::id("$slot_placement")->account()->first() == null ? "---" : "Slot #".App\Tbl_slot::id("$slot_placement")->account()->first()->slot_id."(".App\Tbl_slot::id("$slot_placement")->account()->first()->account_name.")"}}')
		// ->addColumn('position','{{App\Tbl_slot::id("$slot_placement")->account()->first() == null ? "---" : strtoupper($slot_position)}}')
		// ->addColumn('rank','<a style="cursor:pointer;" class="adjust-rank" slot-id="{{$slot_id}}" rank_id="{{$permanent_rank_id}}">{{App\Tbl_compensation_rank::where("compensation_rank_id","$permanent_rank_id")->first()->compensation_rank_name}}</a>')
		// ->addColumn('login','<form method="POST" form action="admin/maintenance/accounts" target="_blank"><input type="hidden" class="token" name="_token" value="{{ csrf_token() }}"><button name="login" type="submit" value="{{$slot_owner}}" class="form-control">Login</button></form>')
	        													
		 //Excel::create("1", function($excel) use($_slot,$_slot2,$_slot3,$_slot4,$_slot5,$_slot6,$_slot7,$_slot8,$_slot9,$_slot10,$_slot11,$_slot12,$_slot13,$_slot14)
		 //{
   //          $excel->sheet('Account Slot', function($sheet) use($_slot,$_slot2,$_slot3,$_slot4,$_slot5,$_slot6,$_slot7,$_slot8,$_slot9,$_slot10,$_slot11,$_slot12,$_slot13,$_slot14)
   //          {
   //               $sheet->loadView('admin.report.account_slot_report', array('pageTitle' => 'Transaction History', '_slot' =>$_slot ,'_slot2' => $_slot2,'_slot3' => $_slot3,'_slot4' => $_slot4,'_slot5' => $_slot5,'_slot6' => $_slot6,'_slot7' => $_slot7,'_slot8' => $_slot8,'_slot9' => $_slot9,'_slot10' => $_slot10,'_slot11' => $_slot11,'_slot12' => $_slot12,'_slot13' => $_slot13,'_slot14' => $_slot14));
   //          });
   //      })->export('xls');
	}
}