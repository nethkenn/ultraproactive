<?php namespace App\Http\Controllers;
use Request;
use DB;
use Crypt;
use Validator;
use App\Classes\Customer;
use Redirect;
use Session;
use App\Tbl_account;
use App\Tbl_lead;
use Carbon\Carbon;
use App\Classes\Log;
use App\Tbl_beneficiary_rel;
use App\Tbl_beneficiary;

class MemberRegisterController extends Controller
{
	public function index()
	{

		$data = Session::get('message');


		if(Request::input('submit'))
		{	
			$data =	$this->checkifvalidate(Request::input());
			return Redirect::to('member/register')->with('message',$data)
                        ->withInput(Request::input());
		}

		//Auto Redirect if login already... or after registration success
		$customer_info = Customer::info();
        if($customer_info)
        {
          	return Redirect::to('member');
	    }

	    $data['_beneficiary_rel'] = Tbl_beneficiary_rel::all();
		$data['country'] = DB::table('tbl_country')->where('archived',0)->get();
		return view('member.register',$data);
	}

	public function lead($slug)
	{
		$data = Tbl_account::where('account_id',Customer::id())->first();
		$email = Tbl_account::where('account_username',$slug)->first();
		if($email)
		{
					$data = Session::get('message');
					if(Request::input('submit'))
					{	
						$data =	$this->checkifvalidate2(Request::input(),$email);
						return Redirect::to('lead/'.$slug)->with('message',$data);
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
		else
		{
				$data2 = "Link doesn't exist";
				return Redirect::to('member/login')->with('errored',$data2);
		}

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
					'l_name' => $data['l_name'],
					'f_name' => $data['f_name'],
					'm_name' => $data['m_name'],
					'beneficiary_gender' => $data['beneficiary_gender'],
					'beneficiary_rel' =>$data['beneficiary_rel']
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
					'l_name' => 'required',
					'm_name' => 'required',
					'f_name' => 'required',
					'beneficiary_gender' => 'required',
					'beneficiary_rel' => 'required',
					// 'customer_province' => "required|exists:tbl_location,location_id",
					// 'customer_municipality' => "required|exists:tbl_location,location_id",
					// 'customer_barangay' => "required|exists:tbl_location,location_id",
					'account_password'=> 'required|min:6|same:account_rpassword'
				],

				[
					'l_name.required' => 'The beneficiary last name is required.',
					'f_name.required' => 'The beneficiary first name is required.',
					'm_name.required' => 'The beneficiary middle name is required.',
				]
				);


			if(!$validator->fails())
			{		

					$b_rel = Tbl_beneficiary_rel::firstOrCreate(['relation'=>$data['beneficiary_rel']]);

					$insert_beneficiary['l_name'] = $data['l_name'];
					$insert_beneficiary['m_name'] = $data['m_name'];
					$insert_beneficiary['f_name'] = $data['f_name'];
					$insert_beneficiary['beneficiary_gender']  =  $data['beneficiary_gender'];
					$insert_beneficiary['beneficiary_rel_id']  =  $b_rel->beneficiary_rel_id;

					$Tbl_beneficiary = new Tbl_beneficiary($insert_beneficiary);
					$Tbl_beneficiary->save();


					$insert['beneficiary_id'] = $Tbl_beneficiary->beneficiary_id;
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
	public function checkifvalidate2($data,$email)
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
					$x['lead_account_id'] = $email->account_id;
					$x['account_id'] = $info;
					$x['join_date'] = Carbon::now();
					Tbl_lead::insert($x);
					Log::account($email->account_id,$insert['account_name'].' successfully added as your lead through link');
					if($email->gender == "Male")
					{
						Log::account($info,'Successfully become a lead of '.$email->account_name.' through his link');
					}
					else if ($email->gender == "Female")
					{
						Log::account($info,'Successfully become a lead of '.$email->account_name.' through her link');
					}
					else
					{
						Log::account($info,'Successfully become a lead of '.$email->account_name.' through his/her link');
					}
			}
			else
			{
					$data2['error'] = $validator->messages();
					return $data2;
			}		


	}

}