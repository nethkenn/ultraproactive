<?php namespace App\Http\Controllers;
use Request;
use App\Tbl_slot;
use App\Classes\Customer;
use DB;
use App\Tbl_tree_placement;
use App\Classes\Compute;
use App\Tbl_membership_code;
use App\Tbl_tree_sponsor;	
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
        return view('member.genealogy',$data);
	}

	public function tree()
	{
		$data["slot"] = Tbl_slot::rank()->membership()->account()->id(Customer::slot_id())->first();
		$data["downline"] = $this->downline(Customer::slot_id());
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
			return 	'	<li class="width-reference">
							<span class="downline parent parent-reference PS SILVER" x="' . $slot_info->slot_id . '">
								<div id="info">
									<div id="photo">
	                                    <img src="/resources/assets/img/default-image.JPG" alt="" />
	                                </div>
									<div id="cont">
										<div>' . strtoupper($slot_info->account_name) . ' </div>
										<b>' . $slot_info->membership_name . ' </b>
									</div>
									<div>' . $slot_info->slot_type . '</div>
									<div>
									</div>
								</div>
								<div class="id">' . $slot_info->slot_id . '</div>
							</span>
							<i class="downline-container"></i>
						</li>';
		}
		else if($position) 
		{
			return 	'	<li class="width-reference">
							<span class="positioning parent parent-reference VC" position="'.$position.'" placement="'.$placement.'">
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

			$insert["slot_membership"] =  $codex->membership_id;
			$insert["slot_type"] = $c;
			$insert["slot_rank"] =  1;
			$insert["slot_sponsor"] =  $sponsor;
			$insert["slot_placement"] =  Request::input("placement");
			$insert["slot_position"] =  strtolower(Request::input("position"));
			$insert["slot_owner"] = Customer::id();
			$slot_id = Tbl_slot::insertGetId($insert);
			Tbl_membership_code::where('code_pin',$code->code_pin)->update(['used'=>1]);
			Compute::tree($slot_id);
			Compute::entry($slot_id);

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