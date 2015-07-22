<?php namespace App\Http\Controllers;
use Request;
use App\Tbl_lead;
use App\Tbl_account;
use Carbon\Carbon;
use App\Classes\Customer;
use Redirect;
use Session;

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
	public function addlead($d)
	{
		$data = Tbl_account::where('account_email',$d['email'])->first();
		if($data)
		{
				$ld =	Tbl_lead::where('account_id',$data->account_id)->where('lead_account_id',Customer::id())->first();
				if($ld)
				{
					$message['error'] = "Already your lead.";
					return $message;
				}
				else if($data->account_id == Customer::id())
				{
					$message['error'] = "Cannot lead yourself.";
					return $message;	
				}
				else
				{
					$insert['lead_account_id'] = Customer::id();
					$insert['account_id'] = $data->account_id;
					$insert['join_date'] = Carbon::now();
					Tbl_lead::insert($insert);
					$message['success'] = "Successfully added $data->account_name";
					return $message;
				}
		}
		else
		{
			$message['error'] = "Email not found";
			return $message;
		}
	}
	public function link($slug)
	{
		$data = Tbl_account::where('account_id',Customer::id())->first();
		$email = Tbl_account::where('account_email',$slug)->first();
		if($email)
		{
				$ld =	Tbl_lead::where('account_id',$data->account_id)->where('lead_account_id',$email->account_id)->first();
				if($ld)
				{
					$error = "You are already a lead.";
					return Redirect::to('member/leads')->with('message',$error);
				}
				else if( $email->account_id == Customer::id())
				{
					$error = "Cannot lead yourself.";
					return Redirect::to('member/leads')->with('message',$error);
				}
				else
				{
					$insert['lead_account_id'] = $email->account_id;
					$insert['account_id'] = Customer::id();
					$insert['join_date'] = Carbon::now();
					Tbl_lead::insert($insert);
					$success = "Successfully become a lead of $email->account_name.";
					return Redirect::to('member/leads')->with('success',$success);
				}
		}
		else
		{
				$error = "Email not found.";
				return Redirect::to('member/leads')->with('message',$error);
		}
		return Redirect::to("member/leads");
	}
}