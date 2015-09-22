<?php namespace App\Http\Controllers;
use App\Classes\Customer;
use DB;
use Request;
use Crypt;
use Redirect;
use Session;
use App\Tbl_slot;
use App\Tbl_lead;
use App\Tbl_account;
use App\Tbl_product_package_has;
use App\Classes\Globals;
use App\Tbl_voucher;
use App\Tbl_voucher_has_product;
use App\Classes\Product;
use App\Classes\Log;
use App\Tbl_product;
use App\Tbl_product_code;
use App\Tbl_tree_placement;
use App\Tbl_wallet_logs;

class MemberSlotController extends MemberController
{
	public function index()
	{
		$id = Customer::id();
		$data = $this->getslotbyid($id);
		$data['error'] = Session::get('message');
		$data['success']  = Session::get('success');
		$data['currentslot'] = Session::get('currentslot');
		$data['getlead'] = Tbl_lead::where('lead_account_id',Customer::id())->getaccount()->get();
		$data['membership2'] = 	    					 DB::table('tbl_membership')->where('archived',0)
	    												 ->orderBy('membership_price','ASC')
	    												 ->where('membership_upgrade',1)
	    												 ->get();
		if(Request::input('subup'))
		{
			$pass = DB::table('tbl_account')->where("account_id",$id)->first();
			$pass =	Crypt::decrypt($pass->account_password);
			if($pass == Request::input('pass'))
			{
				$data = $this->getcompute(Request::input('tols'),Request::input('membership'),Request::input('product'));
				return Redirect::to('/member/slot');
			}
			else
			{
				return Redirect::to('/member/slot');
			}
		}

		if(Request::input('changeslot'))
		{
		    $checkslot = 				Tbl_slot::where('slot_owner',Customer::id())	
    										  ->where('slot_id',Request::input('changeslot'))				  					  
						 					  ->first();
						 				
			if($checkslot)
			{
				if($checkslot->slot_id == Request::input('changeslot'))
				{
					Session::put('currentslot',Request::input('changeslot'));	
				}						
			}
			return redirect()->back();
		}
		if(isset($_POST['initsbmt']))
		{
			$info = $this->transfer_slot(Request::input());
			if(isset($info['success']))
			{
			   $message = $info['success'];
			   return Redirect::to('/member/slot')->with('success',$message);
			}
			else
			{
			   $message = $info['error'];
			   return Redirect::to('/member/slot')->with('message',$message);
			}
		}


        return view('member.slot',$data);
	}
	public function getslotbyid($id)
	{
		$data['slot2'] = DB::table('tbl_slot')->where('slot_owner','=',$id)
											  ->orderBy('tbl_slot.slot_id','ASC')
											  ->join('tbl_rank','rank_id','=','slot_rank')
											  ->join('tbl_membership','tbl_membership.membership_id','=','tbl_slot.slot_membership')
											  ->get();
		foreach($data['slot2'] as $key => $d)
		{
			$data['slot2'][$key]->productlist = DB::table('rel_membership_product')->join('tbl_product_package_has','tbl_product_package_has.product_package_id','=','rel_membership_product.product_package_id')
																	  			   ->join('tbl_product','tbl_product.product_id','=','tbl_product_package_has.product_id')
																	  			   ->where('rel_membership_product.slot_id',$d->slot_id)
																	  			   ->get();
			$data['slot2'][$key]->total_wallet = Tbl_wallet_logs::where("slot_id", $d->slot_id)->wallet()->sum('wallet_amount');																  			   
	   		$data['slot2'][$key]->downline = Tbl_tree_placement::where('placement_tree_parent_id',$d->slot_id)->count();														  			   
 		}

		$data['count']= DB::table('tbl_slot')->where('slot_owner','=',$id)->count();
		return $data;
	}
	public function getcompute($id,$memid,$pid)
	{
		$slot = DB::table('tbl_slot')->where('slot_id',$id)->first();
		$membership = DB::table('tbl_membership')->where('membership_id',$memid)->first();

		$datas = DB::table('tbl_slot')->leftjoin('rel_membership_product','rel_membership_product.slot_id','=','tbl_slot.slot_id')
									  ->where('tbl_slot.slot_id','=',$id)
									  ->leftjoin('tbl_product_package_has','tbl_product_package_has.product_package_id','=','rel_membership_product.product_package_id')
									  ->leftJoin('tbl_product','Tbl_product.product_id','=','tbl_product_package_has.product_id')
									  ->get();
		$wallet    = Tbl_wallet_logs::where("slot_id", $id)->wallet()->sum('wallet_amount');	
		$remaining = $wallet - $membership->membership_price;

		$datumn		 = 	    		 DB::table('tbl_membership')->where('archived',0)
												 ->orderBy('membership_price','ASC')
												 ->where('membership_upgrade',1)
												 ->get();
		$current_membership = DB::table('tbl_membership')->where('membership_id',$slot->slot_membership)->first();
		$check2 = false;

		foreach($datumn as $d)
		{
			if($d->membership_id == $memid)
			{
				$check2 = true;
			}
		}

		if($check2 == true)
		{
				$check = false;

				foreach($datas as $d)
				{
					if($d->product_id == $pid && $pid != "")
					{
						$check = true;
					}
				}

				if($check == true)
				{
					$this->additional($pid,$id);
				}

				if($remaining >= 0)
				{
					DB::table('tbl_slot')->where('slot_id','=',$id)->update(['slot_membership'=>$membership->membership_id]);
					$log = "Successfully upgrade your slot #".$id." from ".$current_membership->membership_name." to ".$membership->membership_name.", Costs <b>".$membership->membership_price." wallet. </b>";
					Log::slot($id, $log, 0 - $membership->membership_price , "Upgrade Membership",$id);
					$data = "Success";
				}
				else
				{
					$data = "You don't have enough balance in your wallet for upgrade";
				}

				return $data;			
		}



	}
	public function transfer_slot($data)
	{
		$checking = false;
		$rpass = Tbl_account::where('account_id',Customer::id())->first();
		$rpass = Crypt::decrypt($rpass->account_password);
		$info = null;
		$slot = Tbl_slot::where('slot_owner',Customer::id())->get();

		/* SLOT LIMIT */
	 	$limit = DB::table('tbl_settings')->where('key','slot_limit')->first();
		$count = Tbl_slot::where('slot_owner',$data['acct'])->count();

		

		foreach($slot as $s)
		{
			if($s->slot_id == $data['slot'])
			{
				$checking = true;
			}
		}

		if($checking == true && isset($data['acct']))
		{
				if($limit->value <=  $count)
				{
					$info['error'] = "This account is already reach the max slot per account. Max slot per account is ".$limit->value.".";
				}
				else
				{
					if($rpass == $data['pass'])
					{	
						Tbl_slot::where('slot_id',$data['slot'])->update(['slot_owner'=>$data['acct']]);
						Session::forget('currentslot');
						Tbl_account::where('account_id',$data['acct'])->update(['account_approved'=>1]);
						$info['success'] = "Success";
					}
					else
					{
						$info['error'] = "Wrong Password";	
					}
				}

		}
		else
		{
			$info['error'] = "Transfer failed";
		}

		return $info;
	}
	public function additional($pid,$slotid)
	{
		// $data['_error'] = null;
        $customer = Customer::info();
        $slot = Tbl_slot::select('tbl_slot.*', 'tbl_membership.discount')->leftJoin('tbl_membership', 'tbl_membership.membership_id','=','tbl_slot.slot_membership')
                                                                        ->where('slot_id', $slotid)
                                                                        ->where('slot_owner', $customer->account_id)
                                                                        ->first();
        $data['slot'] = $slot;
 		// $cart = Session::get('cart');
 		$prod_pts = Tbl_product::find($pid);
        // $sum_cart = $this->get_final_total($cart);
        $data['final_total'] = $prod_pts->price + (($slot->discount/100) * $prod_pts->price);
        // $data['remaining_bal'] = $slot->slot_wallet - $data['final_total'];
        // $data['pts'] = $this->get_product_point($cart);
         	   
                $insert['slot_id'] = $slotid;

               
                $insert['voucher_code'] = Globals::create_voucher_code();

                $insert ['discount'] = $slot->discount;
                $insert['total_amount'] = $data['final_total'];
                $insert['account_id'] = $customer->account_id;
      
                
               



                $voucher = new Tbl_voucher($insert);
                $voucher->save();
                $log = "Upgrade member include product worth ".Product::return_format_num($insert['total_amount']). " with Voucher Num: ".$voucher->voucher_id." , Voucher Code: ".$voucher->voucher_code.".";
                Log::account($customer->account_id, $log);

                 
                    $insert_prod =  array(
                        'product_id' =>  $pid,
                        'voucher_id'=> $voucher->voucher_id,
                        'price' => $prod_pts->price,
                        'qty'=> 1,
                        'sub_total' => $prod_pts->price,
                        'binary_pts' => $prod_pts->binary_pts,
                        'unilevel_pts' => $prod_pts->unilevel_pts
                    );

                    // $product = Tbl_product::find($key);
                    // $updated_stock_qty = $product->stock_qty - $value['qty'];
                    // Tbl_product::where('product_id', $key)->lockForUpdate()->update(['stock_qty'=>$updated_stock_qty]);

                    $voucher_has_product = new Tbl_voucher_has_product($insert_prod);
                    $voucher_has_product->save();

                    $insert_prod_code['code_activation'] = Globals::create_product_code();
                    $insert_prod_code['voucher_item_id'] = $voucher_has_product->voucher_item_id;
                    $insert_prod_code['used'] = 1;
                    $product_code = new Tbl_product_code($insert_prod_code);
                    $product_code->save();

                
	}

	public function changeslot()
	{
		if(Request::input('changeslot'))
		{
		    $checkslot = 				Tbl_slot::where('slot_owner',Customer::id())	
    										  ->where('slot_id',Request::input('changeslot'))				  					  
						 					  ->first();
						 				
			if($checkslot)
			{
				if($checkslot->slot_id == Request::input('changeslot'))
				{
					Session::put('currentslot',Request::input('changeslot'));	
				}						
			}
			return json_encode('success');
		}
	}
}