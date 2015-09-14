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


class AdminCodeController extends AdminController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$data['_account'] = Tbl_account::all();
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


        })->get();

        return Datatables::of($membership_code)	

        ->addColumn('delete','<a href="#" class="block-membership-code" membership-code-id ="{{$code_pin}}">BLOCK</a>')
        								->addColumn('transfer','<a class="transfer-membership-code"  href="#" membership-code-id="{{$code_pin}}" account-id="{{$account_id}}">TRANSFER</a>')
        								->editColumn('created_at','{{$created_at->format("F d, Y g:ia")}}')
        								->editColumn('inventory_update_type_id','<input type="checkbox" {{$inventory_update_type_id == 1 ? \'checked="checked"\' : \'\'}} name="" value="" readonly disabled>')
        								->editColumn('account_name','{{$account_name or "No owner"}}')
        								->make(true);
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function add_code()
	{
		$data['_error'] = null;
		$data['_membership'] = Tbl_membership::where('membership_entry', 1)->get();
		$data['_code_type'] = Tbl_code_type::all();
		$data['_prod_package'] = Tbl_product_package::all();
		$data['_account'] = Tbl_account::all();
		$data['_inventory_update_type'] = Tbl_inventory_update_type::all();
		$put['membership_id'] = Request::input('membership_id');
		$put['code_type_id'] = Request::input('code_type_id');
		$put['product_package_id'] = Request::input('product_package_id');
		$put['account_id'] = Request::input('account_id');
		$put['code_multiplier'] = Request::input('code_multiplier');
		$put['inventory_update_type_id'] = Request::input('inventory_update_type_id');

		if($put['product_package_id'] == "null")
		{
			$put['product_package_id'] = null;
		}

		if(isset($_POST['membership_id']))
		{

			$rules['code_type_id'] = 'required|exists:tbl_code_type,code_type_id';
			if(Request::input('product_package_id') == "")
			{
				$rules['product_package_id'] = 'required|exists:tbl_product_package,product_package_id,membership_id,'.Request::input('membership_id').'|foo:'.Request::input('inventory_update_type_id');
			}
			$rules['inventory_update_type_id'] = 'required|exists:tbl_inventory_update_type,inventory_update_type_id';
			$rules['account_id'] = 'required|exists:tbl_account,account_id';
			$rules['code_multiplier'] = 'min:1|integer';
			$rules['membership_id'] = 'required|exists:tbl_membership,membership_id|check_member';

			$message['product_package_id.foo'] = "One or more included product might be out of stock";
			$message['product_package_id.check_member'] = "This membership is not for Member entry";


			Validator::extend('check_member', function($attribute, $value, $parameters)
			{
	
				$membership = Tbl_membership::find($value);
				if($membership)
				{
					return true;
				}
				else
				{
					return $membership->membership_entry == 1;
				}

			});

			/**
			 * CHECK PRODUCT INVENTORY
			 */
			Validator::extend('foo', function($attribute, $value, $parameters)
			{
				$prod = Tbl_product_package_has::where('product_package_id', $value )->get();
           		//IF inventory_update_type_id VALUE IS "DEDUCT RIGHT AWAY / 2" CHECK FOR INVENTORY
           		if($parameters[0] == 2)
           		{
           			foreach ($prod as $key => $value)
           			{
           				$prodpack = Tbl_product::find($value->product_id);


			            $deducted = $prodpack->stock_qty - $value->quantity; 
						// die(var_dump($prodpack->stock_qty, $value->quantity, $deducted,  , ));
	
						if($prodpack->stock_qty >= $value->quantity && $deducted >= 0)
						{
							return true;
						}

						else
						{
							return false;
						}	
	       			}
           		}
           		else
           		{
           			return true;
           		}      	        	
       	 	});

			

			$validator = Validator::make(Request::input(),$rules, $message);
			
			if (!$validator->fails())
			{

				$selected_membership = Tbl_membership::find(Request::input('membership_id'));
				$membership_total_amount = 0;
				

				for ($i=0; $i < Request::input('code_multiplier'); $i++)
				{ 	

					/**
					* INSERT TO Tbl_membership_code
					*/
					$name =DB::table('tbl_account')->where('account_username',Session::get('admin')['username'])->first();
					$membership_code = new Tbl_membership_code($put);
					$membership_code->code_activation = Globals::create_membership_code();
					//IF code_type_id IS FREE SLOT / 2 SET PRODUCT PACKAGE TO NULL
					// if(Request::input('code_type_id')==2 || Request::input('inventory_update_type_id') == 3)
					if(Request::input('code_type_id')==2)
					{
						$membership_code->product_package_id = null;
					}
					$membership_code->generated_by = Admin::info()->account_id;
					$membership_code->account_id =  Request::input('account_id') ?: null;
					$membership_code->created_at = Carbon::now();
					$membership_code->save();

					/**
					* INSERT TO Rel_membership_code history
					*/
					$insert['code_pin'] = $membership_code->code_pin;
					$insert['by_account_id'] = $name->account_id;
					$insert['to_account_id'] = $membership_code->account_id;
					$insert['updated_at'] = $membership_code->created_at;
					$insert['description'] = "Created by ".$name->account_name;
					DB::table("tbl_member_code_history")->insert($insert);

					if($put['product_package_id'] != null)
					{
						/**
						 * INSERT TO Rel_membership_code
						 */
						$insert2['code_pin'] = $membership_code->code_pin;
						$insert2['product_package_id'] = Request::input('product_package_id');
						Rel_membership_code::insert($insert2);
					}



					$membership_total_amount = $membership_total_amount + $selected_membership->membership_price; 
					$sale[] = $membership_code->code_pin;




						/**
						 * INSERT TO MEMBERSHIP SALE
						 * 
						 */
						if(Request::input('code_type_id') == 1  || Request::input('code_type_id') == 3)
						{
							$insert_membership_code_sale['membershipcode_or_code'] = Globals::create_membership_code_sale();
							$insert_membership_code_sale['sold_to'] = Request::input('account_id');
							$insert_membership_code_sale['generated_by'] = Admin::info()->account_id;
							$insert_membership_code_sale['total_amount'] = $membership_total_amount;
							$insert_membership_code_sale['payment'] = 1;
							$tbl_membership_code_sale = new Tbl_membership_code_sale($insert_membership_code_sale);
							$tbl_membership_code_sale->save($insert_membership_code_sale);
						}


						$new_voucher = null;
						//IF "CLAIMABLE" CREATE PRODUCT VOUCHER 
						if(Request::input('inventory_update_type_id') == 1 &&  Request::input('code_type_id') != 2 && $put['product_package_id'] != null)
						{
							$insert_voucher['account_id'] = Request::input('account_id');
							$insert_voucher['or_number'] = "(MEMBERSHIPCODE PURCHASE) #".$tbl_membership_code_sale->membershipcode_or_num. ' CODE : '.$tbl_membership_code_sale->membershipcode_or_code;
							$insert_voucher['voucher_code'] = Globals::create_voucher_code();
							
							if(Request::input('code_type_id') == 3)
							{
								$insert_voucher['status'] = 'delayed';
							}
							else
							{
								$insert_voucher['status'] = 'unclaimed';						
							}


							$insert_voucher['discount'] = 0;
							$insert_voucher_membership = Tbl_membership::find(Request::input('membership_id'));
							$insert_voucher['total_amount']= $insert_voucher_membership->membership_price;
							$insert_voucher['payment_mode'] = 1;
							$insert_voucher['processed_by_name'] = Admin::info()->account_name .' ('.Admin::info()->admin_position_name.')';
							$insert_voucher['admin_id'] = Admin::info()->admin_id;

							$new_voucher = new Tbl_voucher($insert_voucher);
							$new_voucher->save();

							$prod = Tbl_product_package_has::where('product_package_id', Request::input('product_package_id'))->product()->get();
							foreach ($prod as $key => $value)
							{
								$prodpack = Tbl_product::find($value->product_id);
								$insert_voucher_item['voucher_id'] = $new_voucher->voucher_id;
								$insert_voucher_item['product_id'] = $value->product_id;
								$insert_voucher_item['price'] = $value->price;
								$insert_voucher_item['sub_total'] = 0;
								$insert_voucher_item['unilevel_pts'] = $prodpack->unilevel_pts * (Integer)Request::input('code_multiplier');
								$insert_voucher_item['binary_pts'] = $prodpack->binary_pts * (Integer)Request::input('code_multiplier');
								$insert_voucher_item['qty'] = $value->quantity;
								$new_tbl_voucher_has_product = new Tbl_voucher_has_product($insert_voucher_item);
								$new_tbl_voucher_has_product->save();
							}

						}

						/**
						 *UPDATE THE VOUCHER ID IF ANY 
						 */
						if(isset($new_voucher))
						{
							$tbl_membership_code_sale_2 = Tbl_membership_code_sale::find($tbl_membership_code_sale->membershipcode_or_num);
							$tbl_membership_code_sale_2->voucher_id = $new_voucher->voucher_id;
							$tbl_membership_code_sale_2->save();
						}
						



						//"Deduct Right Away" DEDUCT THE PRODUCT INVENTORY
						if(Request::input('inventory_update_type_id') == 2 && Request::input('code_type_id') != 2 && $put['product_package_id'] != null)
						{
							$prod = Tbl_product_package_has::where('product_package_id', Request::input('product_package_id'))->get();
							foreach ($prod as $key => $value)
							{
								$prodpack = Tbl_product::find($value->product_id);
								$updated_stock = $prodpack->stock_qty - ($value->quantity * (Integer)Request::input('code_multiplier'));
								Tbl_product::where('product_id',$value->product_id)->lockForUpdate()->update(['stock_qty' => $updated_stock]);
							}
			           		
						}


						/**
						 * INSERT TO MEMBERSHIP SALE PRODUCT
						 * IF CODE TYPE IS NOT FREE SLOT
						 */
						if(Request::input('code_type_id') == 1 || Request::input('code_type_id') == 3 )
						{
							foreach ( (array)$sale as $key => $value)
							{
								$insert_membership_code_sale_has_code['code_pin'] = $value;
								$insert_membership_code_sale_has_code['sold_price'] = Tbl_membership::find(Request::input('membership_id'))->membership_price;
								$insert_membership_code_sale_has_code['membershipcode_or_num'] = $tbl_membership_code_sale->membershipcode_or_num;
								$tbl_membership_code_sale_has_code = new Tbl_membership_code_sale_has_code($insert_membership_code_sale_has_code);
								$tbl_membership_code_sale_has_code->save();
							}
							$sold_to = Tbl_account::find(Request::input('account_id'));
							$account_name = $sold_to->account_name . " (".$sold_to->account_username.')';
							$log = "Sold membership_code to " .$account_name. 'as '. Admin::info()->admin_position_name .' with membership sale OR#'.$tbl_membership_code_sale->membershipcode_or_num . '.';
							Log::account(Admin::info()->account_id, $log);
							// return Redirect('admin/maintenance/codes/or?membershipcode_or_num='.$tbl_membership_code_sale->membershipcode_or_num);
						}

				}
				




				return Redirect('admin/maintenance/codes');

			}
			else
			{
				$error =  $validator->errors();

				$data['_error']['code_type_id'] = $error->get('code_type_id');
				$data['_error']['membership_id'] = $error->get('membership_id');
				$data['_error']['product_package_id'] = $error->get('product_package_id');
				$data['_error']['inventory_update_type_id'] = $error->get('inventory_update_type_id');
				$data['_error']['account_id'] = $error->get('account_id');
				$data['_error']['code_multiplier'] = $error->get('code_multiplier');

			}

			
		}

		return view('admin.maintenance.code_add',$data);
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

	public function transfer_code()
	{	


		$account_id = intval(Request::input('account_id'));
		

		$query = Tbl_membership_code::where('code_pin', Request::input('code_pin'))
										->where('used', 0)
										->where('blocked', 0)
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


		// dd();

		$or_num = Request::input('membershipcode_or_num');



		$membership_code_sale = Tbl_membership_code_sale::find($or_num);
		$generated_by = Tbl_account::find($membership_code_sale->generated_by);
		$membership_code_sale->generated_by = $generated_by->account_name . " (".  $generated_by->account_username.")";
		$sold_to = Tbl_account::find($membership_code_sale->sold_to);
		$membership_code_sale->sold_to = $generated_by->account_name;
		// $membership_code_sale->created_at = Carbon::createFromTimeStamp($membership_code_sale->created_at->toFormattedDateString())->toFormattedDateString();
		// dd()

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
	
		// dd($data['_product']);


		return view('admin/maintenance/code_or', $data);
	}


	public function load_product_package()
	{


		$prodpack = Tbl_product_package::where('membership_id', Request::input('membership_id'))->get();

		return $prodpack;


	}


	




}
