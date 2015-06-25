<?php namespace App\Classes;
use DB;
use Crypt;
use Session;
use App\Classes\Image;
use App\Classes\Globals;

class Customer
{
	public static $table = 'tbl_customer';
	public static $primary = 'customer_id';

	/* CHECK IF ACCOUNT EXIST */
    public static function authenticate($email, $password)
    {
		$email = DB::table(Customer::$table)->where("customer_email", $email)->first();

		if($email)
		{
			$customer_password = Crypt::decrypt($email->customer_password);

			if($password == $customer_password)
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
    	Session::put(Customer::$primary, $customer_id);
    }

    /* SET LOGOUT */
    public static function logout()
    {
    	Session::forget(Customer::$primary);
    }

    /* GET INFORMATION OF LOGGED IN USER */
    public static function info()
    {
    	$customer_id = Customer::id();
    	if($customer_id)
    	{
    		$return = DB::table(Customer::$table)->where(Customer::$primary, $customer_id)->first();
    		if($return)
            {
                $return->img_src = $return->customer_image == 'default.jpg' ? '/resources/assets/img/1428733091.jpg' : Image::view($return->customer_image);
            }
            
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
    		return Crypt::decrypt(Session::get(Customer::$primary));
    	}
    	else
    	{
    		return false;
    	}
    }


    public static function customer_viewed_product($prod_id, $cust_id)
    {


            $exist = DB::table('tbl_customer_viewed_product')   ->where('product_id',$prod_id)
                                                                ->where('customer_id',$cust_id)
                                                                ->first();

            $insert['product_id'] = $update['product_id'] = $prod_id;
            $insert['customer_id'] = $update['customer_id'] = $cust_id;
            $insert['updated_at'] = $update['updated_at'] = Globals::get_time();
            if(!$exist)
            {

                $query = DB::table('tbl_customer_viewed_product')   ->insert($insert);
            }
            else
            {   
                $query = DB::table('tbl_customer_viewed_product')   ->where('product_id',$prod_id)
                                                                    ->where('customer_id',$cust_id)
                                                                    ->update($update);
            }


            return $query;
        
    }


    public static function get_viewed_product()
    {
        $_viewed_product = DB::table('tbl_customer_viewed_product') ->leftJoin('tbl_product', 'tbl_product.product_id','=','tbl_customer_viewed_product.product_id')
                                                            ->where('tbl_customer_viewed_product.customer_id','=',Customer::id())
                                                            ->get();
        if($_viewed_product)
        {
            foreach ($_viewed_product as $key => $viewed_product)
            {
               $_product[$key] = $viewed_product;
               $_product[$key]->img_src = $viewed_product->product_main_image == 'default.jpg' ? '\resources\assets\img\1428733091.jpg' : Image::view($viewed_product->product_main_image);
               // $_product[$key]->img_link 
            }

            return $_product;
        }
        else
        {
            return $_viewed_product;
        }

       


    }




}
