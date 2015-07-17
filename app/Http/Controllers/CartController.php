<?php namespace App\Http\Controllers;
use Session;
use Request;
use App\Tbl_product;
use App\Classes\Product;

class CartController extends MemberController
{
	public function index()
	{	
		$data['_cart'] = Session::get('cart');
		$final_total = [];

		if($data['_cart'])
		{
			foreach ($data['_cart'] as $key => $value)
			{

				// $data['_cart'][$key]['price'] = Product::currency_format($value['price']); 
				// $data['_cart'][$key]['total'] = Product::currency_format($value['total']); 

				$data['_cart'][$key]['price'] = $value['price']; 
				$data['_cart'][$key]['total'] = $value['total'];

				$final_total[] = $value['total'];
			}
		}

		// $data['final_total'] =  Product::currency_format(array_sum($final_total));
		$data['final_total'] = array_sum($final_total);
		

		return view('cart.cart', $data);
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