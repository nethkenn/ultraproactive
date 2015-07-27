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
		if($slot->slot_wallet >= $amt)
		{
			$total = $slot->slot_wallet - $amt;
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
				Tbl_slot::where('slot_id',$slot_id)->update(['slot_wallet'=>$total]);
				$insert['deduction'] = $t;
				Tbl_account_encashment_history::insert($insert);
				Log::account(Customer::id(),'Encashed a wallet total of '.$amt); 
				Log::slot(Session::get('currentslot'),'Encash a wallet',$total); 				
			}

		}
		else
		{
			$total = 0;
		}

		return $total;
	}
}