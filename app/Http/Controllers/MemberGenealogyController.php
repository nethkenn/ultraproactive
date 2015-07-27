<?php namespace App\Http\Controllers;
use Request;
use App\Tbl_slot;
use App\Classes\Customer;
class MemberGenealogyController extends MemberController
{
	public function index()
	{
        return view('member.genealogy');
	}
	public function tree()
	{
		$data["slot"] = Tbl_slot::rank()->membership()->account()->id(Customer::slot_id())->first();
		return view('member.genealogy_tree', $data);
	}
	public function downline()
	{
		$format = Request::input("mode");
		$slot_id = Request::input("x");

		$return = "<ul>";

		if($format == false)
		{
			$return .= $this->binary_downline($slot_id);
		}
		else
		{
			$return .= $this->binary_downline($slot_id);
		}

		$return .= "</ul>";

		return json_encode($return);
	}
	public function binary_downline($slot_id)
	{
		$left_info = Tbl_slot::where("slot_placement", $slot_id)->where("slot_position", "left")->membership()->account()->first();
		$right_info = Tbl_slot::where("slot_placement", $slot_id)->where("slot_position", "right")->membership()->account()->first(); 

		$tree_string = "";
		$tree_string .= $this->downline_format($left_info);
		$tree_string .= $this->downline_format($right_info);

		return $tree_string;


	}
	public function downline_format($slot_info)
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
		else
		{
			return 	'	<li class="width-reference">
							<span class="parent parent-reference VC">
								<div class="id">+</div>
							</span>
						</li>';
		}
	}
}