<?php namespace App\Http\Controllers;
use DB;
use Redirect;
use Request;
use Settings;

class AdminSettingsController extends AdminController
{
	public function index()
	{
		if(Request::isMethod("post"))
		{
			$_settings = Request::input();

			$ctr = 0;
			foreach($_settings as $key => $setting)
			{
				$insert[$ctr]["key"] = $key;
				$insert[$ctr]["value"] = $setting;
				$ctr++;
			}

			DB::table("tbl_settings")->delete();
			DB::table("tbl_settings")->insert($insert);
			return Redirect::to("admin/utilities/setting");
		}
		else
		{
			$data["page"] = "Company Profile";
			$_settings = DB::table("tbl_settings")->get();
			
			$set = new \stdClass();
			foreach($_settings as $setting)
			{
				$key = $setting->key;
				$value = $setting->value;

				if($key == "logo")
				{
					$set->logo_image = Image::view($value, '250x250');
				}
				
				$set->$key = $value;
			}

			$data["settings"] = $set;
			return view('admin.utilities.settings', $data);	
		}
	}
	public function submit()
	{
		//GET QUERY
		$name = Request::input("name");
		$email = Request::input("email");
		$mobile = Request::input("mobile");
		$telephone = Request::input("telephone");
		$address = Request::input("address");

		//SUBMIT QUERY
		DB::table("tbl_settings")->where("key", "company_name")->update(['value' => $name]);
		DB::table("tbl_settings")->where("key", "company_email")->update(['value' => $email]);
		DB::table("tbl_settings")->where("key", "company_mobile")->update(['value' => $mobile]);
		DB::table("tbl_settings")->where("key", "company_telephone")->update(['value' => $telephone]);
		DB::table("tbl_settings")->where("key", "company_address")->update(['value' => $address]);

        return Redirect::to("/admin/utilities/setting");
	}
}