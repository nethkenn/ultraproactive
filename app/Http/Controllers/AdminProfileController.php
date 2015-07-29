<?php namespace App\Http\Controllers;
use Redirect;
use App\Classes\Admin;
use DB;
use Request;
use Hash;
use Validator;

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
		Admin::logout();
		return Redirect::to("admin/login");
	}
}