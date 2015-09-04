<?php namespace App\Classes;
use DB;
use Crypt;
use Session;
use App\Classes\Image;
use App\Classes\Globals;
use Hash;
use App\Tbl_stockist_user;


class Stockist
{
	public static $table = 'tbl_stockist_user';
	public static $primary = 'stockist_user_id';

	/* CHECK IF ACCOUNT EXIST */
    public static function authenticate($username, $password)
    {


        // var_dump(Crypt::decrypt('eyJpdiI6IkJpMFE0ejVUNGhacVRoNDMzOWxBTHc9PSIsInZhbHVlIjoiR25YazdybnJzTlYrZWNtYVpxMTVIQ3MwQm50Wkx2bkNLdGJvUExSbENPTT0iLCJtYWMiOiJjMmZlMjNiNDliZWIwNDhiNjZmZDI3NmY5ZWVmMDU4ZTg4ZDcyODQwYThmMGJmZTA1ZTU1NDJmNjFiNTRkNWE0In0='));
        // var_dump(Session::get('admin'));
        
        $user = Tbl_stockist_user::where('tbl_stockist_user.stockist_un', $username)->where('archive',0)->first();

        if($user)
        {
            $decrypted_pass =  Crypt::decrypt($user->stockist_pw);
            if($decrypted_pass == $password)
            {
                return $user;
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
        Session::forget('user');
        Session::put('user', ['user'=>$username, 'password'=>$password]);
    }

    /* SET LOGOUT */
    public static function logout()
    {
    	Session::forget('user');
    }





    /* GET INFORMATION OF LOGGED IN USER */
    public static function info()
    {
        $user = Session::get('user');
        return Stockist::authenticate($user['user'], $user['password']);
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
