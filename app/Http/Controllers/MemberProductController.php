<?php namespace App\Http\Controllers;
use Session;
use Request;
use App\Tbl_product;
use App\Classes\Product;
use DB;
class MemberProductController extends MemberController
{
	public function index()
	{	

		$data['_product'] = null;
		$_product = Tbl_product::all();

		if($_product)
		{
			foreach ($_product as $key => $value)
			{
				$data['_product'][$key] = $value;
				$data['_product'][$key]->price = Product::currency_format($value->price); 
			}
		}




		// var_dump(Session::all());	
        return view('member.product', $data);
	}

}