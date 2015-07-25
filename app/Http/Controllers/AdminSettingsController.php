<?php namespace App\Http\Controllers;
use DB;
use Redirect;
use Request;

class AdminSettingsController extends AdminController
{
	public function index()
	{
		$data["company"] = DB::table("tbl_company")->first();

        return view('admin.utilities.settings', $data);
	}
	public function submit()
	{
		$name = Request::input("name");
		$email = Request::input("email");
		$mobile = Request::input("mobile");
		$telephone = Request::input("telephone");
		$address = Request::input("address");

		DB::table("tbl_company")->update(['company_name' => $name, 'company_email' => $email, 'company_mobile' => $mobile, 'company_telephone' => $telephone, 'company_address' => $address]);

        return Redirect::to("/admin/utilities/setting");
	}
}