<?php namespace App\Http\Controllers;
use App\Classes\Customer;
use DB;
use Request;
use Crypt;
use Redirect;
use Session;
use App\Tbl_slot;
use App\Tbl_lead;
use App\Tbl_account;
class MemberSlotController extends MemberController
{
	public function index()
	{
		$id = Customer::id();
		$data = $this->getslotbyid($id);
		$data['error'] = Session::get('message');
		$data['success']  = Session::get('success');
		$data['currentslot'] = Session::get('currentslot');
		$data['getlead'] = Tbl_lead::where('lead_account_id',Customer::id())->getaccount()->get();

		
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
		if(isset($_POST['initsbmt']))
		{
			$info = $this->transfer_slot(Request::input());
			if(isset($info['success']))
			{
			   $message = $info['success'];
			   return Redirect::to('/member/slot')->with('success',$message);
			}
			else
			{
			   $message = $info['error'];
			   return Redirect::to('/member/slot')->with('message',$message);
			}
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
	public function transfer_slot($data)
	{
		$checking = false;
		$rpass = Tbl_account::where('account_id',Customer::id())->first();
		$rpass = Crypt::decrypt($rpass->account_password);
		$info = null;
		$slot = Tbl_slot::where('slot_owner',Customer::id())->get();


		foreach($slot as $s)
		{
			if($s->slot_id == $data['slot'])
			{
				$checking = true;
			}
		}

		if($checking == true && isset($data['acct']))
		{
				if($rpass == $data['pass'])
				{	
					Tbl_slot::where('slot_id',$data['slot'])->update(['slot_owner'=>$data['acct']]);
					Session::forget('currentslot');
					$info['success'] = "Success";
				}
				else
				{
					$info['error'] = "Wrong Password";	
				}
		}
		else
		{
			$info['error'] = "Transfer failed";
		}

		return $info;
	}
}