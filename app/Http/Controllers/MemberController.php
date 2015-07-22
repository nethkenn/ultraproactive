<?php namespace App\Http\Controllers;
use App\Classes\Customer;
use Redirect;
use DB;
use App\Classes\Product;
use Session;
use Request;
class MemberController extends Controller
{
	function __construct()
	{
		$customer_info = Customer::info();

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
					Session::put('currentslot',Request::input('slotnow'));
					return Redirect::to(Request::url())->send();				
				}        
	        }
	        else
	        {
	            return Redirect::to("member/login")->send();
	        }
	}
}