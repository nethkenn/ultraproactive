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
class MemberCodeController extends MemberController
{
	public function index()
	{
		$id = Customer::id();
		$data = $this->getslotbyid($id);
		$data['error'] = Session::get('message');
		$s = Tbl_account::where('tbl_account.account_id',$id)->belongstothis()->get();
		// $n = array();
		// $slot  = DB::table('tbl_slot')->where('slot_placement',Session::get('currentslot'))->get();
		// $stop  = false;
		// $stop2 = false;
		// $ctr = 1;



		// while($stop==false && $stop2==false)
		// {
		// 	if(!isset($k))
		// 	{
		// 			foreach($slot as $key => $s2)
		// 			{
		// 				$k[$key] = DB::table('tbl_slot')->where('slot_placement',$s2->slot_id)->get();
		// 			}
		// 	}
		// 	else
		// 	{
		// 			foreach($slot as $key => $s2)
		// 			{
		// 				$k[$key] = DB::table('tbl_slot')->where('slot_placement',$s2->slot_id)->get();
		// 			}
		// 	}
		// 	dd("Counting downline is under construction...");
		// }


		// dd($n);

		// dd($slotted);
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
		if(isset($_POST['codesbmt']))
		{
			$data['error'] = $this->transfer(Request::input('code'),Request::input('account'),Request::input('pass'),$id,$s);
			return Redirect::to('member/code_vault')->with('message',$data['error']);
		}
		// if(isset($_POST['c_slot']))
		// {
		// 	$s = $this->create_slot(Request::input());
		// 	dd($s);
		// }

        return view('member.code_vault',$data);
	}

	// public function create_slot($data)
	// {
	// 	$check_position = Tbl_slot::checkposition(Request::input("placement"), strtolower(Request::input("position")))->first();
	// 	if($check_position)
	// 	{

	// 	}
	// 	else
	// 	{

	// 	}
	// }

	public function getslotbyid($id)
	{
		$data['code'] = DB::table('tbl_membership_code')  ->where('tbl_membership_code.archived',0)
														  ->join('tbl_account','tbl_account.account_id','=','tbl_membership_code.account_id')
														  ->join('tbl_code_type','tbl_code_type.code_type_id','=','tbl_membership_code.code_type_id')
														  ->join('tbl_membership','tbl_membership.membership_id','=','tbl_membership_code.membership_id')
														  ->join('tbl_product_package','tbl_product_package.product_package_id','=','tbl_membership_code.product_package_id')
														  ->where('tbl_membership_code.account_id','=',$id)
														  ->orderBy('tbl_membership_code.account_id','ASC')
														  ->get();
        foreach($data['code'] as $key => $d)
        {
        	$get =	 DB::table('tbl_member_code_history')->where('code_pin',$d->code_pin)
        												 ->join('tbl_account','tbl_account.account_id','=','tbl_member_code_history.by_account_id')
        											     ->orderBy('updated_at','DESC')
        											     ->first();
        	$data['code'][$key]->transferer = $get->account_name;	
        	$data['code'][$key]->encrypt    = Crypt::encrypt($d->code_pin);									     
        }
		$data['count']= DB::table('tbl_membership_code')->where('archived',0)->where('account_id','=',$id)->count();
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
				DB::table("tbl_member_code_history")->insert($insert);

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
		$checking = false;
		$rpass = Tbl_account::where('account_id',$id)->first();
		$rpass = Crypt::decrypt($rpass->account_password);
		$info = null;
		foreach($s as $key => $data)
		{
			if($data->code_pin == $code)
			{
				$checking = true;
			}
		}
		if($checking == true)
		{
				if($rpass == $pass)
				{
					Tbl_membership_code::where('code_pin',$code)->update(['account_id'=>$account]);
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
	  $pin = Crypt::decrypt($pin);
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
	
}