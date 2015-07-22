<?php namespace App\Http\Controllers;
use App\Tbl_voucher;
use App\Tbl_slot;
use App\Tbl_voucher_has_product;
use App\Tbl_product;
use Datatables;
use Request;
use Validator;
use app\Classes\Admin;
use Crypt;
class AdminClaimController extends AdminController
{
	public function index()
	{
        return view('admin.transaction.claim');
	}


	public function data()
	{


		$voucher = Tbl_voucher::all();

		return Datatables::of($voucher)	->editColumn('status','{{$status}}')
										->addColumn('cancel_or_view_voucher','<a style="cursor: pointer;" class="view-voucher" voucher-id="{{$voucher_id}}">View Voucher</a>')
			                            ->make(true);
	}

	public function check()
	{
		$data['_message'] = null;
		$data['voucher'] = null;
		$data['_voucher_product'] = null; 

		if(isset($_POST['voucher_id']))
		{
			
			$admin_pass = Crypt::decrypt(Admin::info()->account_password);




	        Validator::extend('foo', function($attribute, $value, $parameters)
            {

            	return $value == $parameters[0];

            });
	        $rules['account_password'] = 'required|foo:'.$admin_pass;
	        $rules['voucher_code'] = 'required|exists:tbl_voucher,voucher_code,voucher_id,'.Request::input('voucher_id');
	        $rules['voucher_id'] =  'required|exists:tbl_voucher,voucher_id,voucher_code,'.Request::input('voucher_code');
	        $messages = [

	        				'account_password.foo'=>'The :attribute is invalid.',
	        			];
			$validator = Validator::make(Request::input(),$rules, $messages);

			if($validator->fails())
			{
				$messages = $validator->messages();
				$data['_message']['account_password'] = $messages->get('account_password');
				$data['_message']['voucher_id'] = $messages->get('voucher_id');
				$data['_message']['voucher_code'] = $messages->get('voucher_code');


			}
			else
			{
				$voucher_id = Request::input('voucher_id');
				$data['voucher'] = 	Tbl_voucher::find($voucher_id);
				$data['_voucher_product']  = Tbl_voucher_has_product::where('voucher_id', $voucher_id)->product()->get();

				
			}



			

		}



		return view('admin.transaction.claim_check', $data);
	}




	public function claim()
	{

		$data['_error'] = null;
		$data['query'] = 0;
		$current_admin_pass = Crypt::decrypt(Admin::info()->account_password);


		$voucher_id = Request::input('voucher_id');
		$voucher = Tbl_voucher::find($voucher_id);
		$voucher_slot = Tbl_slot::find($voucher->slot_id); 
		$request['slot_wallet'] = $voucher_slot->slot_wallet;
		$rules['slot_wallet'] = 'check_wallet:'.$voucher->total_amount;
		// dd($request, $rules);
		$request['account_password'] = Request::input('account_password');
		$rules['account_password'] = 'required|check_pass:'.$current_admin_pass;

		$request['voucher_id'] = $voucher_id;
		$rules['voucher_id'] = 'required|exists:tbl_voucher,voucher_id,status,unclaimed';

		$_voucher_product = Tbl_voucher_has_product::where('voucher_id', $voucher_id)->product()->get(); 
		$request['product_count'] = count($_voucher_product);
		$rules['product_count'] = 'prod_count';


	    if($_voucher_product)
	    {

	    	/**
		    * VALIDATOR REQUEST PRODUCT VOUCHER
		    */

	        foreach($_voucher_product as $key => $val)
	        {
	            $request['product_'.$val->product_id] = $val->qty;
	        }

	        /**
	        * VALIDATOR RULES PRODUCT VOUCHER
	        */
	        foreach( $_voucher_product as $key => $val)
	        {
	        	$rules['product_'.$val->product_id] = 'integer|has_stock:'.$val->stock_qty;
	        }

	        foreach( $_voucher_product as $key => $val)
	        {
	        	$messages['product_'.$val->product_id.'.has_stock'] = 'The :attribute has unsufficient stock.';
	        }
	    }
	    $messages['voucher_id.exists'] = "The selected vouher might have been already processed or cancelled.";
	    $messages['product_count.prod_count'] = "Voucher's product is empty.";
	    $messages['account_password.check_pass'] = "Invalid Password.";
	    $messages['slot_wallet.check_wallet'] = "Slot wallet balance is not enough.";
	   	Validator::extend('check_wallet', function($attribute, $value, $parameters)
        {
        	$slot_wallet = $value;
        	$voucher_total = $parameters[0];
        	$deducted = $slot_wallet - $voucher_total;

        	if($slot_wallet < $voucher_total || $deducted < 0)
        	{
        		return false;
        	}
        	else
        	{
        		return true;
        	}

        });

	    Validator::extend('check_pass', function($attribute, $value, $parameters)
        {
    		return $value == $parameters[0];
        });

        Validator::extend('has_stock', function($attribute, $value, $parameters)
        {
    
            $stock_qty = $parameters[0];
            $voucher_qty = $value;
            $stock_minus_voucher_qty = $stock_qty - $voucher_qty;
            if($stock_qty < $voucher_qty || $stock_minus_voucher_qty < 0)
            {
               
                return false;

            }
            else
            {
                return $value;
            }
        });


        Validator::extend('prod_count', function($attribute, $value, $parameters)
        {
        	return $value > 0; 
        });




		$validator = Validator::make($request , $rules ,$messages);



		if($validator->fails())
		{
			$data['_error'] = $validator->messages()->all();
		}
		else
		{
			Tbl_voucher::where('voucher_id', $voucher_id)->lockForUpdate()->update(['status'=>'processed']);

			$updated_wallet = $voucher_slot->slot_wallet - $voucher->total_amount;
			Tbl_slot::where('slot_id', $voucher->slot_id)->lockForUpdate()->update(['slot_wallet'=>$updated_wallet]);

			if($_voucher_product)
			{
				foreach ($_voucher_product as $key => $value)
				{
					$stock_minus_voucher_qty = $value->stock_qty - $value->qty;
					Tbl_product::where('product_id', $value->product_id)->lockForUpdate()->update(['stock_qty'=>$stock_minus_voucher_qty]);
				}
			}
		}

		return $data;
	}



	public function void()
	{
		// return Request::input();
		$data['_error'] = null;
		$current_admin_pass = Crypt::decrypt(Admin::info()->account_password);


		$rules['voucher_id'] = 'required|exists:tbl_voucher,voucher_id,status,unclaimed,status,processed';
		$rules['account_password'] = 'required|check_pass:'.$current_admin_pass;

		$messages['account_password.check_pass'] = "Invalid Password.";
		$messages['voucher_id.exists'] = "The selected vouher might have been already processed or cancelled.";

		Validator::extend('check_pass', function($attribute, $value, $parameters)
        {
    		return $value == $parameters[0];
        });

		$validator = Validator::make(Request::input() , $rules ,$messages);
		


		if($validator->fails())
		{
			$data['_error'] = $validator->messages()->all();
		}
		else
		{	


			$voucher_product = Tbl_voucher_has_product::where('voucher_id', Request::input('voucher_id'))->get()->toArray();





			Tbl_voucher::where('voucher_id', Request::input('voucher_id'))->lockForUpdate()->update(['status'=>'cancelled']);
			$voucher = Tbl_voucher::find(Request::input('voucher_id'));
			if($voucher->status="processed")
			{
				foreach ($voucher_product as $key => $product)
				{
					$current_product = Tbl_product::find($product['product_id']);

					$updated_stock = $current_product->stock_qty + $product['qty'];
					Tbl_product::where('product_id',$product['product_id'])->lockForUpdate()->update(['stock_qty'=> $updated_stock] );
				}
			}

		}

		return $data;
	}


	public function show_product()
	{
				$voucher_id = Request::input('voucher_id');
				$data['voucher'] = 	Tbl_voucher::find($voucher_id);
				$data['_voucher_product']  = Tbl_voucher_has_product::where('voucher_id', $voucher_id)->product()->get();
	
				return view('admin.transaction.claim_voucher_product', $data);
	}




}


