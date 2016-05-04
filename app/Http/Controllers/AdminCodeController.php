<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
// use Illuminate\Http\Request;
use Request;
use App\Tbl_membership;
use App\Tbl_code_type;
use App\Tbl_product_package;
use App\Tbl_account;
use App\Tbl_inventory_update_type;
use App\Tbl_membership_code;
use Datatables;
use Validator;
use Session;
use App\Classes\Globals;
use App\Rel_membership_code;
use App\Tbl_wallet_logs;
use App\Tbl_membership_code_sale;
use App\Tbl_membership_code_sale_has_code;
use App\Classes\Admin;
use App\Classes\Settings;
use App\Tbl_product_package_has;
use App\Tbl_product;
use App\Tbl_voucher;
use App\Tbl_voucher_has_product;
use App\Classes\Log;
use Carbon\Carbon;
use Mail;
use PDF;


class AdminCodeController extends AdminController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$data['_account'] = Tbl_account::all();
		$data['total_code'] = Tbl_membership_code::count();
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits Membership Code");
		return view('admin.maintenance.code', $data);
	}



	public function ajax_get_membership_code()
    {

    	$stat = Request::input('status');
        $membership_code = Tbl_membership_code::byAdmin()->getMembership()->getCodeType()->getPackage()->getInventoryType()->getUsedBy()->where(function ($query) use ($stat) {
    

        	switch ($stat)
        	{
        		case 'unused':

        			$query->where('tbl_membership_code.blocked',0)->where('tbl_membership_code.used',0)->whereNotNull('tbl_account.account_id');
        			break;

        		case 'used':
        			$query->where('tbl_membership_code.blocked',0)->where('tbl_membership_code.used',1)->whereNotNull('tbl_account.account_id');
        			break;

        		case 'blocked':
        			$query->where('tbl_membership_code.blocked',1);
        			break;
        			
        		default:
        		      $query->where('tbl_membership_code.blocked',0)->where('tbl_membership_code.used',0)->whereNull('tbl_account.account_id');
      
        	}


        })->select('tbl_membership_code.code_pin','tbl_membership_code.code_activation','tbl_membership.membership_name','tbl_code_type.code_type_name','product_package_name','tbl_account.account_id','account_name','tbl_inventory_update_type.inventory_update_type_id','tbl_membership_code.created_at')->get();
      
        								if($stat == "blocked")
        								{
        									return Datatables::of($membership_code)	
	        								->addColumn('delete','<a href="#" class="unblock-membership-code" membership-code-id ="{{$code_pin}}">UNBLOCK</a>')
	    									->addColumn('transfer','<a class="transfer-membership-code"  href="#" membership-code-id="{{$code_pin}}" account-id="{{$account_id}}">TRANSFER</a>')
	        								// ->editColumn('created_at','{{$created_at->format("F d, Y g:ia")}}')
	        								->editColumn('inventory_update_type_id','<input type="checkbox" {{$inventory_update_type_id == 1 ? \'checked="checked"\' : \'\'}} name="" value="" readonly disabled>')
	        								->editColumn('account_name','{{$account_name or "No owner"}}')
	        								->addColumn('slot_used','{{App\Classes\Globals::get_string_between_for_used_codes(App\Tbl_wallet_logs::where("logs","LIKE","%using membership code #$code_pin%")->first(),"create slot #"," using")}}')
	        								->make(true);
        								}
        								else
        								{
        									 return Datatables::of($membership_code)	
	        								->addColumn('delete','<a href="#" class="block-membership-code" membership-code-id ="{{$code_pin}}">BLOCK</a>')
	        								->addColumn('transfer','<a class="transfer-membership-code"  href="#" membership-code-id="{{$code_pin}}" account-id="{{$account_id}}">TRANSFER</a>')
	        								// ->editColumn('created_at','{{$created_at->format("F d, Y g:ia")}}')
	        								->editColumn('inventory_update_type_id','<input type="checkbox" {{$inventory_update_type_id == 1 ? \'checked="checked"\' : \'\'}} name="" value="" readonly disabled>')
	        								->editColumn('account_name','{{$account_name or "No owner"}}')
	        								->addColumn('slot_used','{{App\Classes\Globals::get_string_between_for_used_codes(App\Tbl_wallet_logs::where("logs","LIKE","%using membership code #$code_pin%")->first(),"create slot #"," using")}}')
	        								->make(true);        								
        								}
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function add_code()
	{

		$data['_membership'] = Tbl_membership::where('membership_entry', 1)->where("archived", 0)->get();
		$data['_code_type'] = Tbl_code_type::all();
		// $data['_prod_package'] = Tbl_product_package::where('archived', 0)->get();
		$data['_account'] = Tbl_account::all();
		$data['_inventory_update_type'] = Tbl_inventory_update_type::all();

		return view('admin.maintenance.code_add',$data);
	}

	public function addCodePost()
	{
		$messages = [];
		$requests['membership_id'] = Request::input('membership_id');
		$requests['product_package_id'] = Request::input('product_package_id');
		$requests['code_type_id'] = Request::input('code_type_id');
		$requests['account_id'] = Request::input('account_id');
		$requests['inventory_update_type_id'] = Request::input('inventory_update_type_id');
		$requests['order_form_number'] = Request::input('order_form_number');
		$requests['tendered_payment'] = Request::input('tendered_payment');
		
		$cart_count = count((array)Session::get('processCodeCart'));

		$requests['cart'] = $cart_count;
		$_prodCart = (array)Session::get('processCodeCart');
		$cartTotalAmount = 0; 
		foreach ($_prodCart as $prodCartKey => $prodCartValue)
		{


    		$_product = DB::table('tbl_product_package_has')->leftJoin('tbl_product','tbl_product.product_id','=','tbl_product_package_has.product_id')->where('tbl_product_package_has.product_package_id', $prodCartValue['product_package_id'])->get();
    		foreach ($_product as $productKey => $productValue)
    		{
    			$requests["product_id_".$productValue->product_id] = $productValue->product_id;
    			$pcs = $prodCartValue['qty'] * $productValue->quantity;
    			$stock = $productValue->stock_qty;
    			$rules["product_id_".$productValue->product_id] = "foo:$stock,$pcs";
    			$messages["product_id_".$productValue->product_id.".foo"] = "Product ID #".$productValue->product_id. " - ". $productValue->product_name." has unsufficient stock.";
    		}

    		$cartTotalAmount = $cartTotalAmount + $prodCartValue['sub_total'];

		}


		$rules['membership_id'] = 'required|exists:tbl_membership,membership_id,membership_entry,1,archived,0';
		$rules['order_form_number'] = 'unique:tbl_order_form_number,order_form_number';	
		$rules['code_type_id'] = 'required|exists:tbl_code_type,code_type_id';
		$rules['account_id'] = 'required|exists:tbl_account,account_id';
		$rules['inventory_update_type_id'] = 'required|exists:tbl_inventory_update_type,inventory_update_type_id';
		$rules['cart'] = 'required|integer|min:1';
		if(Request::input('code_type_id') != 3)
		{
			$rules['tendered_payment'] = 'required|integer|min:'.$cartTotalAmount;
		}


		/* CHECK PROD INVENTORY */
		Validator::extend('foo', function($attribute, $value, $parameters, $validator) {

            $current_stock = $parameters[0];
            $cartProdCount = $parameters[1];

            $stockLessProdCount = $current_stock - $cartProdCount;
            return $stockLessProdCount >= 0;
        });

		$validator = Validator::make($requests, $rules, $messages);

        if ($validator->fails())
        {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

		/* GENERATE ORDER FORM NUMBER */
		$OrderFormNum = Request::input('order_form_number') != null || Request::input('order_form_number') != "" ? Request::input('order_form_number'): Globals::saveUniqueRandomOrderFormNumber(Globals::generateRandomOrderFormNumber());



		/* GENERATE CODE SALE */
		$insertMembershipCodeSale['order_form_number'] = $OrderFormNum;
		$insertMembershipCodeSale['membershipcode_or_code'] = Globals::create_membership_code_sale(Globals::code_generator());
		$insertMembershipCodeSale['sold_to'] = Request::input('account_id');
		$insertMembershipCodeSale['generated_by'] = Admin::info()->account_id;
		$insertMembershipCodeSale['generated_by_name'] = Admin::info()->account_name;
		$insertMembershipCodeSale['code_type_id'] = Request::input('code_type_id');
		$insertMembershipCodeSale['payment'] = 1;
		$insertMembershipCodeSale['shipping_type'] = 1; 
		$insertMembershipCodeSale['tendered_payment'] = Request::input('tendered_payment');

		if(Request::input('code_type_id') == 3)
		{
			$insertMembershipCodeSale['change'] = 0;
		}
		else
		{
			$insertMembershipCodeSale['change'] = (double) Request::input('tendered_payment') - (double) $cartTotalAmount;
		}	

		$membershipCodeSale = new Tbl_membership_code_sale($insertMembershipCodeSale);
		$membershipCodeSale->save();

		/* CART */
		$_cart = (array) Session::get('processCodeCart');

		$requests['cart'] = count($_cart);

		$totalSaleArray = []; 
		foreach ($_cart as $key => $value)
		{
			$cartMembership = Tbl_membership::find($value['membership_id']);
			/* FOREACH CART QTY */		
			for ($i=0; $i < $value['qty']; $i++)
			{
				$insert_membership_code['code_activation'] = Globals::create_membership_code(Globals::code_generator());
				$insert_membership_code['code_type_id'] = Request::input('code_type_id');
				$insert_membership_code['membership_id'] = $value['membership_id'];

				if($value['product_package_id'] == 'NO PACKAGE')
				{
					$insert_membership_code['product_package_id'] = null;
				}
				else
				{
					$insert_membership_code['product_package_id'] = $value['product_package_id'];
				}

				$insert_membership_code['generated_by'] =  Admin::info()->account_id;
				$insert_membership_code['inventory_update_type_id'] = Request::input('inventory_update_type_id');
				$insert_membership_code['account_id'] = Request::input('account_id');
				$insert_membership_code['order_form_number'] = $OrderFormNum;
				
				$membership_code = new Tbl_membership_code($insert_membership_code);
				$membership_code->save();

				$insertMemberSaleHasCode['membershipcode_or_num'] = $membershipCodeSale->membershipcode_or_num;
				$insertMemberSaleHasCode['code_pin'] = $membership_code->code_pin;
				if(Request::input('code_type_id') == 3)
				{
					$cartMembership->membership_price = 0;
				}
				$insertMemberSaleHasCode['sold_price'] = $cartMembership->membership_price;
				Tbl_membership_code_sale_has_code::insert($insertMemberSaleHasCode);

				/**
				* INSERT TO Rel_membership_code history
				*/
				$insert_member_code_history['code_pin'] = $membership_code->code_pin;
				$insert_member_code_history['by_account_id'] = Admin::info()->account_id;
				$insert_member_code_history['to_account_id'] = $membership_code->account_id;
				$insert_member_code_history['updated_at'] = $membership_code->created_at;
				$insert_member_code_history['description'] = "Created by " .Admin::info()->account_name;
				DB::table("tbl_member_code_history")->insert($insert_member_code_history);

				
				if($value['product_package_id'] != null && $value['product_package_id'] != 'NO PACKAGE')
				{
					/**
					 * INSERT TO Rel_membership_code
					 */
					$insert_rel_membership_code['code_pin'] = $membership_code->code_pin;
					$insert_rel_membership_code['product_package_id'] = $value['product_package_id'];
					Rel_membership_code::insert($insert_rel_membership_code);

				}
				// IF "CLAIMABLE" CREATE PRODUCT VOUCHER
				$new_voucher = null;
				if(Request::input('inventory_update_type_id') == 1 &&  Request::input('code_type_id') != 2 && $value['product_package_id'] != null && $value['product_package_id'] != 'NO PACKAGE')
				{
					$insert_voucher['account_id'] = Request::input('account_id');
					// $insert_voucher['or_number'] = "(MEMBERSHIPCODE PURCHASE) #".$tbl_membership_code_sale->membershipcode_or_num. ' CODE : '.$tbl_membership_code_sale->membershipcode_or_code;
					$insert_voucher['or_number'] = "ORDER FORM NUMBER $OrderFormNum";
					$insert_voucher['order_form_number'] = $OrderFormNum;;
					$insert_voucher['voucher_code'] = Globals::create_voucher_code(Globals::code_generator());
					
					if(Request::input('code_type_id') == 3)
					{
						$insert_voucher['total_amount']= 0;
						$insert_voucher['status'] = 'delayed';
					}
					else
					{
						$insert_voucher['status'] = 'unclaimed';
						$insert_voucher['total_amount']= $cartMembership->membership_price;						
					}

					$insert_voucher['discount'] = 0;
					
					$insert_voucher['payment_mode'] = 1;
					$insert_voucher['membership_code'] = $membership_code->code_pin;
					$insert_voucher['processed_by_name'] = Admin::info()->account_name .' ('.Admin::info()->admin_position_name.')';
					$insert_voucher['admin_id'] = Admin::info()->admin_id;

					$new_voucher = new Tbl_voucher($insert_voucher);
					$new_voucher->save();

					$prod = Tbl_product_package_has::where('product_package_id', $value['product_package_id'])->product()->get();
					
					foreach ($prod as $prod_key => $prod_val)
					{
						$prodpack = Tbl_product::find($prod_val->product_id);
						$insert_voucher_item['voucher_id'] = $new_voucher->voucher_id;
						$insert_voucher_item['product_id'] = $prod_val->product_id;
						$insert_voucher_item['price'] = $prod_val->price;
						$insert_voucher_item['sub_total'] = 0;
						$insert_voucher_item['unilevel_pts'] = $prodpack->unilevel_pts;
						$insert_voucher_item['binary_pts'] = $prodpack->binary_pts;
						$insert_voucher_item['qty'] = $prod_val->quantity;
						$new_tbl_voucher_has_product = new Tbl_voucher_has_product($insert_voucher_item);
						$new_tbl_voucher_has_product->save();
						Tbl_voucher_has_product::insert($insert_voucher_item);
					}
				}
			} // end forloop

			//"Deduct Right Away" DEDUCT THE PRODUCT INVENTORY
			if(Request::input('inventory_update_type_id') == 2 && Request::input('code_type_id') != 2 && $value['product_package_id'] != null && $value['product_package_id'] == 'NO PACKAGE')
			{
				$prod2 = Tbl_product_package_has::where('product_package_id', $value['product_package_id'])->get();
				foreach ($prod2 as $key2 => $value2)
				{
					$prodpack = Tbl_product::find($value2->product_id);
					$updated_stock = $prodpack->stock_qty - ($value2->quantity * (Integer)$_cart[$key2]['qty']);
					Tbl_product::where('product_id',$value2->product_id)->lockForUpdate()->update(['stock_qty' => $updated_stock]);
				}
           		
			}

		} // end foreach


		/* UPDATE THE CODE SALE FOR THE TOTAL SALE */
		$totalCodeSale = Tbl_membership_code_sale_has_code::where('membershipcode_or_num', $membershipCodeSale->membershipcode_or_num)->sum('sold_price');
		Tbl_membership_code_sale::where('membershipcode_or_num', $membershipCodeSale->membershipcode_or_num)->update(['total_amount' => $totalCodeSale]);
		/* ADMIN LOG */ 
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." Generated membership code/s with Order Form Number : ".$OrderFormNum.".");
		Session::forget('processCodeCart');

		return redirect('/admin/maintenance/codes/or2?order_form_number='.$OrderFormNum);
	}

	public static function code_generator()
    {
        
        $chars="0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $res = "";
        for ($i = 0; $i < 8; $i++) {
            $res .= $chars[mt_rand(0, strlen($chars)-1)];
        }

        return $res;

    }



	public function block()
	{	


		$query = Tbl_membership_code::where('code_pin', Request::input('code_pin'))
										->where('used', 0)
										->firstOrFail();
		$query->update(['blocked'=>1]);

		return json_encode($query);
	}	

	public function unblock()
	{	


		$query = Tbl_membership_code::where('code_pin', Request::input('code_pin'))
										->where('used', 0)
										->firstOrFail();
		$query->update(['blocked'=>0]);

		return json_encode($query);
	}

	public function transfer_code()
	{	


		$account_id = intval(Request::input('account_id'));
		

		$query = Tbl_membership_code::where('code_pin', Request::input('code_pin'))
										->where('used', 0)
										// ->where('blocked', 0)
										->firstOrFail();
									
		if(!empty($account_id))
		{
			$query->update(['account_id'=>Request::input('account_id')]);
		}

		return json_encode($query);


		
	}

	public function verify_code()
	{	

		// $data['_error'] = null;

		$data['code'] =  Tbl_membership_code::where('code_pin', Request::input('code_pin'))->getUsedBy()->getInventoryType()->first();
										// ->first();
		
		if($data['code'])
		{
			if($data['code']->blocked == 0)
			{
				$data['code']->stat  = $data['code']->used == 0 ? 'Unused' : 'Used';
			}
			else
			{
				$data['code']->stat = 'block';
			}
		}
		else
		{
			return '<div class="col-md-12 alert alert-warning">
						<p class="col-md-12">
							No Results
						</p>
					</div>';
		}




		// dd($data['code'] );

		return view('.admin.maintenance.code_check',$data) ;
	}




	public function show_sale_or()
	{



		$or_num = Request::input('membershipcode_or_num');



		$membership_code_sale = Tbl_membership_code_sale::find($or_num);
		$generated_by = Tbl_account::find($membership_code_sale->generated_by);
		$membership_code_sale->generated_by = $generated_by->account_name . " (".  $generated_by->account_username.")";
		$sold_to = Tbl_account::find($membership_code_sale->sold_to);
		$membership_code_sale->sold_to = $generated_by->account_name;
		// $membership_code_sale->created_at = Carbon::createFromTimeStamp($membership_code_sale->created_at->toFormattedDateString())->toFormattedDateString();
		

		$data['membership_code_sale'] = $membership_code_sale;

		$data['_codes'] = Tbl_membership_code_sale_has_code::select('tbl_membership_code_sale_has_code.*','tbl_membership_code.*','tbl_membership.*' )
										->leftJoin('tbl_membership_code', 'tbl_membership_code.code_pin' ,'=','tbl_membership_code_sale_has_code.code_pin')
										->leftJoin('tbl_membership', 'tbl_membership.membership_id','=', 'tbl_membership_code.membership_id')
										->where('tbl_membership_code_sale_has_code.membershipcode_or_num', $or_num)
										->get();


		$data['_product'] =  Tbl_voucher_has_product::select('tbl_voucher_has_product.*','tbl_product.product_name')
													->leftJoin('tbl_product','tbl_product.product_id', '=','tbl_voucher_has_product.product_id' )
													->where('tbl_voucher_has_product.voucher_id', $membership_code_sale->voucher_id)
													->get();

        

		if(Request::isMethod('post'))
		{

			$company_email = Settings::get('company_email');
			$company_name = Settings::get('company_name');

			// dd($company_email);

			$message_info['from']['email'] = $company_email;
			$message_info['from']['name'] = Admin::info()->account_name . ' ('.Admin::info()->admin_position_name.')';

			$message_info['to']['email'] = $sold_to->account_email;
			// $message_info['to']['email'] = "edwardguevarra2003@gmail.com";
			$message_info['to']['name'] = $sold_to->account_name;
			$message_info['subject'] = $company_name." - Membership OR";
			Mail::send('emails.membership_or_email', $data, function ($message) use($message_info)
			{
			    $message->from($message_info['from']['email'], $message_info['from']['name']);
			    $message->to($message_info['to']['email'],$message_info['to']['name']);
			    $message->subject($message_info['subject']);
			});


			return json_encode($sold_to->account_email);
		}

		return view('admin/maintenance/code_or', $data);
	}


	public function load_product_package()
	{


		$prodpack = Tbl_product_package::where('membership_id', Request::input('membership_id'))->get();

		return $prodpack;


	}

	public function addToCart()
	{

		$packageId = Request::input('product_package_id');
		$qty = (integer) Request::input('qty') <= 0 ? 1 : Request::input('qty');
		$package = Tbl_product_package::leftJoin('tbl_membership', 'tbl_membership.membership_id','=','tbl_product_package.membership_id')
										->where('tbl_product_package.product_package_id', $packageId)
										->first();	

		$membership_id = Request::input('membership_to_id');
		$membership_data = Tbl_membership::where('membership_id',$membership_id)->first();	

        if($package || $packageId == 'NO PACKAGE')
        {
        	$processCodeCart = (array) Session::get('processCodeCart');

        	$inCart = false;
    		foreach ($processCodeCart as $key => $value)
    		{
  				if($packageId == 'NO PACKAGE')
				{
	    			if($value['membership_id'] == $membership_id && $value['product_package_id'] == 'NO PACKAGE')
	    			{	
	    				/* IF ITEM IS IN THE CART ADD THE QTY */ 
	    				$inCart = true;
	    				$processCodeCart[$key]['qty'] = $processCodeCart[$key]['qty'] + $qty;
	    				$processCodeCart[$key]['membership_price'] = $membership_data->membership_price;
	    				$processCodeCart[$key]['sub_total'] = (integer) $processCodeCart[$key]['qty'] * (double)$processCodeCart[$key]['membership_price'];
	    			}
				}
				else
				{
	    			if($value['membership_id'] == $package->membership_id && $value['product_package_id'] == $package->product_package_id)
	    			{	
	    				/* IF ITEM IS IN THE CART ADD THE QTY */ 
	    				$inCart = true;
	    				$processCodeCart[$key]['qty'] = $processCodeCart[$key]['qty'] + $qty;
	    				$processCodeCart[$key]['membership_price'] = $package->membership_price;
	    				$processCodeCart[$key]['sub_total'] = (integer) $processCodeCart[$key]['qty'] * (double)$processCodeCart[$key]['membership_price'];
	    			}					
				}



    		}
    		/* IF ITEM IS NOT IN THE CART ADD THE ARRAY TO CART */ 
    		if($inCart == false)
    		{
    			if($packageId == 'NO PACKAGE')
    			{
		    		$arrayCart['membership_id'] = $membership_id;
		        	$arrayCart['membership_name'] = $membership_data->membership_name;
		        	$arrayCart['membership_price'] = $membership_data->membership_price;
		        	$arrayCart['qty'] = $qty;
		        	$arrayCart['product_package_id'] = 'NO PACKAGE';
		        	$arrayCart['product_package_name'] = 'NO PACKAGE';
		        	$arrayCart['sub_total'] = (double) $arrayCart['membership_price'] * $qty;
		        	$processCodeCart[] = $arrayCart;
    			}
    			else
    			{
		    		$arrayCart['membership_id'] = $package->membership_id;
		        	$arrayCart['membership_name'] = $package->membership_name;
		        	$arrayCart['membership_price'] = $package->membership_price;
		        	$arrayCart['qty'] = $qty;
		        	$arrayCart['product_package_id'] = $package->product_package_id;
		        	$arrayCart['product_package_name'] = $package->product_package_name;
		        	$arrayCart['sub_total'] = (double) $arrayCart['membership_price'] * $qty;
		        	$processCodeCart[] = $arrayCart;
    			}
    		}

    		/* SAVE THE SESSION */ 
       		Session::put('processCodeCart', $processCodeCart);
       		// Session::forget('processCodeCart');
       		$data = Session::get('processCodeCart');
        }
        else
        {
        	$data = false;
        }

        return json_encode($data);

	}

	public function showCart()
	{

		$finalTotal = 0;
		$data['cart'] = (array) Session::get('processCodeCart');
		foreach ($data['cart'] as $key => $value)
		{	
			if(Request::input('code_type_id') == 3)
			{
				$finalTotal = 0;
			}
			else
			{
				$finalTotal = $finalTotal + $value['sub_total'];
			}

		}

		$data['finalTotal'] = $finalTotal;
		return view('admin.maintenance.admin_code_cart', $data);
	}

	public function removeFromCart()
	{
		$cartIndex = Request::input('cartIndex');
		$processCodeCart = (array) Session::get('processCodeCart');
		if(array_key_exists($cartIndex, $processCodeCart))
		{
			unset($processCodeCart[$cartIndex]);
			Session::put('processCodeCart', $processCodeCart);
		}
		return $cartIndex;


	}

	public function membershipSales()
	{

		$order_form_number = Request::input('order_form_number');
		$codeSale = Tbl_membership_code_sale::select('tbl_membership_code_sale.*', 'sold_to_account.account_name as sold_to_name', 'sold_to_account.account_username as sold_to_username', 'generated_by_account.account_name as generated_by_name','generated_by_account.account_username as generated_by_username', 'payment_type.code_type_name as payment_type')
												->where('tbl_membership_code_sale.order_form_number', $order_form_number)
												->leftJoin('tbl_account as sold_to_account', 'sold_to_account.account_id' ,'=', 'tbl_membership_code_sale.sold_to')
												->leftJoin('tbl_account as generated_by_account', 'generated_by_account.account_id' ,'=', 'tbl_membership_code_sale.generated_by')
												->leftJoin('tbl_code_type as payment_type', 'payment_type.code_type_id','=','tbl_membership_code_sale.code_type_id')
												->first();

		$data['codeSale'] = $codeSale;
		$codes = Tbl_membership_code_sale_has_code::where('tbl_membership_code_sale_has_code.membershipcode_or_num', $codeSale->membershipcode_or_num)
													->leftJoin('tbl_membership_code','tbl_membership_code.code_pin', '=', 'tbl_membership_code_sale_has_code.code_pin')
													->leftJoin('tbl_membership', 'tbl_membership.membership_id', '=', 'tbl_membership_code.membership_id')
													->leftJoin('tbl_product_package', 'tbl_product_package.product_package_id', '=', 'tbl_membership_code.product_package_id')
													->get();

		$data['codes'] = $codes;
		// return view('admin.maintenance.code_sale_print_or_pdf',$data);
		$pdf = PDF::loadView('admin.maintenance.code_sale_print_or_pdf', $data);
		return $pdf->stream('invoice.pdf');


	}


	public function membershipViewVoucherCode()
	{

		$order_form_number = Request::input('order_form_number');
		$codeSale = Tbl_membership_code_sale::select('tbl_membership_code_sale.*', 'sold_to_account.account_name as sold_to_name', 'sold_to_account.account_username as sold_to_username', 'generated_by_account.account_name as generated_by_name','generated_by_account.account_username as generated_by_username', 'payment_type.code_type_name as payment_type')
												->where('tbl_membership_code_sale.membershipcode_or_num', $order_form_number)
												->leftJoin('tbl_account as sold_to_account', 'sold_to_account.account_id' ,'=', 'tbl_membership_code_sale.sold_to')
												->leftJoin('tbl_account as generated_by_account', 'generated_by_account.account_id' ,'=', 'tbl_membership_code_sale.generated_by')
												->leftJoin('tbl_code_type as payment_type', 'payment_type.code_type_id','=','tbl_membership_code_sale.code_type_id')
												->first();

		$data['codeSale'] = $codeSale;
		$codes = Tbl_membership_code_sale_has_code::where('tbl_membership_code_sale_has_code.membershipcode_or_num', $codeSale->membershipcode_or_num)
													->leftJoin('tbl_membership_code','tbl_membership_code.code_pin', '=', 'tbl_membership_code_sale_has_code.code_pin')
													->leftJoin('tbl_membership', 'tbl_membership.membership_id', '=', 'tbl_membership_code.membership_id')
													->leftJoin('tbl_product_package', 'tbl_product_package.product_package_id', '=', 'tbl_membership_code.product_package_id')
													->get();
		$data['codes'] = $codes;
		// return view('admin.maintenance.code_sale_print_or_pdf',$data);
		// $pdf = PDF::loadView('admin.maintenance.code_sale_print_or_pdf', $data);
		return view('admin.maintenance.code_sale_print_or_pdf', $data);


	}


	public function get_voucher_codes()
	{


		$data['_account'] = Tbl_account::all();
		$data['total_code'] = Tbl_membership_code::count();
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits Code Transactions");
		return view('admin.transaction.code_transactions', $data);
	}



	public function ajax_get_voucher_codes()
    {

    	$stat = Request::input('status');
        $membership_code = Tbl_membership_code_sale_has_code::join('tbl_membership_code_sale','tbl_membership_code_sale.membershipcode_or_num','=','tbl_membership_code_sale_has_code.membershipcode_or_num')->join('tbl_account','tbl_account.account_id','=','tbl_membership_code_sale.sold_to')->groupBy('tbl_membership_code_sale_has_code.membershipcode_or_num')->get();

        return Datatables::of($membership_code)	
        ->addColumn('view_voucher','<a target="_blank" href="/admin/transaction/view_voucher_codes/code_transactions?order_form_number={{$membershipcode_or_num}}"> View Voucher</a>')
		->make(true);
    }

}
