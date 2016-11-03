<?php namespace App\Http\Controllers;
use JasperPHP;
use Request;
use DB;
use App\Classes\Product;
use Carbon\Carbon;
use Config;
use App\Classes\Log;
use App\Classes\Admin;
use Datatables;
use Redirect;
use App\Tbl_redeem_request;
class AdminRedeemController extends AdminController
{
	public function index()
	{
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits Redeem");
		$data["page"] = "Admin Redeem Controller";
		// 
        return view('admin.transaction.redeem');
	}
	
	
	public function get_redeem()
	{

		$redeem = Tbl_redeem_request::where("tbl_redeem_request.archived",0)->join("tbl_slot","tbl_slot.slot_id","=","tbl_redeem_request.slot_id")->join("tbl_account","tbl_account.account_id","=","tbl_slot.slot_owner")->get();

		return Datatables::of($redeem) ->editColumn('view','<a style="cursor: pointer;" href="{{$status == "Claimed" ? "javascript:" : "/admin/transaction/redeem/claim/".$request_code }}" class="view-redeem" voucher-id="{{$request_id}}">{{$status == "Claimed" ? "Claimed" : "Claim Now" }}</a>') 
			                            ->make(true);
	}
	
	public function claim($id)
	{
		$redeem = DB::table("tbl_redeem_request")->where("request_code",$id)->where("archived",0)->first();
		if(!$redeem)
		{
			return Redirect::to("/admin/transaction/redeem")->with('error_message', 'Cannot find the requested code');
		}
		else
		{
			if($redeem->status == "Claimed")
			{
				return Redirect::to("/admin/transaction/redeem")->with('error_message', 'This code is already claimed');
			}
			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." Claimed the request redeem id #".$redeem->request_id);
			
			$update["status"] = "Claimed";
			$update["date_claimed"] = Carbon::now();
			DB::table("tbl_redeem_request")->where("request_id",$redeem->request_id)->update($update);
			
			return Redirect::to("/admin/transaction/redeem")->with('success_message', 'Successfully claimed');	
		}
        // return view('admin.transaction.view_redeem',$data);
	}
}