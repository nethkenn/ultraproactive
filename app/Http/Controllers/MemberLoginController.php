<?php namespace App\Http\Controllers;
use Request;
use App\Classes\Customer;
use Redirect;
use Crypt;
use Session;
class MemberLoginController extends Controller
{
	public function index()
	{	
		$data['error'] = Session::get('errored');

		$member_id = Customer::id();
		if(Request::isMethod("post"))
		{
			$user = Request::input('user');
			$pass = Request::input('pass');
			$member = Customer::authenticate($user, $pass);
	            if($member)
	            {	
	            	$pass =	Crypt::encrypt($pass);
	                Customer::login($member->account_id,$pass);
	                return Redirect::to("member");
	            }
	            else
	            {
	                return Redirect::to("member/login")->with("message","Invalid Account");
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
}