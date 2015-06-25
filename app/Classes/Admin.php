<?php namespace App\Classes;
use DB;
use Crypt;
use Session;
use App\Classes\Image;
use App\Classes\Globals;
use Hash;

class Admin
{
	public static $table = 'tbl_admin';
	public static $primary = 'admin_id';

	/* CHECK IF ACCOUNT EXIST */
    public static function authenticate($email, $password)
    {
		$email = DB::table(Admin::$table)->where("admin_username", $email)->first();

		if($email)
		{
			if(Hash::check($password,$email->admin_password))
			{
				return $email;	
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
    }

    /* SET LOGIN */
    public static function login($customer_id)
    {
    	$customer_id = Crypt::encrypt($customer_id);
    	Session::put(Admin::$primary, $customer_id);
    }

    /* SET LOGOUT */
    public static function logout()
    {
    	Session::forget(Admin::$primary);
    }

    /* GET INFORMATION OF LOGGED IN USER */
    public static function info()
    {
    	$customer_id = Admin::id();
    	if($customer_id)
    	{
    		$return = DB::table(Admin::$table)->where(Admin::$primary, $customer_id)->first();
            return $return;
    	}
    	else
    	{
    		return false;
    	}
    }
    
    /* GET ID OF LOGGED IN USER */
    public static function id()
    {
    	if(Session::has(Admin::$primary))
    	{
    		return Crypt::decrypt(Session::get(Admin::$primary));
    	}
    	else
    	{
    		return false;
    	}
    }
}
