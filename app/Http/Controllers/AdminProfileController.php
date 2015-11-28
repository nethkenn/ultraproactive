<?php namespace App\Http\Controllers;
use Redirect;
use App\Classes\Admin;
use DB;
use Request;
use Hash;
use Validator;
use App\Classes\Log;
class AdminProfileController extends AdminController
{

	public function settings()
	{

	}
	public function changepass()
	{
	}
	public function logout()
	{
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." Logged out");
		Admin::logout();
		return Redirect::to("");
	}
}