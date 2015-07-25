<?php namespace App\Http\Controllers;
use Redirect;
use App\Classes\Admin;
use DB;
use Request;
use Hash;
use Validator;
use Crypt;
class AdminAccountSettingsController extends AdminController
{
	public function settings()
	{
		$data['error_message'] = null;
		$data['info'] = Admin::info();

		 if(isset($_POST["name"]))
         {

					DB:: table ('tbl_account') -> where('account_id','=',$data['info']->account_id) 
                                		       -> update(['account_name'=> $_POST['name']]);

        			return Redirect::to("admin/account/settings/profile"); 



 
         }
		return view('admin.adminsettings.admin_profile',$data);
	}
	public function changepass()
	{
		$data['mismatch'] =  "";
		$data['oldpass'] =  "";
		$data['success'] =  "";

		 if(isset($_POST["admin_current_password"]))
         {	
         	$check_pass = Request::input("admin_current_password");
         	$new_pass = Request::input("admin_new_password");
         	$rnew_pass = Request::input("admin_new_passwordrepeat");
         	$data['info'] = Admin::info();
			$admin_id = $data['info']->account_id;
			$password = $data['info']->account_password;
			$password = Crypt::decrypt($password);
			$password_hashed = $new_pass;

			if ($check_pass == $password)
			{
				if($new_pass == $rnew_pass)
				{
					$password_hashed = Crypt::encrypt($password_hashed);
					DB:: table ('tbl_account') -> where('account_id','=',$data['info']->account_id) 
                                  			 -> update(['account_password'=> $password_hashed]);                  			 
         			$data['success'] =  "Password successfully changed";   
				}
				else
				{
					$data['mismatch'] =  "Password Mismatch";
				}
			}
			else
			{
				$data['oldpass'] =  "Old Password is incorrect";
			}
		 }
		return view('admin.adminsettings.admin_change_pass',$data);
	}
	public function logout()
	{
		Admin::logout();
		return Redirect::to("admin/login");
	}
}