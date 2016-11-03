<?php namespace App\Http\Controllers;
use DB;
use Request;
use Session;
use App\Classes\Customer;
use Crypt;
use App\Tbl_country;
use App\Tbl_slot;
use App\Tbl_account_encashment_history;
use Carbon\Carbon;
use Redirect;
use App\Classes\Log;
use App\Tbl_wallet_logs;
class MemberEncashmentController extends MemberController
{
	public function index()
	{	
		$id = Session::get('account_id');
		$id = Crypt::decrypt($id);
		$data['history'] = DB::table('tbl_account_encashment_history')->orderBy('encashment_date','ASC')->where('account_id',$id)->get();
		$data['counth'] = DB::table('tbl_account_encashment_history')->orderBy('encashment_date','ASC')->where('account_id',$id)->count();
		$acc = DB::table('tbl_account')->where('account_id',$id)->first();
		$data['deduction']['forjson'] = Tbl_country::where('tbl_country.country_id',$acc->account_country_id)->deduct2()->deductioncountry2()->get();
		$data['json'] = json_encode($data['deduction']);

		if(isset($_POST['confirmencash']))
		{	
			$data['error'] = $this->encash(Request::input('amount'),Request::input('typeofencashment'),$data['deduction']['forjson'],$id);		
			return Redirect::to('member/encashment');
		}

        return view('member.encashment',$data);
	}

	public function encash($amt,$type,$deduction,$id)
	{
		$total = 0;
		$slot_id = Session::get('currentslot');
		$slot = Tbl_slot::where('slot_id',$slot_id)->first();
		$wallet = Tbl_wallet_logs::where("slot_id", $slot_id)->wallet()->sum('wallet_amount');
		if($wallet >= $amt)
		{
			$total = $wallet - $amt;
			$withdrawal = $amt + $slot->slot_total_withrawal;
			$insert['slot_id'] = $slot_id;
			$insert['account_id'] = $id;
			$insert['amount'] = $amt;
			$insert['encashment_date'] = Carbon::now();
			$insert['type'] = $type;
			$insert['status'] = "Pending";
			$t = 0;
			foreach($deduction as $key => $d)
			{
				if($d->percent == 1)
				{
					$t = $t + ($amt*($d->deduction_amount/100));
				}
				else
				{
					$t = $t + $d->deduction_amount;
				}
			}
			$x = $amt - $t;

			if($x >= 0)
			{
				// Tbl_slot::where('slot_id',$slot_id)->update(['slot_wallet'=>$total,'slot_total_withrawal'=>$withdrawal]);
				$insert['deduction'] = $t;
				Tbl_account_encashment_history::insert($insert);
				$negative_total = ($amt)*(-1);
				Log::account(Customer::id(),'Encashed a wallet total of '.$amt); 
				Log::slot(Session::get('currentslot'),'Encashed a wallet total of '.$amt,$negative_total,"Encashment",Session::get('currentslot')); 				
			}

		}
		else
		{
			$total = 0;
		}

		return $total;
	}
	
	public function redeem()
	{	
		$id = Session::get('currentslot');
		$data["reedemed_upcoins"]			= DB::table("tbl_pv_logs")->where("owner_slot_id",$id)->where("used_for_redeem",1)->sum("amount");
		$data["total_personal_upcoins"]		= DB::table("tbl_pv_logs")->where("owner_slot_id",$id)->where("used_for_redeem",0)->sum("amount");
		$data["request"]                    = DB::table("tbl_redeem_request")->where("slot_id",$id)->get();

		if(isset($_POST['requested_amount']))
		{	
			$amount 	  = $_POST['requested_amount'];
			$total_up	  = $data["total_personal_upcoins"];
			$total_redeem = -1 * $data["reedemed_upcoins"];
			$remaining    = $total_up - $total_redeem;
			if($amount == 250 || $amount == 500 || $amount == 1000  || $amount == 10000 || $amount == 20000 || $amount == 30000 )
			{
				if($remaining >= $amount)
				{
					$condition              = false;
					while($condition == false)
					{
						$random_code            = $this->code_generator();
						$check				    = DB::table("tbl_redeem_request")->where("request_code",$random_code)->first();
						if(!$check)
						{
							$condition          = true;
						}
					}
					
					
	                $log = "Your slot #" . $id. " redeemed <b> " . number_format($amount, 2) . " Personal UPcoins</b> ";
	                Log::slot($id, $log, 0,"Redeem Personal UPcoins",$id);
	                
	                $insert_pv["owner_slot_id"]   = $id;
	                $insert_pv["amount"]          = -1 * $amount;
	                $insert_pv["detail"]          = $log;
	                $insert_pv["date_created"]    = Carbon::now();
	                $insert_pv["type"]            = "PPV";
	                $insert_pv["used_for_redeem"] = 1;
	                DB::table("tbl_pv_logs")->insert($insert_pv);
	                
	                
	                
					$insert["request_code"] = $random_code;
					$insert["amount"]		= $amount;
					$insert["status"]		= "Unclaimed";
					$insert["archived"]		= 0;
					$insert["slot_id"]		= $id;
					$insert["request_date"]	= Carbon::now();
					DB::table("tbl_redeem_request")->insert($insert);
					
					
					$data["reedemed_upcoins"]			= DB::table("tbl_pv_logs")->where("owner_slot_id",$id)->where("used_for_redeem",1)->where("type","PPV")->sum("amount");
					$data["total_personal_upcoins"]		= DB::table("tbl_pv_logs")->where("owner_slot_id",$id)->where("used_for_redeem",0)->where("type","PPV")->sum("amount");
					$data["request"]                    = DB::table("tbl_redeem_request")->where("slot_id",$id)->get();
					$data["sucess"] 					= "Successfully requested";

				}
				else
				{
				   $data["error"] = "Not enough UPcoins";
				}
			}
			else
			{
				$data["error"] = "Invalid amount";
			}

		}

        return view('member.redeem',$data);
	}

	public function code_generator()
	{
		
		$chars="0123456789";
		$res = "";
		for ($i = 0; $i < 8; $i++) {
		    $res .= $chars[mt_rand(0, strlen($chars)-1)];
		}

		return $res;

	}
}