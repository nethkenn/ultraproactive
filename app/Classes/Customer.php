<?php namespace App\Classes;
use DB;
use Crypt;
use Session;
use App\Classes\Image;
use App\Classes\Globals;
use Redirect;
class Customer
{
	public static $table = 'tbl_account';
	public static $primary = 'account_id';
    public static $secondary = 'account_password';

	/* CHECK IF ACCOUNT EXIST */
    public static function authenticate($user, $password)
    {
		$user = DB::table(Customer::$table)->where("account_username", $user)->where('archived',0)->first();

		if($user)
		{ 
			$member_password = Crypt::decrypt($user->account_password);

			if($password == $member_password)
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
    public static function login($member_id,$member_password)
    {
        $data = DB::table('tbl_slot')->where('slot_owner',$member_id)->get();
    	$member_id = Crypt::encrypt($member_id);
    	Session::put(Customer::$primary, $member_id);
        Session::put(Customer::$secondary, $member_password);
        if($data)
        {
            Session::put("currentslot", $data[0]->slot_id);
        }
    }

    /* SET LOGOUT */
    public static function logout()
    {
    	Session::forget(Customer::$primary);
        Session::forget(Customer::$secondary);
        Session::forget('currentslot');
    }

    /* GET INFORMATION OF LOGGED IN USER */
    public static function info()
    {
    	$member_id = Customer::id();
    	if($member_id)
    	{
    		$return = DB::table(Customer::$table)->where(Customer::$primary, $member_id)->first();
    		// if($return)
      //       {
      //           $return->img_src = $return->member_image == 'default.jpg' ? '/resources/assets/img/1428733091.jpg' : Image::view($return->member_image);
      //       }
            
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
    	if(Session::has(Customer::$primary))
    	{
            $user_id  = Crypt::decrypt(Session::get(Customer::$primary));
            $pass     = Crypt::decrypt(Session::get(Customer::$secondary));
            $userpass = DB::table('tbl_account')->where('account_id',$user_id)->first();

            if($userpass == null)
            {
                Session::forget(Customer::$primary);
                Session::forget(Customer::$secondary);
                Session::forget('currentslot');  
                return Redirect::to('member/login');          
            }


            $userpass = Crypt::decrypt($userpass->account_password);

  

            if($userpass == $pass)
            {             
               return Crypt::decrypt(Session::get(Customer::$primary));
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

    public static function slot_id()
    {
        return Session::get("currentslot");
    }
    // public static function customer_viewed_product($prod_id, $cust_id)
    // {


    //         $exist = DB::table('tbl_customer_viewed_product')   ->where('product_id',$prod_id)
    //                                                             ->where('customer_id',$cust_id)
    //                                                             ->first();

    //         $insert['product_id'] = $update['product_id'] = $prod_id;
    //         $insert['customer_id'] = $update['customer_id'] = $cust_id;
    //         $insert['updated_at'] = $update['updated_at'] = Globals::get_time();
    //         if(!$exist)
    //         {

    //             $query = DB::table('tbl_customer_viewed_product')   ->insert($insert);
    //         }
    //         else
    //         {   
    //             $query = DB::table('tbl_customer_viewed_product')   ->where('product_id',$prod_id)
    //                                                                 ->where('customer_id',$cust_id)
    //                                                                 ->update($update);
    //         }


    //         return $query;
        
    // }


    // public static function get_viewed_product()
    // {
    //     $_viewed_product = DB::table('tbl_customer_viewed_product') ->leftJoin('tbl_product', 'tbl_product.product_id','=','tbl_customer_viewed_product.product_id')
    //                                                         ->where('tbl_customer_viewed_product.customer_id','=',Customer::id())
    //                                                         ->get();
    //     if($_viewed_product)
    //     {
    //         foreach ($_viewed_product as $key => $viewed_product)
    //         {
    //            $_product[$key] = $viewed_product;
    //            $_product[$key]->img_src = $viewed_product->product_main_image == 'default.jpg' ? '\resources\assets\img\1428733091.jpg' : Image::view($viewed_product->product_main_image);
    //            // $_product[$key]->img_link 
    //         }

    //         return $_product;
    //     }
    //     else
    //     {
    //         return $_viewed_product;
    //     }

       


    // }




}
