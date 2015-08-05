<?php namespace App\Http\Controllers;
use App\Classes\Customer;
use DB;
use Request;
use Session;
use Redirect;
use Crypt;
use Carbon\Carbon;
use App\Tbl_account;
use App\Tbl_membership_code;
use App\Tbl_slot;
use App\Tbl_product_package_has;
use App\Tbl_product_package;
use App\Tbl_membership;
use App\Tbl_code_type;
use App\Tbl_inventory_update_type;
use Datatables;
use Validator;
use App\Tbl_tree_placement;
use App\Classes\Compute;
use App\Classes\Log;
use App\Tbl_voucher_has_product;
use App\Tbl_product_code;
use App\Rel_membership_product;
use App\Rel_membership_code;
use App\Tbl_voucher;
use App\Classes\Globals;
use App\Tbl_product;
use App\tbl_membership_code_sale;
use App\Tbl_lead;
class MemberCodeController extends MemberController
{
	public function index()
	{
		$id = Customer::id();
		$data = $this->getslotbyid($id);
		$data['_error'] = Session::get('message');
		$data['success']  = Session::get('success');
		$data['availprod'] = Tbl_product_package::where('archived',0)->get();
		$data['membership2'] = 	    					 DB::table('tbl_membership')->where('archived',0)
	    												 ->orderBy('membership_price','ASC')
	    												 ->where('membership_entry',1)
	    												 ->get();
					
  		$data['exist_lead'] = null;
	 	$check_date = Tbl_lead::where('account_id',$id)->where('tbl_lead.used',0)->first();

	 	if(isset($check_date))
	 	{	
		    	 	if(strtotime($check_date->join_date)  > strtotime(Carbon::now()->subDays(30)) && $check_date->used == 0)
				 	{
		    			$data['exist_lead'] = Tbl_lead::where('tbl_lead.account_id',$id)->getslot()->get();
				 	}
	 	}
											 
	    $data['getlead'] = Tbl_lead::where('lead_account_id',Customer::id())->getaccount()->get();
		if($data['availprod'])
		{
			foreach($data['availprod'] as $key => $d)
			{
				$s = Tbl_product_package_has::where('product_package_id',$d->product_package_id)->product()->get();
				$data['availprod'][$key]->productlist  = json_encode($s);
			}	
		}


		$s = Tbl_account::where('tbl_account.account_id',$id)->belongstothis()->get();
		// $j = Tbl_voucher_has_product::product()->voucher()->productcode()->where('account_id',Customer::id())->where('tbl_product_code.used',0)->get();
		// $j = DB::table('tbl_voucher')->join('tbl_voucher_has_product','tbl_voucher_has_product.voucher_id','=','tbl_voucher.voucher_id')
		// 							 ->join('tbl_product_code','tbl_product_code.voucher_item_id','=','tbl_voucher_has_product.voucher_item_id')
		// 							 ->where('account_id',Customer::id())
		// 							 ->get();

		if(isset($_POST['sbmtclaim']))
		{
			$data['error'] = $this->claim_code(Request::input(),$id);
			return Redirect::to('member/code_vault')->with('message',$data['error']);
		}
		if(isset($_POST['unlockpass']))
		{
			$data['error'] = $this->unlock(Request::input('yuan'),Request::input('pass'),$id);
			return Redirect::to('member/code_vault')->with('message',$data['error']);
		}
		if(isset($_POST['unlockpass2']))
		{	
			$data['error'] = $this->unlock2(Request::input('yuan2'),Request::input('pass'),$id);
			return Redirect::to('member/code_vault')->with('message',$data['error']);
		}
		if(isset($_POST['codesbmt']))
		{
			$data['error'] = $this->transfer(Request::input('code'),Request::input('account'),Request::input('pass'),$id,$s);
			return Redirect::to('member/code_vault')->with('message',$data['error']);
		}
		if(isset($_POST['prodsbmt']))
		{
			$data['error'] = $this->transfer_code(Request::input('code'),Request::input('account'),Request::input('pass'),$id,$j,Request::input('voucher'));
			return Redirect::to('member/code_vault')->with('message',$data['error']);
		}

		if(isset($_POST['slot_position']))
		{	
			$info = $this->addslot(Request::input());
			if(isset($info['success']))
			{
				$message = $info['success'];
				return Redirect::to('member/code_vault')->with('success',$message);	
			}
		}
		if(isset($_POST['sbmitbuy']))
		{
			if( Request::input('memid') && Request::input('package'))
			{
				$info = $this->add_code(Request::input());	

				if(isset($info['success']))
				{
					$message = $info['success'];
					return Redirect::to('member/code_vault')->with('success',$message);	
				}
				else
				{
					$message = $info['_error'];
					return Redirect::to('member/code_vault')->with('message',$message);
				}
		
			}
		}

        return view('member.code_vault',$data);
	}

	public function use_product_code()
	{
		$customer_id = Customer::id();

		$product_pin = Request::input("product_pin");
		$slot_id = Request::input("slot");

		/* CHECK IF SLOT AND CODE PIN BELONGS TO THE ACCOUNT */
		$code_info = Tbl_product_code::where("product_pin", $product_pin)->voucher()->product()->first();
		$slot_info = Tbl_slot::id($slot_id)->first();

		if($customer_id != $code_info->account_id)
		{
			die("This code doesn't belong to this account.");
		}

		if($customer_id != $slot_info->slot_owner)
		{
			die("The slot you're trying to use doesn't belong to this account.");
		}

		if($code_info)
		{
			if($code_info->used == 1)
			{
				die("You're trying to code that was already used.");
			}
			else
			{
				$unilevel_pts = $code_info->unilevel_pts; 
				$binary_pts = $code_info->binary_pts;
				Compute::repurchase($slot_id, $binary_pts, $unilevel_pts);
				$update["used"] = 1;
				$code_info = Tbl_product_code::where("product_pin", $product_pin)->update($update);

                /* INSERT LOG FOR THAT A CODE WAS USED */
                $log = "You spent one of your Product Code (#" . $product_pin . ") for your slot #" . $slot_info->slot_id . " which contains <b>" . number_format($unilevel_pts, 2) . " unilevel points</b> and <b>" . number_format($binary_pts, 2) . " binary points</b>.";
                Log::account($slot_info->slot_owner, $log);
			}

		}


		return Redirect::to("/member/code_vault");
	}
	public function addslot($data)
	{

		$return["message"] = "";
		$data["message"] = "";

		if(strtolower(Request::input("slot_position")) == 'left' || strtolower(Request::input("slot_position")) == 'right')
		{
				$getslot = Tbl_membership_code::where('code_pin',$data['code_number'])->getmembership()->first();
				$check_placement = Tbl_slot::checkposition(Request::input("placement"), strtolower(Request::input("slot_position")))->first();
				$check_id = Tbl_slot::id(Request::input("slot_number"))->first();
				$checkifowned = Tbl_account::where('tbl_account.account_id',Customer::id())->belongstothis()->get();
				$ifused = Tbl_membership_code::where('code_pin',$data['code_number'])->where('used',1)->first();
				$checkslot = Tbl_slot::get();
				$checking = false;
				$checking2 = false;
				foreach($checkifowned as $c)
				{
					if($c->code_pin == $data['code_number'])
					{
						$checking = true;
					}
				}

				foreach($checkslot as $c)
				{
					if($c->slot_id == $data['sponsor'])
					{
						$checking2 = true;
					}
				}

				if($check_placement)
				{
					$return["message"] = "The position you're trying to use is already occupied";
				}
				elseif($ifused)
				{
					$return["message"] = "This code is already used";
				}
				elseif($data["message"] != "")
				{
					$return["message"] = $data["message"];
				}
				else
				{
					if($getslot->code_type_id == 3)
					{
						if($checking == true && $checking2 == true)
						{
							$insert["slot_membership"] =  $getslot->membership_id;
							$insert["slot_type"] =  "CD";
							$insert["slot_rank"] =  1;
							$insert["slot_wallet"] =  0 - $getslot->membership_price;
							$insert["slot_sponsor"] =  $data['sponsor'];
							$insert["slot_placement"] =  $data['placement'];
							$insert["slot_position"] =  strtolower($data['slot_position']);
							$insert["slot_binary_left"] =  0;
							$insert["slot_binary_right"] =  0;
							$insert["slot_personal_points"] =  0;
							$insert["slot_group_points"] =  0;
							$insert["slot_upgrade_points"] = 0;
							$insert["slot_total_withrawal"] =  0;
							$insert["slot_total_earning"] =  0;
							$insert["created_at"] =  Carbon::now();
							$insert["slot_owner"] =  Customer::id();
							$insert["membership_entry_id"] =  $getslot->membership_id;
							$slot_id = Tbl_slot::insertGetId($insert);
							Compute::tree($slot_id);
							Compute::binary($slot_id);
							$return["placement"] = Request::input("placement");
							Tbl_membership_code::where('code_pin',$data['code_number'])->update(['used'=>1]);
							$message['success'] = "Slot Created.";
							$get = Rel_membership_code::where('code_pin',$data['code_number'])->first();
							$insert2['slot_id'] = $slot_id;
							$insert2['product_package_id'] = $get->product_package_id;
							Rel_membership_product::insert($insert2);
							return $message;
						}
					}
					else if($getslot->code_type_id == 1)
					{
						if($checking == true && $checking2 == true)
						{
							$insert["slot_membership"] =  $getslot->membership_id;
							$insert["slot_type"] =  "PS";
							$insert["slot_rank"] =  1;
							$insert["slot_wallet"] =  0;
							$insert["slot_sponsor"] =  $data['sponsor'];
							$insert["slot_placement"] =  $data['placement'];
							$insert["slot_position"] =  strtolower($data['slot_position']);
							$insert["slot_binary_left"] =  0;
							$insert["slot_binary_right"] =  0;
							$insert["slot_personal_points"] =  0;
							$insert["slot_group_points"] =  0;
							$insert["slot_upgrade_points"] = 0;
							$insert["slot_total_withrawal"] =  0;
							$insert["slot_total_earning"] =  0;
							$insert["created_at"] =  Carbon::now();
							$insert["slot_owner"] =  Customer::id();
							$insert["membership_entry_id"] =  $getslot->membership_id;
							$slot_id = Tbl_slot::insertGetId($insert);
							Compute::tree($slot_id);
							Compute::binary($slot_id);
							$return["placement"] = Request::input("placement");
							Tbl_membership_code::where('code_pin',$data['code_number'])->update(['used'=>1]);
							$message['success'] = "Slot Created.";
							$get = Rel_membership_code::where('code_pin',$data['code_number'])->first();
							$insert2['slot_id'] = $slot_id;
							$insert2['product_package_id'] = $get->product_package_id;
							Rel_membership_product::insert($insert2);
							return $message;
						}
					}
					else
					{
						if($checking == true && $checking2 == true)
						{
							$insert["slot_membership"] =  $getslot->membership_id;
							$insert["slot_type"] =  "FS";
							$insert["slot_rank"] =  1;
							$insert["slot_wallet"] =  0;
							$insert["slot_sponsor"] =  $data['sponsor'];
							$insert["slot_placement"] =  $data['placement'];
							$insert["slot_position"] =  strtolower($data['slot_position']);
							$insert["slot_binary_left"] =  0;
							$insert["slot_binary_right"] =  0;
							$insert["slot_personal_points"] =  0;
							$insert["slot_group_points"] =  0;
							$insert["slot_upgrade_points"] = 0;
							$insert["slot_total_withrawal"] =  0;
							$insert["slot_total_earning"] =  0;
							$insert["created_at"] =  Carbon::now();
							$insert["slot_owner"] =  Customer::id();
							$insert["membership_entry_id"] =  $getslot->membership_id;
							$slot_id = Tbl_slot::insertGetId($insert);
							Compute::tree($slot_id);
							Compute::binary($slot_id);
							$return["placement"] = Request::input("placement");
							Tbl_membership_code::where('code_pin',$data['code_number'])->update(['used'=>1]);
							$message['success'] = "Slot Created.";
							$get = Rel_membership_code::where('code_pin',$data['code_number'])->first();
							$insert2['slot_id'] = $slot_id;
							$insert2['product_package_id'] = $get->product_package_id;
							Rel_membership_product::insert($insert2);
							return $message;
						}						
					}
					
				}			
		}
		else
		{
			$message = "";
			return $message;
		}

	}

	public function getslotbyid($id)
	{
		$data['code'] = DB::table('tbl_membership_code')  ->where('tbl_membership_code.archived',0)
														  ->where('tbl_membership_code.blocked',0)
														  ->where('tbl_membership_code.used',0)
														  ->join('tbl_account','tbl_account.account_id','=','tbl_membership_code.account_id')
														  ->join('tbl_code_type','tbl_code_type.code_type_id','=','tbl_membership_code.code_type_id')
														  ->join('tbl_membership','tbl_membership.membership_id','=','tbl_membership_code.membership_id')
														  ->leftjoin('tbl_product_package','tbl_product_package.product_package_id','=','tbl_membership_code.product_package_id')
														  ->where('tbl_membership_code.account_id','=',$id)
														  ->orderBy('tbl_membership_code.code_pin','ASC')
														  ->get();

		$data['getallslot'] = Tbl_slot::where('slot_owner',Customer::id())->get();

        foreach($data['code'] as $key => $d)
        {
        	$get =	 DB::table('tbl_member_code_history')->where('code_pin',$d->code_pin)
        												 ->join('tbl_account','tbl_account.account_id','=','tbl_member_code_history.by_account_id')
        											     ->orderBy('updated_at','DESC')
        											     ->first();

        	$data['code'][$key]->transferer = $get->account_name;	
        	$data['code'][$key]->encrypt    = Crypt::encrypt($d->code_pin);									     
        }


		$data['prodcode'] = Tbl_product_code::where("account_id", Customer::id())->where('tbl_product_code.used',0)->voucher()->product()->orderBy("product_pin", "desc")->unused()->get();										 
		$data['count']= DB::table('tbl_membership_code')->where('archived',0)->where('tbl_membership_code.used',0)->where('account_id','=',$id)->where('tbl_membership_code.blocked',0)->count();		
		$data['count2'] = Tbl_product_code::where("account_id", Customer::id())->where('tbl_product_code.used',0)->voucher()->product()->orderBy("product_pin", "desc")->unused()->count();										 
		
		if($data['count2'] == 0)
		{
			$data['prodcode'] = null;
		}

		return $data;
	}

	public function claim_code($data,$id)
	{
		$info = null;
		$pin = DB::table('tbl_membership_code')->where('lock',0)->where('code_pin','=',$data['pin'])->first();
		if($pin)
		{	
			$used = DB::table('tbl_membership_code')->where('used',1)->where('code_pin','=',$data['pin'])->first();
			if($used)
			{
				$info = "This code is already used";
			}
			else if($pin->account_id == $id) 
			{
				$info = "You already have this code";
			}

			else if($pin->code_activation == $data['activation'])
			{

				$getId = DB::table('tbl_membership_code')->where('code_pin','=',$data['pin'])->first();
				DB::table('tbl_membership_code')->where('code_pin','=',$data['pin'])->update(['account_id'=>$id]);
				$getName = DB::table('tbl_account')->where('account_id',$id)->first();
				$insert['code_pin'] = $data['pin'];
				$insert['by_account_id'] = $getId->account_id;
				$insert['to_account_id'] = $id;
				$insert['updated_at'] = Carbon::now();
				$insert['description'] = "Claimed by ".$getName->account_name;
				$pint = $data['pin'];
				$fromname = DB::table('tbl_account')->where('account_id',$getId->account_id)->first();
				DB::table("tbl_member_code_history")->insert($insert);
				Log::account(Customer::id(),"You claimed a membership code from $fromname->account_name  (Pin #$pint))");
				Log::account($fromname->account_id,"$getName->account_name claimed your membership code (Pin #$pint))");
			}
			else
			{
				$info = "Pin code's activation key mismatch.";
			}
		}
		else
		{
			$iflock = DB::table('tbl_membership_code')->where('lock',1)->where('code_pin','=',$data['pin'])->first();
			if($iflock)
			{
				$info = "This code is lock and cannot be claimed.";
			}
			else
			{
				$info = "Pin code doesn't exist.";	
			}
		}
			return $info;
	}

	public function transfer($code,$account,$pass,$id,$s)
	{
		$checking4 = false;
		$checking = false;
		$rpass = Tbl_account::where('account_id',$id)->first();
		$lead = Tbl_lead::where('lead_account_id',Customer::id())->getaccount()->get();
	    if($rpass != null)
		{	
			foreach($lead as $l)
			{
				if($l->account_id == $account)
				{
					$checking4 = true;
				}
			}
		}
		$rpass = Crypt::decrypt($rpass->account_password);
		$info = null;
		$checking2 = Tbl_membership_code::where('code_pin',$code)->where('used',1)->first();



		foreach($s as $key => $data)
		{
			if($data->code_pin == $code)
			{
				$checking = true;
			}
		}

		if($checking2)
		{
			$info = "This code is already used";
		}
		else if($checking == true)
		{
				if($checking4 == false)
				{
					$info = "Transfer failed";
				}
				else if($rpass == $pass)
				{
					$t = Tbl_account::where('account_id',$account)->first();
					Tbl_membership_code::where('code_pin',$code)->update(['account_id'=>$account]);
					Log::account(Customer::id(),"You transferred a membership code to $t->account_name (Pin #$code)");
					Log::account($account,Customer::info()->account_name." transferred a membership code to you. (Pin #$code)");
					$insert['code_pin'] = $code;
					$insert['by_account_id'] = Customer::id();
					$insert['to_account_id'] = $t->account_id;
					$insert['updated_at'] = Carbon::now();
					$insert['description'] = "Transferred a membership code. (Pin #$code)";
					DB::table("tbl_member_code_history")->insert($insert);
				}
				else
				{
					$info = "Wrong Password";	
				}
		}
		else
		{
			$info = "Transfer failed";
		}

		return $info;
	}

    public function transfer_code($code,$account,$pass,$id,$j,$voucherid)
	{
		$checking = false;
		$checking3 = false;
		$rpass = Tbl_account::where('account_id',$id)->first();
		$rpass = Crypt::decrypt($rpass->account_password);
		$info = null;
		$checking2 = Tbl_product_code::where('product_pin',$code)->where('used',1)->first();

		foreach($j as $key => $data)
		{
			if($data->product_pin == $code)
			{
				$checking = true;
			}
		}

		foreach($j as $key => $data)
		{
			if($data->voucher_id == $voucherid)
			{
				$checking3 = true;
			}
		}


		if($checking2)
		{
			$info = "This code is already used";
		}
		else if($checking == true && $checking3 == true)
		{
				if($rpass == $pass)
				{
					$t = Tbl_account::where('account_id',$account)->first();
					DB::table('tbl_voucher')->where('voucher_id',$voucherid)->update(['account_id'=>$account]);
					Log::account(Customer::id(),"You transferred a product code to $t->account_name (Pin #$code)");
					Log::account($account,Customer::info()->account_name." transferred a product code to you. (Pin #$code)");
				}
				else
				{
					$info = "Wrong Password";	
				}
		}
		else
		{
			$info = "Transfer failed";
		}

		return $info;
	}

	public function set_active()
	{
	  $pin = Request::input('pin');

	  DB::table('tbl_membership_code')->where('code_pin',$pin)->update(['lock'=>Request::input('value')]);
	}

	public function unlock($pin,$pass,$login)
	{
	  $info = null;
	  $checkpass = DB::table('tbl_membership_code')->where('code_pin',$pin)
	  											   ->join('tbl_account','tbl_account.account_id','=','tbl_membership_code.account_id')
	  											   ->first();

	  $login = DB::table('tbl_account')->where('account_id','=',$login)->first();


	  $checkpass = Crypt::decrypt($checkpass->account_password);
	  $login = Crypt::decrypt($login->account_password);

 	  if($login == $checkpass && $login == $pass && $pass == $checkpass)
 	  {
 	  	DB::table('tbl_membership_code')->where('code_pin',$pin)->update(['lock'=>0]);
 	  }
 	  else
 	  {
 	  	$info = "Incorrect Password";
 	  }

	  return $info;
	}
	public function code_generator()
	{
		
		$chars="0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$res = "";
		for ($i = 0; $i < 8; $i++) {
		    $res .= $chars[mt_rand(0, strlen($chars)-1)];
		}

		return $res;

	}

	public function check_code()
	{



		$stop=false;
		while($stop==false)
		{
			$code = $this->code_generator();

			$check = Tbl_membership_code::where('code_activation', $code )->first();
			if($check==null)
			{
				$stop = true;
			}
		}

		return $code;
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function add_code($x)
	{
			$rules['code_type_id'] = 'required|exists:tbl_code_type,code_type_id';
			$rules['membership_id'] = 'required|exists:tbl_membership,membership_id';
			$rules['product_package_id'] = 'required|exists:tbl_product_package,product_package_id';
			$rules['inventory_update_type_id'] = 'required|exists:tbl_inventory_update_type,inventory_update_type_id';
			$rules['account_id'] = 'exists:tbl_account,account_id';
			$rules['code_multiplier'] = 'min:1|integer';
			$n = Tbl_account::where('account_id',Customer::id())->first();
			$d['code_type_id'] = 1;
			$d['membership_id'] = $x['memid'];
			$d['product_package_id'] = $x['package'];
			$d['inventory_update_type_id'] = 1;
			$d['account_id'] = Customer::id();
			$d['code_multiplier'] = 1;

			$check = Tbl_membership::where('membership_id',$x['memid'])->first();
			$rcheck = Tbl_slot::where('slot_id',Session::get('currentslot'))->first();



			$checkifexist = Tbl_product_package::where('membership_id',$x['memid'])->get();
			$datumn = 	    					 DB::table('tbl_membership')->where('archived',0)
												 ->orderBy('membership_price','ASC')
												 ->where('membership_entry',1)
												 ->get();
			$checking = false;
			$checking5 = false;
			foreach($datumn as $s)
			{
				if($s->membership_id == $x['memid'])
				{
					$checking5 = true;
				}
			}
			foreach($checkifexist as $s)
			{
				if($s->product_package_id == $x['package'])
				{
					$checking = true;
				}
			}


			if($checking == true && $checking5 == true)
			{
				if($rcheck && $check)
				{
						$total = $rcheck->slot_wallet - $check->membership_price;
						$validator = Validator::make($d,$rules);
						if($total >= 0)
						{
							if (!$validator->fails())
							{
								for ($i=0; $i < 1; $i++)
								{ 
									$membership_code = new Tbl_membership_code($d);
									$membership_code->code_activation = $this->check_code();
									$membership_code->account_id =  Customer::id() ?: null;
									$membership_code->created_at = Carbon::now();
									$membership_code->save();
									$insert['code_pin'] = $membership_code->code_pin;
									$insert['by_account_id'] = Customer::id();
									$insert['to_account_id'] = Customer::id();
									$insert['updated_at'] = $membership_code->created_at;
									$insert['description'] = "Bought by $n->account_name";
									DB::table("tbl_member_code_history")->insert($insert);
									Tbl_slot::where('slot_id',Session::get('currentslot'))->update(['slot_wallet'=>$total]);
									$message['success'] = "Successfully bought.";
									Log::account(Customer::id(),"You bought a membership code (Pin #$membership_code->code_pin)");
									$c = Tbl_membership_code::where('code_pin',$membership_code->code_pin)->getmembership()->first();
									$or_code = DB::table('tbl_membership_code_sale')->insertGetId(['membershipcode_or_code'=>$c->code_pin,'total_amount'=>($c->membership_price)+($c->membership_price * $c->discount),'created_at'=>Carbon::now(),'sold_to'=>Customer::id()]);
									DB::table('tbl_membership_code_sale_has_code')->insert(['code_pin'=>$c->code_pin,'membershipcode_or_num'=>$or_code]);
									$insert2['code_pin'] = $membership_code->code_pin;
									$insert2['product_package_id'] =  $x['package'];
									Rel_membership_code::insert($insert2);
									Log::slot(Session::get('currentslot'),'Bought a membership code',$total);  
									$this->additional($x['package'],Session::get('currentslot'));
									return $message;
								}
							}
						}
						else
						{
							$message['_error'] = "Not enough balance";
							return $message;
						}				
				}				
			}		
	}

	public function additional($pid,$slotid)
	{
						$total = 0;
						$datapackage = DB::table('tbl_product_package_has')->where('product_package_id',$pid)->get();
						
						foreach($datapackage as $d)
						{	
							$dtotal = DB::table('tbl_product')->where('product_id',$d->product_id)->first();
							$total = $total + ($dtotal->price * $d->quantity);
						}

						$customer = Customer::info();
				        $slot = Tbl_slot::select('tbl_slot.*', 'tbl_membership.discount')->leftJoin('tbl_membership', 'tbl_membership.membership_id','=','tbl_slot.slot_membership')
				                                                                        ->where('slot_id', $slotid)
				                                                                        ->where('slot_owner', $customer->account_id)
				                                                                        ->first();
				       			$data['slot'] = $slot;
				                $insert['slot_id'] = $slotid;
				                $query = Tbl_voucher::where('voucher_code', Globals::code_generator())->first();
				                $insert['voucher_code'] = Globals::check_code($query);
				                $insert['discount'] = $slot->discount;
				                $insert['total_amount'] =$total + (($slot->discount*100)*$total); //
				                $insert['account_id'] = $customer->account_id;
				                $voucher = new Tbl_voucher($insert);
				                $voucher->save();
				                // $log = "Upgrade member include product worth ".Product::return_format_num($insert['total_amount']). " with Voucher Num: ".$voucher->voucher_id." , Voucher Code: ".$voucher->voucher_code.".";
				                // Log::account($customer->account_id, $log);

				                foreach($datapackage as $dt)
								{
									$prod_pts = Tbl_product::find($dt->product_id);
				                    $insert_prod =  array(
				                        'product_id' =>  $dt->product_id,
				                        'voucher_id'=> $voucher->voucher_id,
				                        'price' => $prod_pts->price,
				                        'qty'=> $dt->quantity,
				                        'sub_total' => $prod_pts->price * $dt->quantity,
				                        'binary_pts' => $prod_pts->binary_pts,
				                        'unilevel_pts' => $prod_pts->unilevel_pts
				                    );
				                    $voucher_has_product = new Tbl_voucher_has_product($insert_prod);
				                    $voucher_has_product->save();
				                    $query = Tbl_product_code::where('code_activation', Globals::code_generator())->first();
				                    $insert_prod_code['code_activation'] = Globals::check_code($query);
				                    $insert_prod_code['voucher_item_id'] = $voucher_has_product->voucher_item_id;
				                    $insert_prod_code['used'] = 1;
				                    $product_code = new Tbl_product_code($insert_prod_code);
				                    $product_code->save();
								}           
	}
	
	public function add_form_submit()
	{
		$return["message"] = "";
		$data["message"] = "";
		$check_placement = Tbl_slot::checkposition(Request::input("placement"), strtolower(Request::input("slot_position")))->first();
		$check_id = Tbl_slot::id(Request::input("slot_number"))->first();
		$ifused = Tbl_membership_code::where('code_pin',Request::input("code_number"))->where('used',1)->first();

		if($check_placement)
		{
			$return["message"] = "The position you're trying to use is already occupied";
		}
		elseif($ifused)
		{
			$return["message"] = "This code is already used";
		}
		elseif($data["message"] != "")
		{
			$return["message"] = $data["message"];
		}
		echo json_encode($return);
	}

	public function get()
	{
		$e = Tbl_tree_placement::where('placement_tree_parent_id',Request::input('slot'))->lists('placement_tree_child_id');
		$r = json_encode($e);
		$check = Tbl_slot::where('slot_id',Request::input('slot'))->first();
		if($check == null)
		{
			$r = "x";
		}
		echo json_encode($r);
	}

	public function set_active2()
	{
	  $pin = Request::input('pin');

	  DB::table('tbl_product_code')->where('product_pin',$pin)->update(['lock'=>Request::input('value')]);
	}

	public function unlock2($pin,$pass,$login)
	{
	  $info = null;
	  $checkpass = DB::table('tbl_product_code')   ->where('product_pin',$pin)
	  											   ->first();

	  $login = DB::table('tbl_account')->where('account_id','=',$login)->first();


	  $login = Crypt::decrypt($login->account_password);

 	  if($login == $pass)
 	  {
 	  	DB::table('tbl_product_code')->where('product_pin',$pin)->update(['lock'=>0]);
 	  }
 	  else
 	  {
 	  	$info = "Incorrect Password";
 	  }

	  return $info;
	}

}