<?php namespace App\Http\Controllers;
use Request;
use DB;
use App\Classes\Stockist;
use Redirect;
use Session;
use gapi;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tbl_account;
use App\Tbl_slot;
use App\Tbl_product;
use Datatables;
use Validator;
use Crypt;
use Carbon\Carbon;
use App\Tbl_voucher;
use App\Tbl_voucher_has_product;
use App\Tbl_stockist_inventory;
use App\Classes\Globals;
use App\Tbl_product_code;
use App\Classes\Log;
use App\Classes\Settings;
use Mail;
use App\Classes\StockistLog;

class StockistProcessSales extends StockistController
{
    public function index()
    {
        return view('stockist.process_sales.sales');
    }


    public function process_sale()
    {
        $data['_member_account'] = Tbl_account::all();
        return view('stockist.process_sales.process', $data);
    }

    public function ajax_get_product()
    {
        

        $product = Tbl_stockist_inventory::where('stockist_id',Stockist::info()->stockist_id)
                                                    ->orderBy('tbl_stockist_inventory.product_id','asc')
                                                    ->where('tbl_stockist_inventory.archived',0)
                                                    ->join('tbl_product','tbl_product.product_id','=','tbl_stockist_inventory.product_id')
                                                    ->get();

        return Datatables::of($product) 
                                        ->addColumn('add','<a class="add-to-package" href="#" product-id="{{$product_id}}">ADD</a>')
                                        ->make(true);
        
    }


    public function add_to_cart()
    {

        $cart = Session::get('admin_cart');
        $product = Tbl_product::find(Request::input('product_id'));
        $qty = (Integer)Request::input('qty') == 0 ? 1 : Request::input('qty');

        if($cart)
        {

            if($this->check_in_array(Request::input('product_id'),$cart))
            {
                $cart[Request::input('product_id')]['qty'] =  $cart[Request::input('product_id')]['qty'] + $qty;
                $cart[Request::input('product_id')]['sub_total'] =  $cart[Request::input('product_id')]['qty'] * $product->price;
            }
            else
            {
                $cart = $this->insert_to_session($cart, Request::input(), $product);
            }

        }
        else
        {
            $cart  = $this->insert_to_session($cart, Request::input(), $product);
        }

        Session::put('admin_cart', $cart);
        return json_encode(Session::get('admin_cart'));
    }



    public function edit_cart()
    {
        $cart = Session::get('admin_cart');
        $product = Tbl_product::find(Request::input('product_id'));
        $cart = $this->insert_to_session($cart,Request::input(), $product);
        Session::put('admin_cart', $cart);
        return json_encode(Session::get('admin_cart'));
    }

    public function insert_to_session($cart,$input, $product)
    {


        $qty = (Integer) $input['qty'] == 0 ? 1 : $input['qty'];

        $cart[$input['product_id']]['product_id'] = $product->product_id;
        $cart[$input['product_id']]['sku'] = $product->sku;
        $cart[$input['product_id']]['product_name'] = $product->product_name;
        $cart[$input['product_id']]['qty'] = $qty;
        $cart[$input['product_id']]['price'] = $product->price;
        $cart[$input['product_id']]['sub_total'] = $qty  * (Double)$product->price;

        return $cart;
    }

    public function get_cart()
    {

        $data['cart'] = Session::get('admin_cart');
        $slot_id = Request::input('slot_id');
        $other = 0;
        $credit = 0;
        if(Request::input('other'))
        {
            $other = Request::input('other');
        }
        if(Request::input('credit'))
        {
            $credit = Request::input('credit');
        }
        $slot = Tbl_slot::select('tbl_slot.*', 'tbl_membership.discount')->leftJoin('tbl_membership', 'tbl_membership.membership_id','=','tbl_slot.slot_membership')
                                                        ->find($slot_id);
        $discount = 0;
        if($slot)
        {
            $discount = $slot->discount;
        }     

        $other = $other + $credit;



        $data['other'] = $other;
        $data['discount'] = $discount;
        $cart_total = $data['cart_total'] = $this->get_cart_total($data['cart']);
        $discount_pts = $data['discount_pts'] = (($discount / 100) * $cart_total );
        $data['other_pts'] = (($other / 100) * $cart_total );
        $total_charge = $data['other_pts'];
        $final_total = $data['final_total'] = $cart_total - $discount_pts + $total_charge;
        




        
        return view('admin.transaction.sale_cart', $data);
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

    public function remove_to_cart()
    {
        
        $cart = Session::get('admin_cart');
        unset($cart[Request::input('product_id')]);
        Session::put('admin_cart',$cart);
        return $cart;
    }

    public function process_nonMember()
    {
        // return Request::input();



        $_cart_product = Session::get('admin_cart');



       

        $request['member_type'] = Request::input('member_type');
        $rules['member_type'] = 'required|check_member_type';

        $request['account_password'] = Request::input('account_password');
        $rules['account_password'] = 'required|validatepass';


        $request['product_count'] = count($_cart_product);
        $rules['product_count'] = 'integer|min:1';

        $message["account_password.validatepass"] = "Incorrect password.";
        $message["member_type.check_member_type"] = "Invalid Customer type.";

        

        if($_cart_product)
        {

            /**
            * VALIDATOR REQUEST PRODUCT VOUCHER
            */
            foreach($_cart_product as $key => $val)
            {
                $request['product_'.$key] = $val['product_id'];
            }

            foreach($_cart_product as $key => $val)
            {

                $prod = Tbl_product::join('tbl_stockist_inventory','tbl_stockist_inventory.product_id','=','tbl_product.product_id')
                                    ->where('stockist_id',Stockist::info()->stockist_id)
                                    ->find($val['product_id']);

                $rules['product_'.$key] = 'exists:Tbl_stockist_inventory,product_id,stockist_id,'.Stockist::info()->stockist_id.'|check_stockist_quantity:'.$val['qty'].','.$prod->stockist_quantity.','.Request::input('status');
            }

            foreach($_cart_product as $key => $val)
            {

                $message['product_'.$key.'.check_stockist_quantity'] = 'The :attribute has unsufficient stock.';
            }

        }

         $this->custom_validate();

        $validator = Validator::make($request, $rules,$message);

        if ($validator->fails())
        {
            return redirect('stockist/process_sales/process/')
                        ->withErrors($validator)
                        ->withInput(Request::input());

        }





        $_cart = $_cart_product;
        $cart_total = $this->get_cart_total($_cart);


        // $insert_voucher['slot_id'] = Request::input('slot_id');
        // $insert_voucher['account_id'] = Request::input('account_id');
        $insert_voucher['voucher_code'] = Globals::create_voucher_code();
        $insert_voucher['status'] = Request::input('status');

        // $_slot = Tbl_slot::select('tbl_slot.*', 'tbl_membership.discount')->leftJoin('tbl_membership', 'tbl_membership.membership_id','=','tbl_slot.slot_membership')
        //                                                 ->where('slot_owner', Request::input('account_id'))
        //                                                 ->first();
        $additional = 0;

        $insert_voucher['payment_option'] = Request::input('payment_option');
        if(Request::input('other_charge'))
        {
            $additional = $additional + Request::input('other_charge');
        }

        if(Request::input('payment_option') == 1)
        {
            $additional = $additional + 3;
        }

        $_slot_discount = 0;
        $insert_voucher['discount'] = $_slot_discount;
        $insert_voucher['total_amount'] = $cart_total - (($_slot_discount / 100) * $cart_total) + (($additional/100) * $cart_total);
        /**
         * PAYMENT MODE IS ALWAYS CASH IN PROCESS SALES
         */
        $insert_voucher['payment_mode'] = 1;
 
        $insert_voucher['other_charge'] = $additional;
        $insert_voucher['or_number'] = Request::input('or_number');
        $insert_voucher['origin'] = Stockist::info()->stockist_id; 
        $insert_voucher['processed_by_name'] = Stockist::info()->stockist_un ." ( Stockist )";
        /**
         * CLEAR CART
         */
        Session::forget('admin_cart');
        /**
         * SAVE VOUCHER
         */
        $voucher = new Tbl_voucher($insert_voucher);
        $voucher->save();



        $sub = $cart_total;
        $disc = $_slot_discount;
        $discam = ($_slot_discount / 100) * $cart_total;
        $overall = $insert_voucher['total_amount'];
        $name = Stockist::info()->stockist_un;
        $stockist_id = Stockist::info()->stockist_id;
        $transaction_to_id = NULL;
        $voucherer = $voucher->voucher_id;
        $extra = "Additional ".($additional/100) * $cart_total. "(".$additional."%)"; 
         /**
         * SAVE VOUCHER PRODUCT
         */
        $trans_id = StockistLog::transaction("Process Sale",$sub,$disc,$discam,$overall,$paid = 1,$claimed = 1,$name,"Non member","CASH",$stockist_id,$transaction_to_id,$extra,$voucherer);
        
        $this->add_product_to_voucher_list($voucher->voucher_id,$_cart,Request::input('member_type'), Request::input('status'),$trans_id);

        // $admin_log = "Sold Product Voucher # ".$voucher->voucher_id. " to a non-member as ".  Stockist::info()->admin_position_name.".";
        // Log::account(Admin::info()->account_id, $admin_log);


        $success_message = "Voucher # " .$voucher->voucher_id. " was successfully process."; 
        return redirect('stockist/process_sales/')->with('success_message', $success_message);



    }
    


    public function process_member()
    {   
        /**
         * GET PRODUCT CART
         */
        $_cart_product = Session::get('admin_cart');

        // dd(count($_cart_product));

        if(Request::input('payment_option') == 3 && Request::input('slot_id'))
        {

            $extra = 0;
            $_cart = Session::get('admin_cart');
            $cart_total = $this->get_cart_total($_cart);

            if(Request::input('other_charge'))
            {
                $extra = $extra + Request::input('other_charge');
            }

            if(Request::input('payment_option') == 1)
            {
                $extra = $extra + 3;
            }

            $getslot = Tbl_slot::where('slot_id',Request::input('slot_id'))->membership()->first();
            $totally = $cart_total - (($getslot->discount / 100) * $cart_total) + (($extra/100) * $cart_total);

            $ewallet = $getslot->slot_wallet - $totally;
            $request['ewallet'] = $ewallet;

            if($ewallet < 0)
            {
                $data['error'][0] = "Slot wallet's is not enough to buy this.";
                return redirect('stockist/process_sales/process/')
                                ->withErrors($data['error'][0])
                                ->withInput(Request::input());


            }
        }



        $request['member_type'] = Request::input('member_type');
        $rules['member_type'] = 'required|check_member_type';


        $request['or_number'] = Request::input('or_number');
        $rules['or_number'] = 'unique:tbl_voucher,or_number';

        

        $request['account_id'] = Request::input('account_id');
        $rules['account_id'] = 'required|exists:tbl_account,account_id';

        $request['slot_id'] = Request::input('slot_id');
        $rules['slot_id'] = 'required|exists:tbl_slot,slot_id,slot_owner,'.Request::input('account_id');

        $request['status'] = Request::input('status');
        $rules['status'] = 'required|stat';
        
        $request['account_password'] = Request::input('account_password');
        $rules['account_password'] = 'required|validatepass';


        $request['product_count'] = count($_cart_product);
        $rules['product_count'] = 'integer|min:1';



        
        $message["status.stat"] = "Invalid status value.";
        $message["account_password.validatepass"] = "Incorrect password.";
        $message["member_type.check_member_type"] = "Invalid Customer type.";

        /**
         * CART PRODCT VALIDATION
         */
        if($_cart_product)
        {

            /**
            * VALIDATOR REQUEST PRODUCT VOUCHER
            */
            foreach($_cart_product as $key => $val)
            {
                $request['product_'.$key] = $val['product_id'];
            }

            foreach($_cart_product as $key => $val)
            {



                $prod = Tbl_product::join('tbl_stockist_inventory','tbl_stockist_inventory.product_id','=','tbl_product.product_id')
                                    ->where('stockist_id',Stockist::info()->stockist_id)
                                    ->find($val['product_id']);

                $rules['product_'.$key] = 'exists:Tbl_stockist_inventory,product_id,stockist_id,'.Stockist::info()->stockist_id.'|check_stockist_quantity:'.$val['qty'].','.$prod->stockist_quantity.',processed';
            }

            foreach($_cart_product as $key => $val)
            {

                $message['product_'.$key.'.check_stockist_quantity'] = 'The :attribute has unsufficient stock.';
            }
        }

        /**
         * INCLUDE CUSTOM VALIDATION FUNCTION
         */
        $this->custom_validate();

        $validator = Validator::make($request, $rules, $message);

        if ($validator->fails())
        {
            return redirect('stockist/process_sales/process/')
                        ->withErrors($validator)
                        ->withInput(Request::input());

        }


        $_cart = Session::get('admin_cart');
        $cart_total = $this->get_cart_total($_cart);
        $additional = 0;

        $insert_voucher['slot_id'] = Request::input('slot_id');
        $insert_voucher['account_id'] = Request::input('account_id');
        $insert_voucher['voucher_code'] = Globals::create_voucher_code();
        $insert_voucher['status'] = Request::input('status');
        $insert_voucher['payment_option'] = Request::input('payment_option');
        if(Request::input('other_charge'))
        {
            $additional = $additional + Request::input('other_charge');
        }

        if(Request::input('payment_option') == 1)
        {
            $additional = $additional + 3;
        }
        $insert_voucher['other_charge'] = $additional;

        $_slot = Tbl_slot::select('tbl_slot.*', 'tbl_membership.discount')->leftJoin('tbl_membership', 'tbl_membership.membership_id','=','tbl_slot.slot_membership')
                                                        ->where('slot_owner', Request::input('account_id'))
                                                        ->first();
        $insert_voucher['discount'] = $_slot->discount;
        $insert_voucher['total_amount'] = $cart_total - (($_slot->discount / 100) * $cart_total) + (($additional/100) * $cart_total);
        /**
         * PAYMENT MODE IS ALWAYS CASH IN PROCESS SALES
         */
        $insert_voucher['payment_mode'] = 1;
        if(Request::input('status') == 'processed')
        {
            $insert_voucher['or_number'] = Request::input('or_number');
            $insert_voucher['origin'] = Stockist::info()->stockist_id; 
            $insert_voucher['processed_by_name'] = Stockist::info()->stockist_un ." ( Stockist )";
        }

        if(Request::input('payment_option') == 3 && Request::input('slot_id'))
        {
            $updateslot['slot_wallet'] = $ewallet;
            Tbl_slot::where('slot_id',Request::input('slot_id'))->update($updateslot);
        }


        $sub = $cart_total;
        $disc = $_slot->discount;
        $discam = ($_slot->discount / 100) * $cart_total;
        $overall = $insert_voucher['total_amount'];
        $name = Stockist::info()->stockist_un;
        $stockist_id = Stockist::info()->stockist_id;
        $transaction_to_id = Request::input('account_id');
        $voucherer = ;
        $extra = "Additional ".($additional/100) * $cart_total. "(".$additional."%)"; 

        $trans_id = StockistLog::transaction("Process Sale",$sub,$disc,$discam,$overall,$paid = 1,$claimed = 1,$name,"Member","CASH",$stockist_id,$transaction_to_id,$extra,$voucherer);
        

        $voucher = new Tbl_voucher($insert_voucher);
        $voucher->save();


        $sub = $cart_total;
        $disc = $_slot->discount;
        $discam = ($_slot->discount / 100) * $cart_total;
        $overall = $insert_voucher['total_amount'];
        $name = Stockist::info()->stockist_un;
        $stockist_id = Stockist::info()->stockist_id;
        $transaction_to_id = Request::input('account_id');
        $voucherer = $voucher->voucher_id;
        $extra = "Additional ".($additional/100) * $cart_total. "(".$additional."%)"; 

        $trans_id = StockistLog::transaction("Process Sale",$sub,$disc,$discam,$overall,$paid = 1,$claimed = 1,$name,"Member","CASH",$stockist_id,$transaction_to_id,$extra,$voucherer);


        $this->add_product_to_voucher_list($voucher->voucher_id,$_cart,Request::input('member_type'), Request::input('status'),$trans_id);

        /**
         * UPDATE ACCOUNT/ADMIN LOG
         */
 
            $buyer = Tbl_account::find(Request::input('account_id'));
            // $admin_log = "Sold Product Voucher # ".$voucher->voucher_id. " to account #".$buyer->account_id." ".$buyer->account_name." (".$buyer->account_username.")as ".  Admin::info()->admin_position_name.".";
            $buyer_log = "Bought Product Voucher # ".$voucher->voucher_id. " from ".Stockist::info()->stockist_id. " ( Stockist ). "; 
            Log::account(Request::input('account_id'), $buyer_log);
            // Log::account(Admin::info()->account_id, $admin_log);




        /**
         * CLEAR CART
         */
        Session::forget('admin_cart');
        $success_message = "Voucher # " .$voucher->voucher_id. " was successfully process."; 
        return redirect('stockist/process_sales/')->with('success_message', $success_message);

       
        




    }

    public function add_product_to_voucher_list($voucher_id, $cart, $member_type,$status='processed',$trans_id)
    {
        foreach ((array)$cart as $key => $value)
        {
            $product = Tbl_product::join('tbl_stockist_inventory','tbl_stockist_inventory.product_id','=','tbl_product.product_id')
                                    ->where('stockist_id',Stockist::info()->stockist_id)
                                    ->find($key);


            if($status == 'processed' || $member_type == 1)
            {
                $updated_stock = $product->stockist_quantity - $value['qty'];
                Tbl_stockist_inventory::where('product_id',$key)->where('stockist_id',Stockist::info()->stockist_id)->lockForUpdate()->update(['stockist_quantity'=> $updated_stock]);
                // dd($status);
            }


            $insert_vouher_product['voucher_id'] = $voucher_id;
            $insert_vouher_product['product_id'] = $value['product_id'];
            $insert_vouher_product['price'] = $value['price'];
            $insert_vouher_product['qty'] = $value['qty'];
            $insert_vouher_product['sub_total'] = $value['sub_total'];
            $insert_vouher_product['unilevel_pts'] = $product->unilevel_pts * $value['qty'];
            $insert_vouher_product['binary_pts'] = $product->binary_pts * $value['qty'];
            $new_voucher_product = new tbl_voucher_has_product($insert_vouher_product);
            $new_voucher_product->save();

            $product_id = $value['product_id'];
            $product_package_id = NULL;
            $code_pin = NULL;
            $transaction_amount = $value['price'];
            $transaction_qty = $value['qty'];
            $transaction_total = $value['sub_total'];
            $log = "Product";
            StockistLog::relative($trans_id,$if_product=1,$if_product_package = 0,$if_code_pin = 0,$product_id,$product_package_id,$code_pin,$transaction_amount,$log,$transaction_qty,$transaction_total);
           
            if($member_type == 0)
            {



                 /**
                 * FOREACH ITEM QUANTITY CREATE PRODUCT CODE
                 */
                for ($x = 0 ; $x < $value['qty']; $x++)
                {
                    /**
                     * IF MEMBER CREATE A PRODUCT CODE
                     */
                      
                    $insert_product_code['code_activation'] = Globals::create_product_code();
                    // $insert['log_id']
                    $insert_product_code['voucher_item_id'] = $new_voucher_product->voucher_item_id;


                    $product_code = new Tbl_product_code($insert_product_code);
                    $product_code->save();
                } 

            }



        }
    }   


    public function custom_validate()
    {
        Validator::extend('check_member_type', function($attribute, $value, $parameters) 
        {

            if($value == '1' || $value == "0")
            {
                return true;
            }    
        });

        Validator::extend('check_stockist_quantity', function($attribute, $value, $parameters) 
        {
            $status = $parameters[2];

            if($status == 'processed')
            {
                $stockist_quantity = $parameters[1];
                $cart_qty = $parameters[0];

                $stock_minus_cart_qty = $stockist_quantity - $cart_qty;
                if($stockist_quantity < $cart_qty || $stock_minus_cart_qty < 0)
                {

                    /* REMOVE FROM THE CART IF PRODUCT HAS NO STOCK*/ 
                    $cart = Session::get('admin_cart');
                    unset($cart[$value]);
                    Session::forget('admin_cart');
                    Session::put('admin_cart',$cart );
                    return false;
                }
                else
                {
                    return true;
                }
            }
            else
            {
                return true;
            }

            
        });

        Validator::extend('stat', function($attribute, $value, $parameters)
        {
            if($value == 'unclaimed' || $value == 'processed')
            {
                return true;
            }
            else
            {
                return false;
            }
        });


        $admin_pass = Crypt::decrypt(Stockist::info()->stockist_pw);
        Validator::extend('validatepass', function($attribute, $value, $parameters) use($admin_pass)
        {
            if($admin_pass == $value)
            {
                return true;
            }
            else
            {
                return false;
            }
        
        });


        Validator::extend('cartCount', function($attribute, $value, $parameters) use($admin_pass)
        {
            if($value > 0 )
            {
                return true;
            }
            else
            {
                return false;
            }
        
        });


    }



    public function get_slot()
    {

        $account_id = Request::input('account_id');


        $_slot = Tbl_slot::select('tbl_slot.*', 'tbl_membership.discount')->leftJoin('tbl_membership', 'tbl_membership.membership_id','=','tbl_slot.slot_membership')
                                                                ->where('slot_owner', $account_id)
                                                                ->get();

        return $_slot;
    }

    public function get_cart_total($cart)
    {   
        $total = []; 
        

        foreach ((array) $cart as $key => $value)
        {
            $total[] = $value['sub_total'];
        }





        return array_sum($total);
    }


    public function get_sales()
    {



        $today =  Carbon::now()->toDateString();
        $filter = Request::input('filter');
        $voucher = Tbl_voucher::leftJoin('tbl_account','tbl_account.account_id','=', 'tbl_voucher.account_id')->where('origin',Stockist::info()->stockist_id)->where('status', 'processed')
                                ->where(function($query) use($today, $filter)
                                {
                                    switch ($filter)
                                    {
                                        case 'today':
                                            $query->where(DB::raw('DATE(updated_at)'),'=' , $today);
                                            break;

                                        
                                        default:
                                            $query->whereNotNull('voucher_id');
                                            // dd('oop');
                                            break;
                                            
                                    }

                                })->get();

        return Datatables::of($voucher) ->editColumn('or_number', '{{$or_number ? $or_number : "-"}}')
                                        ->editColumn('account_id', '{{$account_id ? "Member" : "Non-member"}}')
                                        ->editColumn('account_name', '{{$account_name ? $account_name . " (". $account_username. ")" : "-"}}')
                                        ->addColumn('option','{{$payment_option == 1 ? "Credit" : ""}} {{$payment_option == 0 ? "Cash" : ""}} {{$payment_option == 2 ? "Cheque" : ""}} {{$payment_option == 3 ? "Ewallet" : ""}}')
                                        ->addColumn('test','<a style="cursor: pointer;" class="view-voucher" voucher-id="{{$voucher_id}}">View Voucher</a>') 
                                        ->make(true);
    }



    public function sale_or()
    {


        $voucher_id = Request::input('voucher_id');
        $voucher = Tbl_voucher::leftJoin('tbl_account', 'tbl_account.account_id'  ,'=',  'tbl_voucher.account_id')->where('voucher_id', $voucher_id)->first();
        $voucher->formatted_date_created = $voucher->created_at->toFormattedDateString();



        

        $data['voucher'] =  $voucher;
        $data['_voucher_product']  = Tbl_voucher_has_product::where('voucher_id', $voucher_id)->product()->get();
        
        if($data['_voucher_product'])
        {
            foreach ($data['_voucher_product'] as $key => $value)
            {
                $total_product[] =  $value->sub_total;
            }
        }else
        {
            $total_product = [];
        }

        $data['product_total'] = array_sum($total_product);
        $data['discount_pts'] = ($data['voucher']->discount / 100) * $data['product_total'] ;



        if(Request::isMethod('post'))
        {

            $company_email = Settings::get('company_email');
            $company_name = Settings::get('company_name');
            $sold_to = Tbl_account::find($data['voucher']->account_id);

            $message_info['from']['email'] = $company_email;
            $message_info['from']['name'] = Stockist::info()->stockist_un . ' ( Stockist )';
            $message_info['to']['email'] = $sold_to->account_email;
            // $message_info['to']['email'] = "markponce07@gmail.com";
            $message_info['to']['name'] = $sold_to->account_name;
            $message_info['subject'] = $company_name." - Sale OR";
            Mail::send('emails.sale_or_email', $data, function ($message) use($message_info)
            {
                $message->from($message_info['from']['email'], $message_info['from']['name']);
                $message->to($message_info['to']['email'],$message_info['to']['name']);
                $message->subject($message_info['subject']);
            });


            return json_encode($sold_to->account_email);
        }

        return view('admin.transaction.sale_or', $data);
    }

}
