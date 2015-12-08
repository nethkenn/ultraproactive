<?php namespace App\Http\Controllers;
use App\Tbl_voucher;
use App\Tbl_slot;
use App\Tbl_voucher_has_product;
use App\Tbl_product;
use App\Tbl_product_code;
use Datatables;
use Request;
use Validator;
use App\Classes\Admin;
use App\Classes\Product;
use App\Classes\Log;
use Crypt;
use Carbon\Carbon;
use DB;
class AdminClaimController extends AdminController
{
	public function index()
	{

		// dd(Admin::info());
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits Voucher Claims.");
        return view('admin.transaction.claim');
	}


	public function data()
	{


		$today = Carbon::now()->toDateString();
		$filter = Request::input('filter');

		$voucher = Tbl_voucher::where(function($query) use($filter, $today)
		{
			switch ($filter)
			{
				case 'today':
					$query->where(DB::raw('DATE(updated_at)'),'=' , $today);
					break;
				
				default:

					$query->whereNotNull('updated_at');
					break;
					
			}
		})->get();

		return Datatables::of($voucher)	->editColumn('status','{{$status}}')
										->addColumn('cancel_or_view_voucher','<a style="cursor: pointer;" class="view-voucher" voucher-id="{{$voucher_id}}">View Voucher</a>')
			                            ->make(true);



	}

	public function check()
	{
		$data['_message'] = null;
		$data['voucher'] = null;
		$data['_voucher_product'] = null; 
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits Check Claims.");
		if(isset($_POST['voucher_id']))
		{
			
			$admin_pass = Crypt::decrypt(Admin::info()->account_password);

			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." check the voucher #".Request::input('voucher_id')." if existing.");


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
				$data['_voucher_product']  = Tbl_voucher_has_product::select('tbl_voucher_has_product.*','tbl_product.stock_qty','tbl_product.product_name')
																	->leftjoin('tbl_product','tbl_product.product_id','=', 'tbl_voucher_has_product.product_id')
																	->where('tbl_voucher_has_product.voucher_id', $voucher_id)
																    ->get();


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
		// if($voucher_slot)
		// {
		// 	$request['slot_wallet'] = $voucher_slot->slot_wallet;
		// 	$rules['slot_wallet'] = 'check_wallet:'.$voucher->total_amount;
		// }
		

		$request['account_password'] = Request::input('account_password');
		$rules['account_password'] = 'required|check_pass:'.$current_admin_pass;

		$request['voucher_id'] = $voucher_id;
		$rules['voucher_id'] = 'required|exists:tbl_voucher,voucher_id,status,unclaimed';

		$_voucher_product = Tbl_voucher_has_product::select('tbl_voucher_has_product.*','tbl_product.stock_qty','tbl_product.product_name')
																	->leftjoin('tbl_product','tbl_product.product_id','=', 'tbl_voucher_has_product.product_id')
																	->where('voucher_id', $voucher_id)
																    ->get();

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
	    // $messages['slot_wallet.check_wallet'] = "Slot wallet balance is not enough.";
	   	// Validator::extend('check_wallet', function($attribute, $value, $parameters)
     //    {
     //    	$slot_wallet = $value;
     //    	$voucher_total = $parameters[0];
     //    	$deducted = $slot_wallet - $voucher_total;

     //    	if($slot_wallet < $voucher_total || $deducted < 0)
     //    	{
     //    		return false;
     //    	}
     //    	else
     //    	{
     //    		return true;
     //    	}

     //    });

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
			
            $update_v['status'] = 'processed';
            $update_v['processed_by'] = Admin::info()->admin_id;
 			$update_v['processed_by_name'] = Admin::info()->account_username ." (" .Admin::info()->admin_position_name. ")";
			Tbl_voucher::where('voucher_id', $voucher_id)->lockForUpdate()->update($update_v);
			if($_voucher_product)
			{


				// dd($_voucher_product->toArray());
				foreach ($_voucher_product as $key => $value)
				{
					$stock_minus_voucher_qty = $value->stock_qty - $value->qty;
					Tbl_product::where('product_id', $value->product_id)->lockForUpdate()->update(['stock_qty'=>$stock_minus_voucher_qty]);
				}
			}



			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." processed the voucher #".Request::input('voucher_id'));
			/**
			 * UPDATE ACCOUNT/ADMIN LOG
			 */
            $log2 = "Processed Voucher # ".Request::input('voucher_id'). " as ".  Admin::info()->admin_position_name.".";
            Log::account(Admin::info()->account_id, $log2);
		}

		return $data;
	}



	public function void()
	{

		$data['_error'] = null;
		$current_admin_pass = Crypt::decrypt(Admin::info()->account_password);


		
		$voucher_query = Tbl_voucher::find(Request::input('voucher_id'));											// dd($_voucher_product);
        $request['voucher_id'] = Request::input('voucher_id');
		$rules['voucher_id'] = 'required|exists:tbl_voucher,voucher_id|voucher_void:'.$voucher_query->status;

		$request['account_password'] = Request::input('account_password');
		$rules['account_password'] = 'required|check_pass:'.$current_admin_pass;

		$messages['account_password.check_pass'] = "Invalid Password.";
		$messages['voucher_id.exists'] = "The selected vouher might have been already processed or cancelled.";
		$messages['voucher_id.voucher_void'] = "The selected voucher was already cancelled.";

		$_voucher_product = Tbl_voucher_has_product::select('tbl_voucher_has_product.*', 'tbl_product_code.used')
													->leftjoin('tbl_product_code', 'tbl_product_code.voucher_item_id', '=','tbl_voucher_has_product.voucher_item_id' )
													->where('tbl_voucher_has_product.voucher_id', Request::input('voucher_id'))
													->get();


		if($_voucher_product)
	    {

	    	/**
		    * VALIDATOR REQUEST PRODUCT VOUCHER
		    */

	        foreach($_voucher_product as $key => $val)
	        {
	            $request['product_'.$val->product_id] = $val->used;
	        }

	        /**
	        * VALIDATOR RULES PRODUCT VOUCHER
	        */
	        foreach( $_voucher_product as $key => $val)
	        {
	        	$rules['product_'.$val->product_id] = 'check_use';
	        }


	        foreach( $_voucher_product as $key => $val)
	        {
	        	$messages['product_'.$val->product_id.'.check_use'] = 'The :attribute was already used.';
	        }
	        
	        
	    }


	    
	    Validator::extend('voucher_void', function($attribute, $value, $parameters)
        {

        	if($parameters[0] == 'cancelled')
        	{
        		return false;
        	}
        	else
        	{	
        		return true;
        	}
        });

	    Validator::extend('check_use', function($attribute, $value, $parameters)
        {
    		return $value == 0;
        });


        Validator::extend('check_pass', function($attribute, $value, $parameters)
        {
    		return $value == $parameters[0];
        });

		$validator = Validator::make($request , $rules ,$messages);
		


		if($validator->fails())
		{
			$data['_error'] = $validator->messages()->all();
		}
		else
		{	

			

			/**
			 * RETURN THE DEDUCTED PTS FROM SLOT WALLET IF VOUCHER IS FROM A MEMBER
			 */

			
			if($voucher_query->slot_id != 0)
			{
				$voucher_slot = Tbl_slot::find($voucher_query->slot_id);
				$updated_wallet = $voucher_slot->slot_wallet + $voucher_query->total_amount;
				// Tbl_slot::where('slot_id', $voucher_slot->slot_id)->lockForUpdate()->update(['slot_wallet'=>$updated_wallet]);
			}
			/**
			 * IF THE VOUCHER STATUS IS "PROCESSED" RETURN THE DEDUCTED INVENTORY
			 */
			$voucher_product = Tbl_voucher_has_product::where('voucher_id', Request::input('voucher_id'))->get()->toArray();
			
			if($voucher_query->status == "processed")
			{

				foreach ($voucher_product as $key => $product)
				{
					$current_product = Tbl_product::find($product['product_id']);
					$updated_stock = $current_product->stock_qty + $product['qty'];
					Tbl_product::where('product_id',$product['product_id'])->lockForUpdate()->update(['stock_qty'=> $updated_stock] );
				}
			}


            /**
			 * CHANGE THE VOUCHER STATUS TO CANCELLED;
			 */

            $update_v['status'] = 'cancelled';
            $update_v['processed_by'] = Admin::info()->admin_id;
 			$update_v['processed_by_name'] = Admin::info()->account_username ." ( " .Admin::info()->admin_position_name. " )";
			Tbl_voucher::where('voucher_id', Request::input('voucher_id'))->lockForUpdate()->update($update_v);

			 /**
			 * UPDATE WALLET LOG
			 */
			if($voucher_query->slot_id != 0)
			{
				$log = "Voucher no. ".Request::input('voucher_id')." has been voided by ".Admin::info()->account_username." (".Admin::info()->admin_position_name ."). ".  Product::return_format_num($voucher_query->total_amount)." slot wallet return." ;
	            // Log::slot($voucher_slot->slot_id, $log, $updated_wallet);
            }
			/**
			 * UPDATE ACCOUNT/ADMIN LOG
			 */

			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." voids the voucher #".Request::input('voucher_id'));

            $log2 = "Voided Voucher # ".Request::input('voucher_id'). " as ".  Admin::info()->admin_position_name.".";
            Log::account(Admin::info()->account_id, $log2);


			/**
			 * DELETE ALL THE RELATED PRODUCT_CODE OF THE VOUCHER
			 */
			foreach ($voucher_product as $key => $value)
			{
				Tbl_product_code::where('voucher_item_id', $value['voucher_item_id'])->delete();
			}

		}

		return $data;
	}


	public function show_product()
	{
				$voucher_id = Request::input('voucher_id');
				$data['voucher'] = 	Tbl_voucher::find($voucher_id);
				$data['_voucher_product']  = Tbl_voucher_has_product::where('voucher_id', $voucher_id)->product()->get();
				if($data['_voucher_product'])
				{
					foreach ($data['_voucher_product'] as $key => $value)
					{
						$total_product[] =  $value->product_discount_amount;
						$discount[] = $value->product_discount_amount;
					}
				}else
				{
					$total_product = [];
				}

				$data['product_total'] = array_sum($total_product);
				$data['discount_pts'] =	 array_sum($discount);


		




				return view('admin.transaction.claim_voucher_product', $data);
	}




}


