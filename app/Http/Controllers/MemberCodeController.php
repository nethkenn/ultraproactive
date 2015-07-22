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



class MemberCodeController extends MemberController
{
	public function index()
	{
		$id = Customer::id();
		$data = $this->getslotbyid($id);
		$data['_error'] = Session::get('message');
		if(isset($data['error']))
		{
			dd($data['error']);
		}
		$data['success']  = Session::get('success');
		$data['availprod'] = Tbl_product_package::where('archived',0)->get();

		if($data['availprod'])
		{
			foreach($data['availprod'] as $key => $d)
			{
				$s = Tbl_product_package_has::where('product_package_id',$d->product_package_id)->product()->get();
				$data['availprod'][$key]->productlist  = json_encode($s);
			}	
		}


		$s = Tbl_account::where('tbl_account.account_id',$id)->belongstothis()->get();

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
								return $message;
							}
						}
						else
						{
							$error =  $validator->errors();
							$data['_error']['code_type_id'] = $error->get('code_type_id');
							$data['_error']['membership_id'] = $error->get('membership_id');
							$data['_error']['product_package_id'] = $error->get('product_package_id');
							$data['_error']['inventory_update_type_id'] = $error->get('inventory_update_type_id');
							$data['_error']['account_id'] = $error->get('account_id');
							$data['_error']['code_multiplier'] = $error->get('code_multiplier');
			     		    return $data;
						}				
					}
					else
					{
						$data['_error']['not'] = "Not enough balance.";
						return $data;
					}				
			}


			



			
		
	}
	
}