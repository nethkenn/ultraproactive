<?php namespace App\Http\Controllers;
use Session;
use Request;
use App\Tbl_product;
use App\Classes\Product;
use App\Tbl_slot;
use App\Classes\Customer;
use App\Tbl_product_discount;
class CartController extends MemberController
{
	public function index()
	{	
		$data['_cart'] = Session::get('cart');
		$final_total = [];
		$slot_id = Session::get('currentslot');
		$customer = Customer::info();
		$slot = Tbl_slot::select('tbl_slot.*', 'tbl_membership.discount')->leftJoin('tbl_membership', 'tbl_membership.membership_id','=','tbl_slot.slot_membership')
                                                                        ->where('slot_id', $slot_id)
                                                                        ->where('slot_owner', $customer->account_id)
                       	                                                 ->first();
        $reduced_amount[] = [0];
        // dd($slot->discount);     	                                                 
		if($data['_cart'])
		{
			foreach ($data['_cart'] as $key => $value)
			{

				// $data['_cart'][$key]['price'] = Product::currency_format($value['price']); 
				// $data['_cart'][$key]['total'] = Product::currency_format($value['total']); 

				$data['_cart'][$key]['price'] = $value['price']; 
				$discount = Tbl_product_discount::where('product_id',$key)->where('membership_id',$slot->slot_membership)->first();

				if($discount)
				{
					$discount = $discount->discount;
				}
				else
				{
					$discount = 0;
				}
				$data['_cart'][$key]['discount'] = $discount;
				$data['_cart'][$key]['total'] = $value['total'] - (($discount/100)*$value['total']);
				$final_total[] = $value['total'];
				$reduced_amount[] = ($discount/100)*$value['total'];
			}
		}

		// $data['final_total'] =  Product::currency_format(array_sum($final_total));
		$discount= $slot->discount;
		$product_sum_total = array_sum($final_total);

		
		$discount_in_decimal = array_sum($reduced_amount);
		$final_total = $product_sum_total - $discount_in_decimal;
		$data['sum_product'] = $this->return_format_num($product_sum_total);
		$data['discount'] =    $this->return_format_num($discount_in_decimal);
		$data['final_total'] = $this->return_format_num($final_total);

		

		return view('cart.cart', $data);
	}


	public function return_format_num($val)
	{
		return number_format($val, 2, '.',',');
	}

	public function remove_to_cart()
	{
		$data['success'] = false;
		$prod_id = Request::input('product_id');
		$product = Tbl_product::find(Request::input('product_id'));

		if($product)
		{
			$_cart = Session::get('cart');
			unset($_cart[$prod_id]);
			Session::put('cart', $_cart);

			$data['success'] = true;

		}

		return $data;
	}

	public function add_to_cart()
	{

		$data['success'] = false;
		$prod_id = Request::input('product_id');
		$slot_id = Request::input('slot_id');

		$product = Tbl_product::find(Request::input('product_id'));

		if($product)
		{
			$_cart = Session::get('cart');

			if($this->check_in_array($prod_id, $_cart ))
			{
				$_cart[$prod_id]['qty'] = $_cart[$prod_id]['qty'] + 1;
				$_cart[$prod_id]['total'] = $_cart[$prod_id]['qty'] *  $_cart[$prod_id]['price'];
			}
			else
			{


				$_cart[$product->product_id]['product_name'] =  $product->product_name;
				$_cart[$product->product_id]['price'] =  $product->price;
				$_cart[$product->product_id]['qty'] = 1;
				// $_cart[$product->product_id]['discount'] = ;
				$_cart[$product->product_id]['total'] = $product->price * $_cart[$product->product_id]['qty'];	
				
			}
			Session::put('cart', $_cart);

			$data['success'] = true;

		}

		return $data;
	}


	public function check_in_array($needle, $haystack)
	{	
		foreach ( (array)$haystack as $key => $value)
		{
			if($key==$needle)
			{
				return true;
			}
		}
		return false;
	}






}