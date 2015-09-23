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
use App\Tbl_account;
use App\Tbl_request_transfer_wallet;
use App\Tbl_wallet_logs;
class MemberTransferWalletController extends MemberController
{
	public function index()
	{	
		$id = Session::get('account_id');
		$id = Crypt::decrypt($id);
		$checkslot = Tbl_slot::where('slot_id',Session::get("currentslot"))->membership()->first();
		$data["error"] = null;
      	$data["_pending"] = Tbl_request_transfer_wallet::where('sent_by',Customer::id())->where('done',0)->where('cancelled',0)->slot()
  																						->account()
      																				    ->selectRaw('tbl_account.account_name, tbl_account.account_name')
      																					->selectRaw('transfer_id, transfer_id')
      																					->selectRaw('amount, amount')
      																					->selectRaw('slot_id, slot_id')
      																					->selectRaw('sent_slot_by, sent_slot_by')
      																					->get();
      	$data['_accept'] = 	Tbl_request_transfer_wallet::where('done',0)->where('cancelled',0)->slotby()
      																					->where('received_by',Customer::id())
  																						->accountby()
      																				    ->selectRaw('tbl_account.account_name, tbl_account.account_name')
      																					->selectRaw('transfer_id, transfer_id')
      																					->selectRaw('amount, amount')
      																					->selectRaw('slot_id, slot_id')
      																					->selectRaw('received_slot_by, received_slot_by')
      																					->get();																			
        $data['info'] = $checkslot;
        $lockin = $checkslot->transfer_limit;

		$data['currentwallet'] = Tbl_wallet_logs::id(Session::get('currentslot'))->wallet()->sum('wallet_amount');
		$wallet = $data['currentwallet'];
		if(isset($_POST['sent']))
		{
			$account = Tbl_account::where('account_username',Request::input("username"))->first();
			if(Request::input('transfer_wallet') > 0)
			{
				if($account)
				{
					if($wallet >= Request::input('transfer_wallet'))
					{
						$slot = Tbl_slot::where('slot_id',Session::get('currentslot'))->where('slot_owner',Customer::id())->account()->first();
						
						$recipient_slot = Tbl_slot::where('slot_id',Request::input('placement'))->where('slot_owner',$account->account_id)->account()->first();
						if($slot)
						{
							$insert['sent_by'] = Customer::id();
							$insert['received_by'] = $account->account_id;
							$insert['sent_slot_by'] = Session::get('currentslot');
							$insert['received_slot_by'] = Request::input('placement');
							$insert['amount'] = Request::input('transfer_wallet');
							$insert['created_at'] = Carbon::now();
							// Tbl_slot::where('slot_id',Session::get('currentslot'))->where('slot_owner',Customer::id())->update(["slot_wallet"=>$slot->slot_wallet - Request::input('transfer_wallet')]);									  

							$trans_id = Tbl_request_transfer_wallet::insertGetId($insert);
						    $log = "Transfer ID #".$trans_id.",You sent an amount of ".Request::input('transfer_wallet')." using slot #".Session::get('currentslot')." to ".$recipient_slot->account_name." (Slot #".Request::input('placement').").";
						    Log::account(Customer::id(), $log);

						    $log = "Transfer ID #".$trans_id.",".$slot->account_name." sent you an amount of ".Request::input('transfer_wallet')." to your slot #".Request::input('placement')." using his slot #".Session::get('currentslot')." Please accept it in Transfer wallet area." ;
						    Log::account($account->account_id, $log);

						    $log = "Transfer ID #".$trans_id.",You sent an amount of ".Request::input('transfer_wallet')." using slot #".Session::get('currentslot')." to ".$recipient_slot->account_name." (Slot #".Request::input('placement').").";
						    Log::slot(Session::get('currentslot') , $log, 0 - Request::input('transfer_wallet') , "Transfer Wallet Pending",Request::input('placement'));
							return Redirect::to('member/transfer_wallet')->with('success',"Transfer sent");
						}
						else
						{
							$data["error"] = "Some error occurred.";
						}
					}
					else
					{
						$data["error"] = "Not enough wallet to provide this amount.";
					}
					// else
					// {
					// 	$data["error"] = "Some error occurred.";	
					// }
				}
				else
				{
					$data["error"] = "Invalid username";
				}	
			}
			else
			{
				$data["error"] = "Cannot transfer a negative amount.";
			}
		}

		if(isset($_POST['cancel']))
		{
			$get = Tbl_request_transfer_wallet::where('transfer_id',Request::input('cancel'))->where('sent_by',Customer::id())->where('cancelled',0)->where('done',0)->first();
			if($get)
			{				
				$account_sender = Tbl_account::where('account_id',$get->sent_by)->first();
				$account_receiver = Tbl_account::where('account_id',$get->received_by)->first();
				$checkslot = Tbl_slot::where('slot_id',$get->sent_slot_by)->first();
				// $update["slot_wallet"] = $checkslot->slot_wallet + $get->amount;
				// Tbl_slot::where('slot_id',$get->sent_slot_by)->update($update);
				Tbl_request_transfer_wallet::where('transfer_id',Request::input('cancel'))->where('sent_by',Customer::id())->update(["cancelled"=>1]);
			    
			    $log = "Transfer ID #".$get->transfer_id.", Cancelled by the transferrer (".$account_sender->account_name.")";
			    Log::account($get->received_by, $log);
			    Log::slot($get->received_slot_by,$log,0,"Transfer Wallet Cancel by sender",$get->sent_slot_by);

			    $log = "You cancelled transfer ID #".$get->transfer_id."and an amount of ".$get->amount." sent back to your slot #".$get->sent_slot_by;
			    Log::account($get->sent_by, $log);
			    Log::slot($get->sent_slot_by,$log,$get->amount,"Transfer Wallet Cancel",$get->sent_slot_by);
				return Redirect::to('member/transfer_wallet')->with('success',"Cancelled the order.");		
			}
			else
			{
				$get = Tbl_request_transfer_wallet::where('transfer_id',Request::input('cancel'))->where('sent_by',Customer::id())->where('cancelled',0)->where('done',1)->first();
				if($get)
				{
					$data["error"] = "This is already confirmed to the recipient of this request.";
				}
				else
				{	
					$get = Tbl_request_transfer_wallet::where('transfer_id',Request::input('cancel'))->where('sent_by',Customer::id())->where('cancelled',1)->first();
					if($get)
					{
						$data["error"] = "This is already cancelled.";
					}
					else
					{
						$data["error"] = "Some error occurred.";
					}
				}
			}
		}

		if(isset($_POST['accept']))
		{
			$get = Tbl_request_transfer_wallet::where('transfer_id',Request::input('accept'))->where('received_by',Customer::id())->where('cancelled',0)->where('done',0)->first();

			if($get)
			{
				$account_sender = Tbl_account::where('account_id',$get->sent_by)->first();
				$account_receiver = Tbl_account::where('account_id',$get->received_by)->first();
				$checkslot = Tbl_slot::where('slot_id',$get->received_slot_by)->first();
				// $update["slot_wallet"] = $checkslot->slot_wallet + $get->amount;
				// Tbl_slot::where('slot_id',$get->received_slot_by)->update($update);
				Tbl_request_transfer_wallet::where('transfer_id',Request::input('accept'))->where('received_by',Customer::id())->update(["done"=>1]);

				$log = "The recipient ".$account_receiver->account_name." accepted the transfer from Transfer ID#".$get->transfer_id." and he/she gained an amount of ".$get->amount;
			    Log::account($get->received_by, $log);
			    Log::slot($get->sent_slot_by,$log,0,"Transfer Wallet Accepted by the recipient",$get->received_slot_by);

			    $log = "Transfer ID #".$get->transfer_id.","."Accepted and gain amount of ".$get->amount." to your slot #".$get->received_slot_by;
			    Log::account($get->sent_by, $log);
			    Log::slot($get->received_slot_by,$log,$get->amount,"Transfer Wallet Accepted",$get->received_slot_by);
			    
				return Redirect::to('member/transfer_wallet')->with('success',"Success accepting the transfered wallet.");
			}
			else
			{
				$get = Tbl_request_transfer_wallet::where('transfer_id',Request::input('accept'))->where('received_by',Customer::id())->where('cancelled',1)->where('done',0)->first();
				if($get)
				{
					$data["error"] = "This transfer is cancelled by the sender.";
				}
				else
				{	
					$get = Tbl_request_transfer_wallet::where('transfer_id',Request::input('accept'))->where('received_by',Customer::id())->where('done',0)->first();
					if($get)
					{
						$data["error"] = "This is already accepted.";
					}
					else
					{
						$data["error"] = "Some error occurred.";
					}
				}
			}
		}

        return view('member.transfer_wallet',$data);
	}

	public function get()
	{
		$check = Tbl_account::where('account_username',Request::input('owner'))->first();

		if($check == null)
		{
			$r = "x";
		}
		else
		{
			// if($check->account_id == Customer::id())
			// {
				$r = "owned";
			// }
			// else
			// {
				$e = Tbl_slot::where('slot_owner',$check->account_id)->lists('slot_id');
				$count = Tbl_slot::where('slot_owner',$check->account_id)->count();
				$r = json_encode($e);	
				if($count == 0)
				{
					$r = "zero";
				}	
			// }
	
		}
		echo json_encode($r);
	}
}