<?php namespace App\Http\Controllers;
use App\Classes\Customer;
use Redirect;
use DB;
use App\Classes\Product;
use Session;
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
				if(Session::get("currentslot"))
				{
		    		$data2 = DB::table('tbl_slot')->where('slot_owner',$id)
							  					  ->where('slot_id','!=',Session::get("currentslot"))
							 					  ->get();	
	  	    		$data3 = DB::table('tbl_slot')->where('slot_owner',$id)
												  ->where('slot_id',Session::get("currentslot"))
												  ->first();
				}	
				else
				{
		    		$data2 = DB::table('tbl_slot')->where('slot_owner',$id)
							 					  ->get();	
	  	    		$data3 = DB::table('tbl_slot')->where('slot_owner',$id)
												  ->first();							 					  
				}			 
	



	            View()->share("member", $customer_info);
	            View()->share("slot", $data2);
	            View()->share("slotnow", $data3);
	            View()->share("membership", $membership);

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
	        }
	        else
	        {
	            return Redirect::to("member/login")->send();
	        }
	}
}