<?php namespace App\Http\Controllers;
use DB;
use Request;
use Redirect;
use Carbon;
use Datatables;
use App\Tbl_account;

class AdminAccountController extends AdminController
{
	public function index()
	{
		$data["page"] = "Account Maintenance";
        return view('admin.maintenance.account', $data);
	}
	
    public function data()
    {
        $account = Tbl_account::select('*')->leftJoin("tbl_country","tbl_account.account_country_id", "=", "tbl_country.country_id");
        return Datatables::of($account)	->addColumn('edit','<a href="admin/maintenance/accounts/edit?id={{$account_id}}">EDIT</a>')
        								->addColumn('archive','<a href="admin/maintenance/accounts/archive?id={{$account_id}}">ARCHIVE</a>')
        								->make(true);
    }
	public function add()
	{
		if(Request::isMethod("post"))
		{
			$insert["account_name"] = Request::input('account_name');
			$insert["account_email"] = Request::input('account_meail');
			$insert["account_contact_number"] = Request::input('account_contact');
			$insert["account_country_id"] = Request::input('country');
			$insert["account_date_created"] = Carbon\Carbon::now();
			$insert["custom_field_value"] = serialize(Request::input('custom_field'));
			DB::table("tbl_account")->insert($insert);
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
			$update["account_name"] = Request::input('account_name');
			$update["account_email"] = Request::input('account_meail');
			$update["account_contact_number"] = Request::input('account_contact');
			$update["account_country_id"] = Request::input('country');
			$update["account_date_created"] = Carbon\Carbon::now();
			$update["custom_field_value"] = serialize(Request::input('custom_field'));
			DB::table("tbl_account")->where("account_id", Request::input("id"))->update($update);
			return Redirect::to('admin/maintenance/accounts');
		}
		else
		{
			$data["_account_field"] = DB::table("tbl_account_field")->get();
			$data["_country"] = DB::table("tbl_country")->where("archived", 0)->get();
			$data["account"] = DB::table("tbl_account")->where("account_id", Request::input("id"))->first();
			$data["_account_custom"] = unserialize($data["account"]->custom_field_value);
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
}