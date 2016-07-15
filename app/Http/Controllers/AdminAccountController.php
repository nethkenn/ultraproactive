<?php namespace App\Http\Controllers;
use DB;
use Request;
use Redirect;
use Carbon;
use Datatables;
use Crypt;
use App\Tbl_account;
use App\Tbl_account_field;
use App\Classes\Admin;
use Validator;
use App\Classes\Customer;
use App\Classes\Log;
class AdminAccountController extends AdminController
{
	public function index()
	{

		$data["page"] = "Account Maintenance";
		
		if(isset($_POST['login']))
		{
			$login = Tbl_account::where('account_id',Request::input('login'))->first();

			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." login the account #".$login->account_id);

			Customer::login($login->account_id,$login->account_password);	
			return Redirect::to('/member');		
		}
		else
		{
			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits Account Maintenance");
		}


        return view('admin.maintenance.account', $data);
	}
	
    public function data()
    {


		$admin_rank = Admin::info()->admin_position_rank;
    	$account = Tbl_account::select('tbl_account.*','tbl_admin_position.admin_position_rank','tbl_country.country_name')->where('tbl_account.archived', Request::input('archived'))
    										->where('tbl_admin_position.admin_position_rank', '>=',$admin_rank)
    										->OrWhereNull('tbl_admin_position.admin_position_rank')
    										->position()
    										->country()
    										->where('tbl_account.archived',Request::input('archived'))
    										->get();

        // $account = Tbl_account::select('*')->where('tbl_account.archived', Request::input('archived'))->leftJoin("tbl_country","tbl_account.account_country_id", "=", "tbl_country.country_id");
        $text = Request::input('archived') ? 'RESTORE' : 'ARCHIVE';
		$class = Request::input('archived') ? 'restore-account' : 'archive-account';
        return Datatables::of($account)	->addColumn('edit','<a href="admin/maintenance/accounts/edit?id={{$account_id}}">EDIT</a>')
        								->addColumn('archive','<a class="'.$class.'" href="#" account-id="{{$account_id}}">'.$text.'</a>')
        								->addColumn('login','<button name="login" type="submit" value="{{$account_id}}" class="form-control">Login</button>')
        								->make(true);


    }

    
	public function add()
	{
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits Add Account Maintenance");
		if(Request::isMethod("post"))
		{

			$request['account_name'] = Request::input('account_name');
			$request['account_meail'] =Request::input('account_meail');
			$request['account_contact'] =Request::input('account_contact');
			$request['country'] =Request::input('country');
			$request['account_username'] =Request::input('account_username');
			$request['account_password'] =Request::input('account_password');

			$rules['account_name'] = 'required';
			$rules['account_meail'] = 'required|unique:tbl_account,account_email|email';
			$rules['account_contact'] = 'required|numeric|min:5';
			$rules['country'] = 'required|exists:tbl_country,country_id';
			$rules['account_username'] = 'required|unique:tbl_account,account_username';
			$rules['account_password'] = 'required|min:6';
			/**
			 * VALIDATE CUSTOM FIELD
			 */
			if(Request::input('custom_field'))
			{
				foreach (Request::input('custom_field') as $key => $value)
				{
					$custom_field = Tbl_account_field::where('account_field_label', $key)->first();
					if($custom_field)
					{
						if($custom_field->account_field_required == 1 )
						{	
							$request['custom_field['.$key.']'] = $value;
							$rules['custom_field['.$key.']'] = 'required';
						}
						
					}
					
				}
			}
			// Request::input('custom_field')
			// dd(Request::input(),$rules, Request::input('custom_field')['test_field_1']);

			$validator = Validator::make($request, $rules);

	        if ($validator->fails())
	        {
	            return redirect('admin/maintenance/accounts/add')
	                        ->withErrors($validator)
	                        ->withInput(Request::input());
	        }

			$insert["account_name"] = Request::input('account_name');
			$insert["account_email"] = Request::input('account_meail');
			$insert["account_contact_number"] = Request::input('account_contact');
			$insert["account_country_id"] = Request::input('country');
			$insert["account_username"] = Request::input('account_username');
			$insert["account_password"] = Crypt::encrypt(Request::input('account_password'));
			$insert["account_date_created"] = Carbon\Carbon::now();
			$insert["custom_field_value"] = serialize(Request::input('custom_field'));
			DB::table("tbl_account")->insert($insert);
			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." add new account (".Request::input('account_username').")",null,serialize($request));
			return Redirect::to('admin/maintenance/accounts');
		}
		else
		{
			$data["_account_field"] = DB::table("tbl_account_field")->get();
			$data["_country"] = DB::table("tbl_country")->where("archived", 0)->get();
			return view('admin.maintenance.account_add', $data);
		}
	}
	public function edit()
	{

		if(Request::isMethod("post"))
		{

			// 
			Tbl_account::findOrFail(Request::input('id'));

			$request['account_name'] = Request::input('account_name');
			$request['account_meail'] =Request::input('account_meail');
			$request['account_contact'] =Request::input('account_contact');
			$request['country'] =Request::input('country');
			$request['account_username'] =Request::input('account_username');
			$request['account_password'] =Request::input('account_password');

			$rules['account_name'] = 'required';
			$rules['account_meail'] = 'required|email|unique:tbl_account,account_email,'.Request::input('id').',account_id';
			$rules['account_contact'] = 'required|numeric|min:5';
			$rules['country'] = 'required|exists:tbl_country,country_id';
			$rules['account_username'] = 'required|unique:tbl_account,account_username,'.Request::input('id').',account_id';
			$rules['account_password'] = 'required|min:6';


			/**
			 * VALIDATE CUSTOM FIELD
			 */
			if(Request::input('custom_field'))
			{
				foreach (Request::input('custom_field') as $key => $value)
				{
					$custom_field = Tbl_account_field::where('account_field_label', $key)->first();
					if($custom_field)
					{
						if($custom_field->account_field_required == 1 )
						{	
							$request['custom_field['.$key.']'] = $value;
							$rules['custom_field['.$key.']'] = 'required';
						}
						
					}
					
				}
			}

			

			$validator = Validator::make($request, $rules);

	        if ($validator->fails())
	        {
	            return redirect('admin/maintenance/accounts/edit?id='.Request::input('id'))
	                        ->withErrors($validator)
	                        ->withInput(Request::input());
	        }
	        $old = DB::table("tbl_account")->where("account_id", Request::input("id"))->first();
			$update["account_name"] 		  = Request::input('account_name');
			$update["account_email"]		  = Request::input('account_meail');
			$update["account_username"] 	  = Request::input('account_username');
			$update["account_password"]       = Crypt::encrypt(Request::input('account_password'));
			$update["account_contact_number"] = Request::input('account_contact');
			$update["account_country_id"]     = Request::input('country');
	        $update["disable_product"] 	      = Request::input('disable_product') ? 1 : 0 ;
	        $update["disable_membership"]     = Request::input('disable_membership') ? 1 : 0 ;
			// $update["account_date_created"] = Carbon\Carbon::now();
			$update["custom_field_value"] = serialize(Request::input('custom_field'));
			DB::table("tbl_account")->where("account_id", Request::input("id"))->update($update);
			$new = DB::table("tbl_account")->where("account_id", Request::input("id"))->first();
			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." edit the account #".Request::input('id'),serialize($old),serialize($new));

			return Redirect::to('admin/maintenance/accounts');
		}
		else
		{
			$data["_account_field"] = DB::table("tbl_account_field")->get();
			$data["_country"] = DB::table("tbl_country")->where("archived", 0)->get();
			$data["account"] = DB::table("tbl_account")->where("account_id", Request::input("id"))->first();

			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits Edit Account Maintenance Slot #".Request::input('id'));
			// $data["_account_custom"] = unserialize($data["account"]->custom_field_value);
			// dd($data["_account_custom"]);
			return view('admin.maintenance.account_edit', $data);
		}
	}
	public function field()
	{
		$data["_account_field"] = DB::table("tbl_account_field")->get();

		if(Request::isMethod("post"))
		{
			$insert["account_field_label"] = Request::input("label");
			$insert["account_field_type"] = Request::input("field-type");

			if(Request::input("required") == "on")
			{
				$insert["account_field_required"] = 1;
			}
			else
			{
				$insert["account_field_required"] = 0;
			}

			DB::table("tbl_account_field")->insert($insert);
			return Redirect::back();
		}
		else
		{
			return view('admin.maintenance.account_field', $data);	
		}
	}
	
	public function field_delete()
	{
		DB::table("tbl_account_field")->where("account_field_id", Request::input("id"))->delete();
		return Redirect::back();
	}


	public function archive_account()
	{	

		$id = Request::input('id');
		$data['query'] = Tbl_account::where('account_id',$id)->update(['archived'=>'1']);
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." archive the account #".Request::input('id'));
		return json_encode($data);
	}

	public function restore_account()
	{	

		$id = Request::input('id');
		$data['query'] = Tbl_account::where('account_id',$id)->update(['archived'=>'0']);
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." restore the account #".Request::input('id'));
		return json_encode($data);
	}
}