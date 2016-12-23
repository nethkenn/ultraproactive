<?php namespace App\Http\Controllers;
use Request;
use App\Tbl_lead;
use App\Tbl_account;
use Carbon\Carbon;
use App\Classes\Customer;
use Redirect;
use Session;
use App\Classes\Log;
use Validator;
use Crypt;
use DB;

class MemberLeadController extends MemberController
{
	public function index()
	{	
		$data['error'] = Session::get('message');
		$data['success']  = Session::get('success');
		$data['acc'] = Tbl_account::where('account_id',Customer::id())->first();
		$data['lead'] = Tbl_lead::where('lead_account_id',Customer::id())->getaccount()->get();
		$data['leadcount'] = Tbl_lead::where('lead_account_id',Customer::id())->getaccount()->count();
		if(isset($_POST['addlead']))
		{
			$info = $this->addlead(Request::input());

			if(isset($info['success']))
			{
			   $message = $info['success'];
			   return Redirect::to('member/leads')->with('success',$message);
			}
			else
			{
			   $message = $info['error'];
			   return Redirect::to('member/leads')->with('message',$message);
			}
			
		}
        return view('member.lead',$data);
	}

	public function saveLeadManual()
	{

		$rules['first_name'] = 'required';
		$rules['middle_name'] = 'required';
		$rules['last_name'] = 'required';
		$rules['gender'] = 'required';
		$rules['email'] = 'required|email|unique:tbl_account,account_email';
		$rules['cellphone_number'] = 'required';
		$rules['telephone_number'] = 'required';
		$rules['birthday'] = 'required:date';
		$rules['country'] = 'required';
		$rules['username'] = 'required|unique:tbl_account,account_username';
		$rules['password'] = 'required|min:8';
		$rules['confirm_password'] = 'required|same:password';

		$validator = Validator::make(Request::input(), $rules);
        if ($validator->fails()) {
            return redirect('/member/leads#add-leads-manual-modal')
                        ->withErrors($validator)
                        ->withInput();
        }



		$checked_name  = Tbl_account::where("account_name","LIKE",Request::input('first_name') ." ". Request::input('middle_name') ." ". Request::input('last_name'))->where("archived",0)->first();
		if($checked_name)
		{
			$message      = 'The name "'.Request::input('first_name') ." ". Request::input('middle_name') ." ". Request::input('last_name').'"'.' is already registered. Only 1 account(that may composed with 7slots) is allowed. You may contact UPMI Admin for your concern on this matter.';
            return redirect('/member/leads#add-leads-manual-modal')
                        ->with('name_error',$message)
                        ->withInput();
		}
		
		// dd(123);
        $now = Carbon::now();

        $insertAccount['account_name'] = Request::input('first_name') ." ". Request::input('middle_name') ." ". Request::input('last_name');
        $insertAccount['account_email'] = Request::input('email');
        $insertAccount['account_username'] = Request::input('username');
        $insertAccount['account_contact_number'] = Request::input('cellphone_number');
        $insertAccount['account_country_id'] = 2;
        $insertAccount['account_date_created'] = $now;
        $insertAccount['birthday'] = Request::input('birthday');
        $insertAccount['telephone'] = Request::input('telephone_number');
        $insertAccount['gender'] = Request::input('gender');
        $insertAccount['address'] = Request::input('address');
        $insertAccount['account_password'] =  Crypt::encrypt(Request::input('password'));

        $accountId = Tbl_account::insertGetId($insertAccount);

        $insertLead['lead_account_id'] = Customer::info()->account_id;;
        $insertLead['account_id'] = $accountId;
        $insertLead['join_date'] = $now;
        DB::table('tbl_lead')->insert($insertLead);

        return redirect()->back();

	}
	// public function addlead($d)
	// {
	// 	$data = Tbl_account::where('account_username',$d['name'])->first();
	// 	if($data)
	// 	{
	// 			$ld =	Tbl_lead::where('account_id',$data->account_id)->where('lead_account_id',Customer::id())->first();
	// 			if($ld)
	// 			{
	// 				$message['error'] = "Already your lead.";
	// 				return $message;
	// 			}
	// 			else if($data->account_id == Customer::id())
	// 			{
	// 				$message['error'] = "Cannot lead yourself.";
	// 				return $message;	
	// 			}
	// 			else
	// 			{
	// 				$insert['lead_account_id'] = Customer::id();
	// 				$insert['account_id'] = $data->account_id;
	// 				$insert['join_date'] = Carbon::now();
	// 				Tbl_lead::insert($insert);
	// 				Log::account(Customer::id()," Added a lead ($data->account_name)");
	// 				$message['success'] = " Successfully added $data->account_name";
	// 				return $message;
	// 			}
	// 	}
	// 	else
	// 	{
	// 		$message['error'] = "Username not found";
	// 		return $message;
	// 	}
	// }
	// public function link($slug)
	// {
	// 	$data = Tbl_account::where('account_id',Customer::id())->first();
	// 	$email = Tbl_account::where('account_username',$slug)->first();
	// 	if($email)
	// 	{
	// 			$ld =	Tbl_lead::where('account_id',$data->account_id)->where('lead_account_id',$email->account_id)->first();
	// 			if($ld)
	// 			{
	// 				$error = "You are already a lead.";
	// 				return Redirect::to('member/leads')->with('message',$error);
	// 			}
	// 			else if( $email->account_id == Customer::id())
	// 			{
	// 				$error = "Cannot lead yourself.";
	// 				return Redirect::to('member/leads')->with('message',$error);
	// 			}
	// 			else
	// 			{
	// 				$insert['lead_account_id'] = $email->account_id;
	// 				$insert['account_id'] = Customer::id();
	// 				$insert['join_date'] = Carbon::now();
	// 				Tbl_lead::insert($insert);
	// 				$success = "Successfully become a lead of $email->account_name.";
	// 				return Redirect::to('member/leads')->with('success',$success);
	// 			}
	// 	}
	// 	else
	// 	{
	// 			$error = "Email not found.";
	// 			return Redirect::to('member/leads')->with('message',$error);
	// 	}
	// 	return Redirect::to("member/leads");
	// }
}