<?php namespace App\Http\Controllers;
use Redirect;
use App\Classes\Stockist;
use DB;
use Request;
use Hash;
use Validator;
use Crypt;
class StockistAccountSettingsController extends StockistController
{
	// public function settings()
	// {
	// 	$data['error_message'] = null;
	// 	$data['info'] = Stockist::stockist();

	// 	 if(isset($_POST["name"]))
 //         {

	// 				DB:: table ('tbl_account') -> where('account_id','=',$data['info']->account_id) 
 //                                		       -> update(['account_name'=> $_POST['name']]);

 //        			return Redirect::to("admin/account/settings/profile"); 



 
 //         }
	// 	return view('stockist.account.profile',$data);
	// }
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
         	$data['info'] = Stockist::info();
			$admin_id = $data['info']->stockist_user_id;
			$password = $data['info']->stockist_pw;
			$password = Crypt::decrypt($password);
			$password_hashed = $new_pass;

			if ($check_pass == $password)
			{
				if($new_pass == $rnew_pass)
				{
					$password_hashed = Crypt::encrypt($password_hashed);
					DB:: table ('tbl_stockist_user') -> where('stockist_user_id','=',$data['info']->stockist_user_id) 
                                  			 -> update(['stockist_pw'=> $password_hashed]);                  			 
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
		return view('stockist.account.settings',$data);
	}
	// public function logout()
	// {
	// 	Admin::logout();
	// 	return Redirect::to("admin/login");
	// }
}