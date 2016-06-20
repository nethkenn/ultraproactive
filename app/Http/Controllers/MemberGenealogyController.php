<?php namespace App\Http\Controllers;
use Request;
use App\Tbl_slot;
use App\Classes\Customer;
use DB;
use App\Tbl_tree_placement;
use App\Classes\Compute;
use App\Tbl_membership_code;
use App\Tbl_tree_sponsor;	
use App\Tbl_lead;
use App\Rel_membership_code;
use App\Rel_membership_product;
use Carbon\Carbon;
use App\Tbl_membership_code_sale_has_code;
use App\Tbl_membership_code_sale;
use App\Tbl_voucher;
use App\Classes\Log;
use App\Tbl_account;
use App\Tbl_membership;
use Session;
class MemberGenealogyController extends MemberController
{
	public function index()
	{
		$data['code'] = DB::table('tbl_membership_code')  ->where('tbl_membership_code.archived',0)
														  ->where('tbl_membership_code.blocked',0)
														  ->where('tbl_membership_code.used',0)
														  ->join('tbl_account','tbl_account.account_id','=','tbl_membership_code.account_id')
														  ->join('tbl_code_type','tbl_code_type.code_type_id','=','tbl_membership_code.code_type_id')
														  ->join('tbl_membership','tbl_membership.membership_id','=','tbl_membership_code.membership_id')
														  ->leftjoin('tbl_product_package','tbl_product_package.product_package_id','=','tbl_membership_code.product_package_id')
														  ->where('tbl_membership_code.account_id','=',Customer::id())
														  ->orderBy('tbl_membership_code.code_pin','ASC')
														  ->get();
	    $data['id'] = Customer::id();
		$data['getlead'] = Tbl_lead::where('lead_account_id',Customer::id())->getaccount()->get();												  

        return view('member.genealogy',$data);
	}

	public function tree()
	{
		$data["slot_tree"] = Tbl_slot::rank()->membership()->account()->id(Customer::slot_id())->first();
		$data['l'] = Tbl_tree_placement::where('placement_tree_parent_id',Customer::slot_id())->where('placement_tree_position','left')->count();
		$data['r'] = Tbl_tree_placement::where('placement_tree_parent_id',Customer::slot_id())->where('placement_tree_position','right')->count();

		if($data["slot_tree"])
		{
			if(Request::input("view_id"))
			{
				$check_the_tree = Tbl_tree_placement::where("placement_tree_parent_id",CUstomer::slot_id())->where("placement_tree_child_id",Request::input("view_id"))->first();
				if($check_the_tree)
				{
					$data["downline"] = $this->downline(Request::input("view_id"));
					$data["slot_tree"] = Tbl_slot::rank()->membership()->account()->id(Request::input("view_id"))->first();
				}
				else
				{
					$data["downline"] = $this->downline(Customer::slot_id());		
				}
			}
			else
			{
				$data["downline"] 	  = $this->downline(Customer::slot_id());			
			}
		}

		$data['code'] = DB::table('tbl_membership_code')  ->where('tbl_membership_code.archived',0)
														  ->where('tbl_membership_code.blocked',0)
														  ->where('tbl_membership_code.used',0)
														  ->join('tbl_account','tbl_account.account_id','=','tbl_membership_code.account_id')
														  ->join('tbl_code_type','tbl_code_type.code_type_id','=','tbl_membership_code.code_type_id')
														  ->join('tbl_membership','tbl_membership.membership_id','=','tbl_membership_code.membership_id')
														  ->leftjoin('tbl_product_package','tbl_product_package.product_package_id','=','tbl_membership_code.product_package_id')
														  ->where('tbl_membership_code.account_id','=',Customer::id())
														  ->orderBy('tbl_membership_code.code_pin','ASC')
														  ->get();
	    $data['id'] = Customer::id();
		$data['getlead'] = Tbl_lead::where('lead_account_id',Customer::id())->getaccount()->get();	

		$customer_info = Customer::info();
		$data['slot_limit'] = DB::table('tbl_settings')->where('key','slot_limit')->first();
		$current_wallet = null;
		$data2 = null;
		$earnings = null;
		$current_gc = null;

        $disable_member_area = DB::table('tbl_settings')->where('key','disable_member_area')->first();
        if(!$disable_member_area)
        {
            DB::table('tbl_settings')->insert(['key'=>'disable_member_area','value'=>'0']);
            $disable_member_area = DB::table('tbl_settings')->where('key','disable_member_area')->first();
        }	
        if($customer_info)
        {
            if($disable_member_area->value == 1)
	        {
	        	if(Tbl_admin::where('account_id',Customer::info()->account_id)->join('tbl_admin_position','tbl_admin_position.admin_position_id','=','tbl_admin.admin_position_id')->where('admin_position_rank',0)->first())
	        	{
	        		
	        	}
	        	else
	        	{
	 	        	die("We're currently doing maintenance. We'll be back shortly.");   		
	        	}
	        }      	
        }


		if(!$data['slot_limit'])
		{
			DB::table('tbl_settings')->insert(['key'=>'slot_limit','value'=>1]);
		}
        if($customer_info)
        {
            $id = Customer::id();
            $data4 = Tbl_account::where('account_id','!=',$id)->get();
    		$membership = Tbl_membership::where('archived',0)->orderBy('membership_price','ASC')->get();
			if(Session::get("currentslot"))
			{
				$data2 = $this->getotherslot($id);
  	    		$data3 = $this->getcurrentslot($id);
  	    		$earnings = $data3['earnings'];
			    $current_wallet = $data3['current_wallet'];
			    $current_gc = $data3['current_gc'];
			    $data3 = $data3['data3'];
				if($data3)
				{
	    			/* Check Date if need to reset daily pair */
				    /* Check Date if need to reset daily income*/
					$this->check_daily($data3);				
				}
				else
				{
					Session::forget("currentslot");	
					return Redirect::to(Request::input('url'))->send();	
				}
			}	
			else
			{
	    		$data3 = $this->getcurrentslot($id);
	    		$data3 = $data3['data3'];
			    if($data3)
			    {
					Session::put("currentslot", $data3->slot_id);
					if(Session::get("currentslot"))
					{
						/* Get Wallet Data*/
						$data2 = $this->getotherslot($id);
		  	    		$data3 = $this->getcurrentslot($id);
		  	    		$earnings = $data3['earnings'];
					    $current_wallet = $data3['current_wallet'];
					    $current_gc = $data3['current_gc'];
					    $data3 = $data3['data3'];
		    			/* Check Date if need to reset daily pair */
					    /* Check Date if need to reset daily income*/
						$this->check_daily($data3);
					}	
			    }	 					  
			}	
            $data["member"]  		= $customer_info;
            $data["slot"] 	  		= $data2;
            $data["slotnow"] 		= $data3;
            $data["earnings"]		= $earnings;
            $data["current_wallet"] = $current_wallet;
            $data["current_gc"] 	= $current_gc;
            $data["membership"] 	= $membership;
            $data["accountlist"] 	= $data4;
		}

		return view('member.genealogy_tree', $data);
	}

	public function downline($x = 0)
	{
		$format = Request::input("mode");

		if($x == 0)
		{
			$slot_id = Request::input("x");
		}
		else
		{
			$slot_id = $x;
		}

		$return = "<ul>";

		if($format == "binary")
		{
			$return .= $this->binary_downline($slot_id);
		}
		else
		{
			$return .= $this->unilevel_downline($slot_id);
		}

		$return .= "</ul>";

		if($x == 0)
		{
			return json_encode($return);
		}
		else
		{
			return $return;
		}
		
	}
	public function binary_downline($slot_id)
	{
		$left_info = Tbl_slot::where("slot_placement", $slot_id)->where("slot_position", "left")->membership()->account()->first();
		$right_info = Tbl_slot::where("slot_placement", $slot_id)->where("slot_position", "right")->membership()->account()->first(); 

		$tree_string = "";
		$tree_string .= $this->downline_format($left_info,'Left',$slot_id);
		$tree_string .= $this->downline_format($right_info,'Right',$slot_id);

		return $tree_string;


	}
	public function unilevel_downline($slot_id)
	{
		$_info = Tbl_slot::where("slot_sponsor", $slot_id)->membership()->account()->get();
		$count = Tbl_slot::where("slot_sponsor", $slot_id)->membership()->account()->count();

		$tree_string = "";

		if($count != 0)
		{
			foreach($_info as $info)
			{
				$tree_string .= $this->downline_format($info);	
			}
		}
		else
		{
			$tree_string .= '<li class="width-reference">
								<span class="parent parent-reference VC">
									<div class="id">+</div>
								</span>
							</li>';
		}

		
		return $tree_string;


	}
	public function downline_format($slot_info,$position = null,$placement = null)
	{

		if($slot_info)
		{
			$l = Tbl_tree_placement::where('placement_tree_parent_id',$slot_info->slot_id)->where('placement_tree_position','left')->count();
			$r = Tbl_tree_placement::where('placement_tree_parent_id',$slot_info->slot_id)->where('placement_tree_position','right')->count();
			if($slot_info->image == "")
			{
				return 	'	<li class="width-reference">
								<span class="downline parent parent-reference PS SILVER" x="' . $slot_info->slot_id . '">
									<div id="info">
										<div id="photo">
		                                    <img src="/resources/assets/img/default-image.jpg" alt="" />
		                                </div>
										<div id="cont">
											<div style="font-weight: 700;">' . strtoupper($slot_info->account_username) . ' </div>
											<div>' . strtoupper($slot_info->account_name) . ' </div>
											<b>' . $slot_info->membership_name . ' </b>
										</div>
										<div>' . $slot_info->slot_type . '</div>
										<div>' . "L:".$l." / R:".$r.'</div>
										<div>' . "Left Points:".$slot_info->slot_binary_left." / Right Ponts:".$slot_info->slot_binary_right.'</div>
										<div>
										</div>
									</div>
									<div class="id">' . $slot_info->slot_id . '</div>
								</span>
								<i class="downline-container"></i>
							</li>';
			}
			else
			{
				return 	'	<li class="width-reference">
								<span class="downline parent parent-reference PS SILVER" x="' . $slot_info->slot_id . '">
									<div id="info">
										<div id="photo">
		                                    <img src="'.$slot_info->image.'">
		                                </div>
										<div id="cont">
											<div style="font-weight: 700;">' . strtoupper($slot_info->account_username) . ' </div>
											<div>' . strtoupper($slot_info->account_name) . ' </div>
											<b>' . $slot_info->membership_name . ' </b>
										</div>
										<div>' . $slot_info->slot_type . '</div>
										<div>' . "L:".$l."</br>R:".$r.'</div>
										<div>
										</div>
									</div>
									<div class="id">' . $slot_info->slot_id . '</div>
								</span>
								<i class="downline-container"></i>
							</li>';				
			}

		}
		else if($position) 
		{
			$slot_info = Tbl_slot::where('slot_id',$placement)->account()->first();

			return 	'	<li class="width-reference">
							<span class="positioning parent parent-reference VC" position="'.$position.'" placement="'.$placement.'" y="'.$slot_info->account_name.'">
								<div class="id">+</div>
							</span>
						</li>';
		}
		else
		{
			return 	'	<li class="width-reference">
							<span class="parent parent-reference VC">
								<div class="id">+</div>
							</span>
						</li>';
		}
	}

	public function add_form()
	{
		ignore_user_abort(true);
		set_time_limit(0);
		
		header("Connection: close", true);
		header("Content-Encoding: none\r\n");
		header("Content-Length: 0", true);

		flush();
		ob_flush();

		session_write_close();
				$return["message"] = "";
				$data["message"] = "";
				$code = DB::table('tbl_membership_code')  ->where('tbl_membership_code.archived',0)
																  ->where('tbl_membership_code.blocked',0)
																  ->where('tbl_membership_code.used',0)
																  ->join('tbl_account','tbl_account.account_id','=','tbl_membership_code.account_id')
																  ->join('tbl_code_type','tbl_code_type.code_type_id','=','tbl_membership_code.code_type_id')
																  ->join('tbl_membership','tbl_membership.membership_id','=','tbl_membership_code.membership_id')
																  ->leftjoin('tbl_product_package','tbl_product_package.product_package_id','=','tbl_membership_code.product_package_id')
																  ->where('tbl_membership_code.account_id','=',Customer::id())
																  ->where('tbl_membership_code.code_pin',Request::input('code'))
																  ->first();
				$codex = DB::table('tbl_membership_code')  ->where('tbl_membership_code.archived',0)
														  ->where('tbl_membership_code.blocked',0)
														  ->where('tbl_membership_code.used',0)
														  ->where('tbl_membership_code.account_id','=',Customer::id())
														  ->where('tbl_membership_code.code_pin',Request::input('code'))
														  ->first();	
											  
				$sponsor = null;





				$checklead = Tbl_lead::where('lead_account_id',Customer::id())->where('tbl_lead.account_id',Request::input('acc'))->getaccount()->first();		

				if($checklead)
				{
					$owner = Request::input('acc');
				}
				elseif(Customer::id() == Request::input('acc'))
				{
					$owner =  Request::input('acc');
				}
				else
				{
					$data["message"] = 'Some error occurred please try to refresh.';
				}



			 	$limit = DB::table('tbl_settings')->where('key','slot_limit')->first();
				$count = Tbl_slot::where('slot_owner',$owner)->count();
				if($limit->value <=  $count)
				{
					$data["message"] = "This account is already reach the max slot per account. Max slot per account is ".$limit->value.".";
				}


				if($code)
				{
					if($code->code_type_name == "Free Slot")
					{
						$c = "FS";
					}			
					else if($code->code_type_name == "Comission Deductable")
					{
						$c = "CD";	
					}
					else
					{
						$c = "PS";
					}			
				}
				else
				{
					$data["message"] = 'Some error occurred please try to refresh.';
				}


				if(Request::input('sponsor'))
				{
					$sponsor = Tbl_slot::id(Request::input('sponsor'))->first();
					if($sponsor)
					{
						$sponsor = $sponsor->slot_id;
					}
					else
					{
						$data["message"] = 'Please put a valid sponsor';
					}
				}
				else
				{
					$data["message"] = "Please put a sponsor's slot #";
				}

				if(strtolower(Request::input("position")) == 'left' || strtolower(Request::input("position")) == 'right')
				{

				}
				else
				{
					$data["message"] = 'Some error occurred please try to refresh.';
				}

				$check_placement = Tbl_slot::checkposition(Request::input("placement"), strtolower(Request::input("position")))->first();
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
					$ifused = Tbl_membership_code::where('code_pin',$code->code_pin)->where('used',1)->first();
					if($ifused)
					{
						$data["message"] = 'Some error occurred please try to refresh.';
					}
					else
					{
							Tbl_membership_code::where('code_pin',$code->code_pin)->update(['used'=>1]);
							$amount = 0;

							if($c == "CD")
							{
								$amount = 0 - $code->membership_price;
								// $insert["slot_wallet"] = 0 - $code->membership_price;
								// $insert["cd_done"] = 1;
								$insert["slot_total_earning"] =  0 - $code->membership_price;
							}
							$insert["slot_membership"] =  $codex->membership_id;
							$insert["slot_type"] = $c;
							$insert["slot_rank"] =  1;
							$insert["slot_sponsor"] =  $sponsor;
							$insert["slot_placement"] =  Request::input("placement");
							$insert["slot_position"] =  strtolower(Request::input("position"));
							$insert["slot_owner"] = $owner;
							$insert["distributed"] = 0;
							$insert["created_at"] = Carbon::now();
							$insert["membership_entry_id"] = $codex->membership_id;
							$slot_id = Tbl_slot::insertGetId($insert);


							$logs = "Successfully create slot #".$slot_id." using membership code #".$code->code_pin.".";
							
							Log::slot($slot_id, $logs, $amount, "New slot",$slot_id);

							Compute::tree($slot_id);
							Compute::entry($slot_id);

							if($c == "CD")
							{
								$code = Tbl_membership_code_sale_has_code::where('code_pin',$code->code_pin)->first();
								if($code)
								{
									$code_sale = Tbl_membership_code_sale::where('membershipcode_or_num',$code->membershipcode_or_num)->first();
									if($code_sale)
									{
										Tbl_voucher::where('voucher_id',$code_sale->voucher_id)->update(["slot_id"=>$slot_id]);
									}								
								}
							}
							
							$get = Rel_membership_code::where('code_pin',$code->code_pin)->first();
							if(isset($get->product_package_id))
							{
								$insert2['slot_id'] = $slot_id;
								$insert2['product_package_id'] = $get->product_package_id;
								Rel_membership_product::insert($insert2);				
							}

							Tbl_slot::where('slot_id',$slot_id)->update(['distributed'=>1]);
							$return["placement"] = Request::input("placement");
					}
				}
		sleep(1);
		exit;
		echo json_encode($return);
	}
	public function add_form_message()
	{

				$return["message"] = "";
				$data["message"] = "";
				$code = DB::table('tbl_membership_code')  ->where('tbl_membership_code.archived',0)
																  ->where('tbl_membership_code.blocked',0)
																  ->where('tbl_membership_code.used',0)
																  ->join('tbl_account','tbl_account.account_id','=','tbl_membership_code.account_id')
																  ->join('tbl_code_type','tbl_code_type.code_type_id','=','tbl_membership_code.code_type_id')
																  ->join('tbl_membership','tbl_membership.membership_id','=','tbl_membership_code.membership_id')
																  ->leftjoin('tbl_product_package','tbl_product_package.product_package_id','=','tbl_membership_code.product_package_id')
																  ->where('tbl_membership_code.account_id','=',Customer::id())
																  ->where('tbl_membership_code.code_pin',Request::input('code'))
																  ->first();
				$codex = DB::table('tbl_membership_code')  ->where('tbl_membership_code.archived',0)
														  ->where('tbl_membership_code.blocked',0)
														  ->where('tbl_membership_code.used',0)
														  ->where('tbl_membership_code.account_id','=',Customer::id())
														  ->where('tbl_membership_code.code_pin',Request::input('code'))
														  ->first();	
											  
				$sponsor = null;




				$checklead = Tbl_lead::where('lead_account_id',Customer::id())->where('tbl_lead.account_id',Request::input('acc'))->getaccount()->first();		

				if($checklead)
				{
					$owner = Request::input('acc');
				}
				elseif(Customer::id() == Request::input('acc'))
				{
					$owner =  Request::input('acc');
				}
				else
				{
					$data["message"] = 'Some error occurred please try to refresh.';
				}



			 	$limit = DB::table('tbl_settings')->where('key','slot_limit')->first();
				$count = Tbl_slot::where('slot_owner',$owner)->count();
				if($limit->value <=  $count)
				{
					$data["message"] = "This account is already reach the max slot per account. Max slot per account is ".$limit->value.".";
				}


				if($code)
				{
					if($code->code_type_name == "Free Slot")
					{
						$c = "FS";
					}			
					else if($code->code_type_name == "Comission Deductable")
					{
						$c = "CD";	
					}
					else
					{
						$c = "PS";
					}			
				}
				else
				{
					$data["message"] = 'Some error occurred please try to refresh.';
				}


				if(Request::input('sponsor'))
				{
					$sponsor = Tbl_slot::id(Request::input('sponsor'))->first();
					if($sponsor)
					{
						$sponsor = $sponsor->slot_id;
					}
					else
					{
						$data["message"] = 'Please put a valid sponsor';
					}
				}
				else
				{
					$data["message"] = "Please put a sponsor's slot #";
				}

				if(strtolower(Request::input("position")) == 'left' || strtolower(Request::input("position")) == 'right')
				{

				}
				else
				{
					$data["message"] = 'Some error occurred please try to refresh.';
				}

				$check_placement = Tbl_slot::checkposition(Request::input("placement"), strtolower(Request::input("position")))->first();
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
					$return["placement"] = Request::input("placement");
				}

		echo json_encode($return);
	}

	public function get()
	{
		$e = DB::table('tbl_membership_code') 	       	  ->where('tbl_membership_code.archived',0)
														  ->where('tbl_membership_code.blocked',0)
														  ->where('tbl_membership_code.used',0)
														  ->join('tbl_account','tbl_account.account_id','=','tbl_membership_code.account_id')
														  ->join('tbl_code_type','tbl_code_type.code_type_id','=','tbl_membership_code.code_type_id')
														  ->join('tbl_membership','tbl_membership.membership_id','=','tbl_membership_code.membership_id')
														  ->leftjoin('tbl_product_package','tbl_product_package.product_package_id','=','tbl_membership_code.product_package_id')
														  ->where('tbl_membership_code.account_id','=',Customer::id())
														  ->orderBy('tbl_membership_code.code_pin','ASC')
														  ->where('tbl_membership_code.code_pin',Request::input('code'))
														  ->select('membership_name','code_type_name')
														  ->first();
		if($e == null)
		{
			$r['code'] = "x";
			$r['latest'] = "x";
		}
		else
		{
			$r['code'] = json_encode($e);
			$r['latest'] = Tbl_slot::orderBy('slot_id','DESC')->first();
			$r['latest'] = $r['latest']->slot_id + 1;
		}
		echo json_encode($r);
	}

	// public function getsponsor()
	// {
	// 	$sponsor = Tbl_tree_sponsor::child(Request::input('slot'))->get();
	// 	$r['sponsor'] = json_encode($sponsor);
	// 	dd($sponsor);
	// 	echo json_encode($r);	
	// }

}