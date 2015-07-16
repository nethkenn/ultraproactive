<?php namespace App\Classes;
use DB;
use Crypt;
use Session;
use App\Classes\Image;
use App\Classes\Globals;
use Hash;
use App\Tbl_admin;
use App\Tbl_account;

class Admin
{
	public static $table = 'tbl_admin';
	public static $primary = 'admin_id';

	/* CHECK IF ACCOUNT EXIST */
    public static function authenticate($username, $password)
    {


        // var_dump(Crypt::decrypt('eyJpdiI6IkJpMFE0ejVUNGhacVRoNDMzOWxBTHc9PSIsInZhbHVlIjoiR25YazdybnJzTlYrZWNtYVpxMTVIQ3MwQm50Wkx2bkNLdGJvUExSbENPTT0iLCJtYWMiOiJjMmZlMjNiNDliZWIwNDhiNjZmZDI3NmY5ZWVmMDU4ZTg4ZDcyODQwYThmMGJmZTA1ZTU1NDJmNjFiNTRkNWE0In0='));
  //       var_dump(Session::get('admin'));
        
        $admin = Tbl_admin::leftJoin('tbl_account','tbl_account.account_id', '=', 'tbl_admin.account_id')
                            ->leftJoin('tbl_admin_position','tbl_admin_position.admin_position_id','=','tbl_admin.admin_position_id')
                            ->where('tbl_account.account_username', $username)
                            ->first();

      
        if($admin)
        {
            $decrypted_pass =  Crypt::decrypt($admin->account_password);
            if($decrypted_pass == $password)
            {
                return $admin;
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
    public static function login($username, $password)
    {
    	// $customer_id = Crypt::encrypt($customer_id);
    	// Session::put(Admin::$primary, $customer_id);
        Session::forget('admin');
        Session::put('admin', ['username'=>$username, 'password'=>$password]);






    }

    /* SET LOGOUT */
    public static function logout()
    {
    	Session::forget('admin');
    }





    /* GET INFORMATION OF LOGGED IN USER */
    public static function info()
    {
        $admin = Session::get('admin');

        return Admin::authenticate($admin['username'], $admin['password']);

    }
    
    // /* GET ID OF LOGGED IN USER */
    // public static function id()
    // {
    // 	if(Session::has(Admin::$primary))
    // 	{
    // 		return Crypt::decrypt(Session::get(Admin::$primary));
    // 	}
    // 	else
    // 	{
    // 		return false;
    // 	}
    // }
}
