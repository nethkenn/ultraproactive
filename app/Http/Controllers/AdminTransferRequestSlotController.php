<?php namespace App\Http\Controllers;
use DB;
use Redirect;
use Request;
use App\Classes\Image;
use App\Classes\Log;
use App\Classes\Admin;
use App\Tbl_slot;
use App\Tbl_account;
use App\Tbl_wallet_logs;
use App\Tbl_request_transfer_slot;
use Session;
use Carbon\Carbon;
class AdminTransferRequestSlotController extends AdminController
{
	public function index()
	{

		$data["_request"] = Tbl_request_transfer_slot::get();
		$data['success']  = Session::get('success');
		// foreach($data["_request"] as $request)
		// {
		// 	if($request->transfer_status == 0 && $request->archived == 0)
		// 	{
		// 		  $difference  = Carbon::parse($request->transfer_date)->diffInHours(Carbon::now());
		// 		  if($difference >= 48)
		// 		  {
		//    		     $update["archived"] = 1;
	 // 				 Tbl_request_transfer_slot::where("transfer_id",$request->transfer_id)->update($update);
		// 		  }
		// 	}
		// }

		$data["_request"] = Tbl_request_transfer_slot::get();

		return view('admin.transaction.transfer_slot',$data);
	}

	public function transfer_get()
	{
		$id          = Request::input("id");
		$transfer    = Tbl_request_transfer_slot::where("transfer_id",$id)->where('archived',0)->where('transfer_status',0)->first();
		if($transfer)
		{
		  $difference  = Carbon::parse($transfer->transfer_date)->diffInHours(Carbon::now());
		  if($difference >= 48)
		  {
			   return Redirect::to('/admin/transaction/sales/transfer_slot_request');
		  }
		  else
		  {
			  $message     = "Successfully Approved";
			  Tbl_slot::where('slot_id',$transfer->owner_slot_id)->update(['slot_owner'=>$transfer->transfer_to_account_id]); 				  
			  Log::Admin(Admin::info()->account_id,Admin::info()->account_username." approved the transfer id #".$transfer->transfer_id,null,null);
	 		  $update["transfer_status"] = 1;
		  	  Tbl_request_transfer_slot::where("transfer_id",$id)->update($update);
			  return Redirect::to('/admin/transaction/sales/transfer_slot_request')->with('success',$message);
		  }
		}
		else
		{
		  return Redirect::to('/admin/transaction/sales/transfer_slot_request');
		}
	}

	public function transfer_get_decline()
	{
		$id          = Request::input("id");
		$transfer    = Tbl_request_transfer_slot::where("transfer_id",$id)->where('archived',0)->where('transfer_status',0)->first();
		if($transfer)
		{
		  $message     = "Successfully Cancelled the request";
		  $update["transfer_status"] = 2;
		  Tbl_request_transfer_slot::where("transfer_id",$id)->update($update);

		  Log::Admin(Admin::info()->account_id,Admin::info()->account_username." cancel the transfer id #".$transfer->transfer_id,null,null);
		 	
		  return Redirect::to('/admin/transaction/sales/transfer_slot_request')->with('success',$message);
		}
		else
		{
		  return Redirect::to('/admin/transaction/sales/transfer_slot_request');
		}
	}
}