<?php namespace App\Http\Controllers;
use Request;
use DB;
use Crypt;
use Validator;
use App\Classes\Customer;
use Redirect;
use Session;


class MemberRegisterController extends Controller
{
	public function index()
	{
		$message = Session::get('message');
		if(Request::input('submit'))
		{	
			$data =	$this->checkifvalidate(Request::input());
			$message = "";
			return Redirect::to('member/register')->with('message',$message);
		}

		//Auto Redirect if login already... or after registration success
		$customer_info = Customer::info();
        if($customer_info)
        {
          	return Redirect::to('member');
	    }


		$data['country'] = DB::table('tbl_country')->where('archived',0)->get();
		return view('member.register',$data);
	}
	// public function insertdata($data)
	// {

	// }
	public function checkifvalidate($data)
	{
		$data2 = null;

				$validator = Validator::make(
				[
					'account_name' => $data['name'],
					'account_username'=>$data['user'],
					'account_email'=>$data['email'],
					'account_contact_number'=>$data['contact'],
					'account_country_id'=>$data['country'],
					'custom_field_value'=>$data['custom'],
					'account_password' => $data['pass'],
					'account_rpassword' => $data['rpass'],			
				],
				[
					'account_name' => 'required|min:5|regex:/^[\pL\s]+$/u',
					'account_country_id' => 'required', 
					'custom_field_value' => 'required',
					'account_email' => 'required|email',
					'account_username' => 'required|unique:tbl_account,account_username',
					'account_contact_number' => 'required|min:9',
					// 'customer_province' => "required|exists:tbl_location,location_id",
					// 'customer_municipality' => "required|exists:tbl_location,location_id",
					// 'customer_barangay' => "required|exists:tbl_location,location_id",
					'account_password'=> 'required|min:6|same:account_rpassword'
				]
				);


			if(!$validator->fails())
			{	
					$insert['account_username'] 	  = $data['user'];
					$insert['account_email']		  = $data['email'];
					$insert['account_contact_number'] = $data['contact'];
					$insert['account_country_id']	  = $data['country'];
					$insert['custom_field_value']	  = $data['custom'];
					$insert['account_password']		  = Crypt::encrypt($data['pass']);
					$insert['account_name']	 		  = $data['name'];
					$insert['account_date_created']   = date('Y-m-d H:i:s');
					$info = DB::table('tbl_account')->insertGetId($insert);
					Customer::login($info,$insert['account_password']);
					$data2 = true;
			}
			else
			{
				$data2['error_message'] = $validator->messages();
			}		

		return $data2;
	}

}