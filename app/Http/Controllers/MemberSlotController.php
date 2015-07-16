<?php namespace App\Http\Controllers;
use App\Classes\Customer;
use DB;
use Request;
use Crypt;
use Redirect;
use Session;

class MemberSlotController extends MemberController
{
	public function index()
	{
		$id = Customer::id();
		$data = $this->getslotbyid($id);
		$data['currentslot'] = Session::get('currentslot');


		if(Request::input('subup'))
		{
			$pass = DB::table('tbl_account')->where("account_id",$id)->first();
			$pass =	Crypt::decrypt($pass->account_password);

			if($pass == Request::input('pass'))
			{
				$data = $this->getcompute(Request::input('tols'),Request::input('membership'));
				return Redirect::to('/member/slot');
			}
			else
			{
				return Redirect::to('/member/slot');
			}
		}

		if(Request::input('changeslot'))
		{
			Session::put('currentslot',Request::input('changeslot'));
			return redirect()->back();
		}



        return view('member.slot',$data);
	}
	public function getslotbyid($id)
	{
		$data['slot2'] = DB::table('tbl_slot')->where('slot_owner','=',$id)
											  ->orderBy('slot_id','ASC')
											  ->join('tbl_rank','rank_id','=','slot_rank')
											  ->join('tbl_membership','tbl_membership.membership_id','=','tbl_slot.slot_membership')
											  ->get();


		$data['count']= DB::table('tbl_slot')->where('slot_owner','=',$id)->count();
		return $data;
	}
	public function getcompute($id,$memid)
	{
		$slot = DB::table('tbl_slot')->where('slot_id',$id)->first();
		$membership = DB::table('tbl_membership')->where('membership_id',$memid)->first();

		$remaining = $slot->slot_wallet - $membership->membership_price;

		if($remaining >= 0)
		{
			DB::table('tbl_slot')->where('slot_id','=',$id)->update(['slot_wallet'=>$remaining,'slot_membership'=>$membership->membership_id]);
			$data = "Success";
		}
		else
		{
			$data = "You don't have enough balance in your wallet for upgrade";
		}

		return $data;
	}
	// public function getcurrentslot()
	// {

	// }
}