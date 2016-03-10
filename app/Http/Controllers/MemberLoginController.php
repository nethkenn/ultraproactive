<?php namespace App\Http\Controllers;
use Request;
use App\Classes\Customer;
use Redirect;
use Crypt;
use Session;
use DateTime;
use App\Tbl_slot;
use Carbon\Carbon;
use App\Tbl_account;
use DB;
class MemberLoginController extends Controller
{
	public function index()
	{	
		$data['error'] = Session::get('errored');
		$data['success'] = Session::get('greened');
		$member_id = Customer::id();
		if(Request::isMethod("post"))
		{
			$user = Request::input('user');
			$pass = Request::input('pass');

			$member = Customer::authenticate($user, $pass);

	            if($member)
	            {	
	            	if($member->account_approved == 1)
	            	{
	            		if ($member->blocked == 0) 
	            		{
	            			$pass =	Crypt::encrypt($pass);
			                Customer::login($member->account_id,$pass);
			                return Redirect::to("member");
	            		}
			            else
			            {
			            	return Redirect::to("member/login")->with("errored","Invalid Account.");
			            }
	            	}
	            	else if($member->account_expired == 1)
	            	{
						return Redirect::to("member/login")->with("errored","This account is already expired.");
	            	}
	            	else
	            	{
	            				$expired_day = $this->expiration();	
		    					$fdate = new DateTime($member->account_date_created);
								$ldate = new DateTime(Carbon::now());
						        $difference = date_diff($fdate, $ldate);
						        $count = Tbl_slot::where('slot_owner',$member->account_id)->count();

						        if($difference->days >= $expired_day)
						        {
						        	if($count == 0)
						        	{
						        		Tbl_account::where('account_id',$member->account_id)->update(['account_expired'=>1]);
						        		return Redirect::to("member/login")->with("errored","This account is already expired.");
						        	}
						        	else
						        	{
					        		 Tbl_account::where('account_id',$member->account_id)->update(['account_approved'=>1]);
									 $member = Customer::authenticate($user, $pass);
				          			 $pass   =	Crypt::encrypt($pass);
						         	 Customer::login($member->account_id,$pass);
						         	 return Redirect::to("member");
						        	}
						        }
						        else
						        {
					        		if($count == 0)
						        	{
										 $member = Customer::authenticate($user, $pass);
										 $pass   =	Crypt::encrypt($pass);
							             Customer::login($member->account_id,$pass);
							             return Redirect::to("member");
						        	}
						        	else
						        	{
					        		 	 Tbl_account::where('account_id',$member->account_id)->update(['account_approved'=>1]);
										 $member = Customer::authenticate($user, $pass);
										 $pass   =	Crypt::encrypt($pass);
							             Customer::login($member->account_id,$pass);
							             return Redirect::to("member");
						        	}
						        }
	            	}	       			   
	            }
	            else
	            {
	                return Redirect::to("member/login")->with("errored","Invalid Account");
	            }
		}

		$customer_info = Customer::info();
        if($customer_info)
        {
          return Redirect::to('member');
	    }
        return view('member.login',$data);
	}
	public function logout()
	{
		Customer::logout();
		return Redirect::to("member/login");
	}
	public function expiration()
	{
		$day = DB::table('tbl_settings')->where('key','expiration_day')->first();
		if(!$day)
		{
			DB::table('tbl_settings')->where('key','expiration_day')->insert(['key'=>'expiration_day','value'=>2]);
			$day = DB::table('tbl_settings')->where('key','expiration_day')->first();
		}
		$day = $day->value;
		return $day;
	}
}