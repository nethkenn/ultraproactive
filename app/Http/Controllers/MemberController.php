<?php namespace App\Http\Controllers;
use App\Classes\Customer;
use Redirect;
use DB;
use App\Classes\Product;
use Session;
use Request;
use Carbon\Carbon;
use App\Tbl_slot;
class MemberController extends Controller
{
	function __construct()
	{
		$date = Carbon::now()->toDateString(); 
		$customer_info = Customer::info();

		// dd($customer_info);
        if($customer_info)
        {
	            $id = Customer::id();

	    		$membership = DB::table('tbl_membership')->where('archived',0)
	    												 ->orderBy('membership_price','ASC')
	    												 ->get();
	    		$data4 = DB::table('tbl_account')->where('account_id','!=',$id)->get();
						 
				if(Session::get("currentslot"))
				{
		    		$data2 = DB::table('tbl_slot')->where('slot_owner',$id)
							  					  ->where('slot_id','!=',Session::get("currentslot"))							  					  
							 					  ->get();	
	  	    		$data3 = DB::table('tbl_slot')->where('slot_owner',$id)
												  ->where('slot_id',Session::get("currentslot"))
												  ->join('tbl_membership','tbl_membership.membership_id','=','tbl_slot.slot_membership')
												  ->join('tbl_rank','tbl_rank.rank_id','=','tbl_slot.slot_rank')
												  ->first();
				if($data3)
				{
					if($data3->slot_today_date != $date)
					{
					 $update['slot_today_income'] = 0; 
					 $update['slot_today_date'] = $date;
                     Tbl_slot::where('slot_id',$id)->update($update);
					}

					if($data3->pairs_per_day_date != $date)
					{
					 $update['pairs_per_day_date'] = $date;
					 $update['pairs_today'] = 0;
                     Tbl_slot::where('slot_id',$id)->update($update);
					}					
				}
				else
				{
					Session::forget("currentslot");	
					return Redirect::to(Request::input('url'))->send();	
				}

				}	
				else
				{
		    		$data3 = DB::table('tbl_slot')->where('slot_owner',$id)
		    									  ->join('tbl_membership','tbl_membership.membership_id','=','tbl_slot.slot_membership')
		    									  ->join('tbl_rank','tbl_rank.rank_id','=','tbl_slot.slot_rank')
							 					  ->first();

							 					 	
				    if($data3)
				    {
  						Session::put("currentslot", $data3->slot_id);
  					    if(Session::get("currentslot"))
						{
				    		$data2 = DB::table('tbl_slot')->where('slot_owner',$id)
									  					  ->where('slot_id','!=',Session::get("currentslot"))							  					  
									 					  ->get();	
			  	    		$data3 = DB::table('tbl_slot')->where('slot_owner',$id)
														  ->where('slot_id',Session::get("currentslot"))
														  ->join('tbl_membership','tbl_membership.membership_id','=','tbl_slot.slot_membership')
														  ->join('tbl_rank','tbl_rank.rank_id','=','tbl_slot.slot_rank')
														  ->first();

							if($data3->slot_today_date != $date)
							{
							 $update['slot_today_income'] = 0; 
							 $update['slot_today_date'] = $date;
                             Tbl_slot::where('slot_id',$id)->update($update);
							}

							if($data3->pairs_per_day_date != $date)
							{
							 $update['pairs_per_day_date'] = $date;
							 $update['pairs_today'] = 0;
                             Tbl_slot::where('slot_id',$id)->update($update);
							}
						}	
				    }
				    else
				    {
		  	    	 	$data2 = null;	
				    }		 					  
				}			 
				


	            View()->share("member", $customer_info);
	            View()->share("slot", $data2);
	            View()->share("slotnow", $data3);
	            View()->share("membership", $membership);
	            View()->share("accountlist", $data4);
	            // if($highest_role_access != 0)
	            // {

	            //     $modules = DB::table('tbl_admin_has_module')->where('role_id', $customer_info->admin_role)->get();
	            //     $allowed_module = null;
	            //     if($modules)
	            //     {
	            //         foreach ($modules as $key => $value)
	            //         {
	            //             $allowed_module[] = $value->module;
	            //         }
	            //     }

	            //     $allowed_module[] = "admin";  
	            //     $allowed_module[] = "account";

	               
	                
	            //     $array_segment = $this->get_url_segment(Request::path());
	            //     $intersected_array = array_intersect($array_segment, $allowed_module);
	            //     // View()->share("admin", $admin_info);
	            //     if(Request::path() != "admin" && count($intersected_array) <= 1)
	            //     {
	            //         // return redirect()->back();
	            //         return abort(404);
	            //     }

	            // } 

	            if(Request::input('slotnow'))
				{
					$condition = false;
		    		$checkslot = 	Tbl_slot::where('slot_owner',Customer::id())	
		    										  ->where('slot_id',Request::input('slotnow'))				  					  
								 					  ->first();
								 				
					if($checkslot)
					{
						if($checkslot->slot_id == Request::input('slotnow'))
						{
							$condition = true;
						}						
					}

		

					if($condition == true)
					{
						Session::put('currentslot',Request::input('slotnow'));						
					}					  

					if(Request::input('dd'))
					{
						dd(Request::input('slotnow'),Customer::id(),$checkslot,$condition);	
					}
					
					return Redirect::to(Request::input('url'))->send();				
				}        
	        }
	        else
	        {
	            return Redirect::to("member/login")->send();
	        }
	}
}