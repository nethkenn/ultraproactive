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
		$data = Session::get('message');
		if(Request::input('submit'))
		{	
			$data =	$this->checkifvalidate(Request::input());
			return Redirect::to('member/register')->with('message',$data);
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
		$birthday = $data["ryear"] . "-" . $data["rmonth"]. "-" . $data["rday"];
				$validator = Validator::make(
				[
					'account_name' => $data['fname']." ".$data['mname']." ".$data['lname'],
					'account_username'=>$data['user'],
					'account_email'=>$data['email'],
					'account_remail'=>$data['remail'],
					'account_country_id'=>$data['country'],
					'account_password' => $data['pass'],
					'account_rpassword' => $data['rpass'],
					'phone' => $data['cp'],			
					'telephone' => $data['tp'],
					'address' => $data['address'],
					'gender' => $data['gender'],
				],
				[
					'account_name' => 'required|min:5|regex:/^[a-zA-Z\s]*$/',
					'account_country_id' => 'required', 
					'account_email' => 'required|email|unique:tbl_account,account_email|same:account_remail',
					'account_username' => 'required|unique:tbl_account,account_username',
					'phone' => 'required',
					'gender' => 'required',
					'telephone' => 'required',
					'address' => 'required|min:6',
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
					$insert['account_contact_number'] = $data['cp'];
					$insert['account_country_id']	  = $data['country'];
					$insert['account_password']		  = Crypt::encrypt($data['pass']);
					$insert['account_name']	 		  = $data['fname']." ".$data['mname']." ".$data['lname'];
					$insert['account_date_created']   = date('Y-m-d H:i:s');
					$insert['account_created_from']   = "Front Register";
					$insert['gender']   =  $data['gender'];
					$insert['telephone']   = $data['tp'];
					$insert['address']   = $data['address'];
					$info = DB::table('tbl_account')->insertGetId($insert);
					Customer::login($info,$insert['account_password']);
					$data2 = true;
			}
			else
			{
					$data2['error'] = $validator->messages();
			}		

		return $data2;
	}

}