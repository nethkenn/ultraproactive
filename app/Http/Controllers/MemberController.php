<?php namespace App\Http\Controllers;
use App\Classes\Customer;
use Redirect;
use DB;
use App\Classes\Product;
use Session;
use Request;
use Carbon\Carbon;
use App\Tbl_slot;
use Crypt;
use App\Tbl_wallet_logs;
use App\Tbl_membership;
use App\Tbl_account;
use App\Tbl_admin;
class MemberController extends Controller
{
	function __construct()
	{
		$customer_info = Customer::info();
		$data['slot_limit'] = DB::table('tbl_settings')->where('key','slot_limit')->first();
		$current_wallet = null;
		$data2 = null;
		$earnings = null;
		$current_gc = null;

        $disable_member_area = DB::table('tbl_settings')->where('key','disable_member_area')->first();
        if(!$disable_member_area)
        {
            DB::table('tbl_settings')->insert(['key'=>'disable_member_area','value'=>'0']);
            $disable_member_area = DB::table('tbl_settings')->where('key','disable_member_area')->first();
        }	
        if($customer_info)
        {
            if($disable_member_area->value == 1)
	        {
	        	if(Tbl_admin::where('account_id',Customer::info()->account_id)->join('tbl_admin_position','tbl_admin_position.admin_position_id','=','tbl_admin.admin_position_id')->where('admin_position_rank',0)->first())
	        	{
	        		
	        	}
	        	else
	        	{
	 	        	die("We're currently doing maintenance. We'll be back shortly.");   		
	        	}
	        }      	
        }


		if(!$data['slot_limit'])
		{
			DB::table('tbl_settings')->insert(['key'=>'slot_limit','value'=>1]);
		}
        if($customer_info)
        {
            $id = Customer::id();
            $data4 = Tbl_account::where('account_id','!=',$id)->get();
    		$membership = Tbl_membership::where('archived',0)->orderBy('membership_price','ASC')->get();
			if(Session::get("currentslot"))
			{
				$data2 = $this->getotherslot($id);
  	    		$data3 = $this->getcurrentslot($id);
  	    		$earnings = $data3['earnings'];
			    $current_wallet = $data3['current_wallet'];
			    $current_gc = $data3['current_gc'];
			    $data3 = $data3['data3'];
				if($data3)
				{
	    			/* Check Date if need to reset daily pair */
				    /* Check Date if need to reset daily income*/
					$this->check_daily($data3);				
				}
				else
				{
					Session::forget("currentslot");	
					return Redirect::to(Request::input('url'))->send();	
				}
			}	
			else
			{
	    		$data3 = $this->getcurrentslot($id);
	    		$data3 = $data3['data3'];
			    if($data3)
			    {
					Session::put("currentslot", $data3->slot_id);
					if(Session::get("currentslot"))
					{
						/* Get Wallet Data*/
						$data2 = $this->getotherslot($id);
		  	    		$data3 = $this->getcurrentslot($id);
		  	    		$earnings = $data3['earnings'];
					    $current_wallet = $data3['current_wallet'];
					    $current_gc = $data3['current_gc'];
					    $data3 = $data3['data3'];
		    			/* Check Date if need to reset daily pair */
					    /* Check Date if need to reset daily income*/
						$this->check_daily($data3);
					}	
			    }	 					  
			}	
            View()->share("member", $customer_info);
            View()->share("slot", $data2);
            View()->share("slotnow", $data3);
            View()->share("earnings",$earnings);
            View()->share("current_wallet", $current_wallet);
            View()->share("current_gc", $current_gc);
            View()->share("membership", $membership);
            View()->share("accountlist", $data4);       
        }
        else
        {
            return Redirect::to("member/login")->send();
        }
	}

	public function getotherslot($id)
	{
    		$data2 = DB::table('tbl_slot')->where('slot_owner',$id)
					  					  ->where('slot_id','!=',Session::get("currentslot"))							  					  
					 					  ->get();	
			foreach($data2 as $key => $d)
			{
				$data2[$key]->total_wallet = Tbl_wallet_logs::id($d->slot_id)->wallet()->sum('wallet_amount');
				$data2[$key]->total_gc = Tbl_wallet_logs::id($d->slot_id)->gc()->sum('wallet_amount');
			}

			return $data2;
	}

	public function getcurrentslot($id)
	{
    		$data['data3'] = DB::table('tbl_slot')->where('slot_owner',$id)
										  ->where('slot_id',Session::get("currentslot"))
										  ->join('tbl_membership','tbl_membership.membership_id','=','tbl_slot.slot_membership')
										  ->join('tbl_rank','tbl_rank.rank_id','=','tbl_slot.slot_rank')
										  ->first();
		    if(!$data['data3'])
		    {
    		$data['data3'] = DB::table('tbl_slot')->where('slot_owner',$id)
										  ->join('tbl_membership','tbl_membership.membership_id','=','tbl_slot.slot_membership')
										  ->join('tbl_rank','tbl_rank.rank_id','=','tbl_slot.slot_rank')
										  ->first();
		    }

		    $data['current_wallet'] = Tbl_wallet_logs::id(Session::get('currentslot'))->wallet()->sum('wallet_amount');
		    $data['current_gc'] = Tbl_wallet_logs::id(Session::get('currentslot'))->gc()->sum('wallet_amount');
		    $data['earnings']['binary'] = Tbl_wallet_logs::id(Session::get('currentslot'))->wallet()->where('keycode','binary')->sum('wallet_amount');
		   	$data['earnings']['mentor'] = Tbl_wallet_logs::id(Session::get('currentslot'))->wallet()->where('keycode','matching')->sum('wallet_amount');
		   	$data['earnings']['direct'] = Tbl_wallet_logs::id(Session::get('currentslot'))->wallet()->where('keycode','direct')->sum('wallet_amount');
		   	$data['earnings']['indirect'] = Tbl_wallet_logs::id(Session::get('currentslot'))->wallet()->where('keycode','indirect')->sum('wallet_amount');
		    $data['earnings']['total_income'] = Tbl_wallet_logs::id(Session::get('currentslot'))->wallet()->where('wallet_amount','>=',0)->sum('wallet_amount');
		    $data['earnings']['total_withdrawal'] = Tbl_wallet_logs::id(Session::get('currentslot'))->wallet()->where('wallet_amount','<=',0)->sum('wallet_amount');
		    $data['earnings']['total_withdrawal'] = ($data['earnings']['total_withdrawal']) * (-1);
		    return $data;
	}

	public function check_daily($data3)
	{
		$date =  Carbon::now()->format('Y-m-d A'); 
		$checktime = Carbon::now();
		if($data3->slot_today_date != $date)
		{
		 $update['slot_today_income'] = 0; 
		 $update['slot_today_date'] = $date;
         Tbl_slot::where('slot_id',$data3->slot_id)->update($update);
		}

		if($data3->pairs_per_day_date != $date)
		{
		 $update['pairs_per_day_date'] = $date;
		 $update['pairs_today'] = 0;
         Tbl_slot::where('slot_id',$data3->slot_id)->update($update);
		}	
	}
}