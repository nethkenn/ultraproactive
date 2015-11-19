<?php namespace App\Http\Controllers;
use App\Tbl_account_log;
use App\Tbl_slot;
use App\Tbl_slot_log;
use App\Tbl_lead;
use App\Tbl_membership;
use App\Classes\Customer;
use DB;
use App\Tbl_product_code;
use App\Tbl_tree_placement;
use App\Tbl_wallet_logs;
use Session;
use Request;
use Redirect;
class MemberReportController extends MemberController
{
	public function breakdown()
	{
		$keycode = Request::input('breakdown_name');
		$type = Request::input('type');
		$name_type = Request::input('type');
		$data['name'] = null;
		if($keycode == 'binary' || $keycode == 'direct' || $keycode == 'Old System Wallet' || $keycode == 'Old System GC' || $keycode|| 'matching' || $keycode == 'Dynamic Compression')
		{	
			if($type == 1)
			{
				$type = 'Wallet';
			}
			elseif($type == 2)
			{
				$type = 'GC';
			}	
			else
			{
				return Redirect::to('/member/reports/income_summary');
			}

			$name = Request::input('breakdown_name');

			if($keycode == 'binary' && $name_type == 2)
			{
				$name = 'Matching GC';
			}
			elseif($keycode == 'direct' && $name_type == 2)
			{
				$name = "Sponsor GC";
			}
			elseif($keycode == 'Old System Wallet' && $name_type == 1)
			{
				$name = "Old Wallet";
			}
			elseif($keycode == 'Old System GC' && $name_type == 2)
			{
				$name = "Old GC";
			}
			elseif($keycode == 'matching' && $name_type == 1)
			{
				$name = "Mentor";
			}
			elseif($keycode == 'binary' && $name_type == 1)
			{
				$name = "Matching";
			}
			elseif($keycode == 'Dynamic Compression' && $name_type == 1)
			{
				$name = "Dynamic Compression";
			}
			$data['logs'] = Tbl_wallet_logs::where('keycode','=',$keycode)->where('slot_id',Session::get('currentslot'))->where('wallet_type',$type)->where('wallet_amount','>',0)->get();
			$data['total'] = Tbl_wallet_logs::where('keycode','=',$keycode)->where('slot_id',Session::get('currentslot'))->where('wallet_type',$type)->sum('wallet_amount');
			$data['name'] = $name;
		}
		else
		{
			return Redirect::to('/member/reports/income_summary');
		}
        
        return view('member.income_breakdown', $data);
	}	

	public function summary()
	{
		
		$data['matching_gc']	 = Tbl_wallet_logs::where('keycode','=','binary')->where('slot_id',Session::get('currentslot'))->where('wallet_type','GC')->sum('wallet_amount');
		$data['sponsor_gc']  = Tbl_wallet_logs::where('keycode','=','direct')->where('slot_id',Session::get('currentslot'))->where('wallet_type','GC')->sum('wallet_amount');

		$data['old_wallet'] = Tbl_wallet_logs::where('keycode','=','Old System Wallet')->where('slot_id',Session::get('currentslot'))->sum('wallet_amount');
		$data['old_gc'] = Tbl_wallet_logs::where('keycode','=','Old System GC')->where('slot_id',Session::get('currentslot'))->sum('wallet_amount');
		$data['mentor']   = Tbl_wallet_logs::where('keycode','=','matching')->wallet()->where('slot_id',Session::get('currentslot'))->sum('wallet_amount');
		$data['matching']	 = Tbl_wallet_logs::where('keycode','=','binary')->wallet()->where('slot_id',Session::get('currentslot'))->sum('wallet_amount');
		$data['sponsor']  = Tbl_wallet_logs::where('keycode','=','direct')->wallet()->where('slot_id',Session::get('currentslot'))->sum('wallet_amount');
		$data['dynamic'] = Tbl_wallet_logs::where('keycode','=','Dynamic Compression')->where('slot_id',Session::get('currentslot'))->sum('wallet_amount');
		// $data['binary_repurchase'] = Tbl_wallet_logs::where('keycode','=','binary_repurchase')->sum('wallet_amount');
		$data['total']   = $data['old_wallet']+$data['mentor']  + $data['matching']+$data['sponsor'] +$data['dynamic'];
		 


        return view('member.income_summary', $data);
	}
}