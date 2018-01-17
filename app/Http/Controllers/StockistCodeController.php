<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Request;
use Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tbl_membership_code;
use Datatables;
use App\Classes\Stockist;
use App\Classes\Globals;
use DB; 
use App\Tbl_membership;
use App\Tbl_code_type;
use App\Tbl_product_package;
use App\Tbl_account;
use App\Tbl_inventory_update_type;
use App\Tbl_product_package_has;
use Validator;
use App\Classes\Admin;
use Carbon\Carbon;
use App\Rel_membership_code;
use App\Tbl_membership_code_sale;
use App\Tbl_voucher;
use App\Tbl_product;
use App\Tbl_voucher_has_product;
use App\Tbl_membership_code_sale_has_code;
use App\Classes\Log;
use App\Tbl_stockist_package_inventory;
use Redirect;
use App\Classes\StockistLog;
class StockistCodeController extends StockistController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        return view('stockist.membership_code.stockist_membership_code');
    }



    public function ajax_get_membership_code()
    {

        $stat = Request::input('status');
        $membership_code =         Tbl_membership_code_sale_has_code::join("tbl_membership_code_sale","tbl_membership_code_sale.membershipcode_or_num","=","tbl_membership_code_sale_has_code.membershipcode_or_num")
                                         ->join("tbl_membership_code","tbl_membership_code.code_pin","=","tbl_membership_code_sale_has_code.code_pin")
                                         ->join("tbl_account","tbl_membership_code.account_id","=","tbl_account.account_id")
                                         ->where('tbl_membership_code.origin',Stockist::info()->stockist_id)
                                         ->orWhere("tbl_membership_code_sale.origin",Stockist::info()->stockist_id)
                                         ->get();
    
        return Datatables::of($membership_code) 
                        //  ->editColumn('created_at','{{$created_at->format("F d, Y g:ia")}}')
                         ->editColumn('account_name','{{$account_name or "No owner"}}')
                         ->addColumn('view_voucher','<a style="cursor: pointer;" class="view-voucher" voucher-id="{{$voucher_id}}">View Voucher</a>') 
                         ->make(true);
    }

    public function add_code()
    {
        $data['_error'] = null;
        $data['_membership'] = Tbl_membership::where('membership_entry', 1)->where('archived', 0)->get();
        $data['_code_type'] = Tbl_code_type::where('code_type_id', '=' , 1)->get();
        $data['_prod_package'] = Tbl_product_package::where('archived', 0)->get();
        $data['_account'] = Tbl_account::all();
        $data['_inventory_update_type'] = Tbl_inventory_update_type::where('inventory_update_type_id','=',1)->get();
        $data['_error2'] = Session::get('message');

        return view('stockist.membership_code.stockist_membership_code_add', $data);
    }

    public function create_code()
    {
        $request_membership_id = Request::input('membership_id');
        $request_code_type_id = Request::input('code_type_id');
        $request_product_package_id = Request::input('product_package_id');
        $request_account_id = Request::input('account_id');
        $request_code_multiplier = Request::input('code_multiplier');
        $request_inventory_update_type_id = Request::input('inventory_update_type_id');
        $request_order_form_number = Request::input('order_form_number');

        $rules['code_type_id'] = 'required|exists:tbl_code_type,code_type_id';
        $rules['product_package_id'] = 'required|exists:tbl_product_package,product_package_id,membership_id,'.Request::input('membership_id').'|foo:'.Request::input('inventory_update_type_id');
        $rules['inventory_update_type_id'] = 'required|exists:tbl_inventory_update_type,inventory_update_type_id';
        $rules['account_id'] = 'required|exists:tbl_account,account_id';
        $rules['code_multiplier'] = 'min:1|integer';
        $rules['membership_id'] = 'required|exists:tbl_membership,membership_id|check_member';
        $rules['order_form_number'] = 'unique:tbl_membership_code_sale,order_form_number';

        $message['product_package_id.foo'] = "One or more included product might be out of stock".
        $message['product_package_id.check_member'] = "This membership is not for Member entry".


        

        $this->custom_validate();

        $validator = Validator::make(Request::input(),$rules, $message);
        
        if ($validator->fails())
        {
            return redirect()   ->back()
                                ->withErrors($validator)
                                ->withInput();
        }


                $selected_membership = Tbl_membership::find(Request::input('membership_id'));
                $membership_total_amount = 0;

                for ($i=0; $i < 1; $i++)
                {   

                    /**
                    * INSERT TO Tbl_membership_code
                    */
                    $name =DB::table('tbl_stockist_user')->where('stockist_un',Stockist::info()->stockist_un)->first();
                    $membership_code = new Tbl_membership_code(Request::input());
                    
                    $prod = Tbl_stockist_package_inventory::where('product_package_id', Request::input('product_package_id'))->where('stockist_id',Stockist::info()->stockist_id)->first();
                    $updated_stock = $prod->package_quantity - (Integer)Request::input('code_multiplier');
                    if($updated_stock >= 0)
                    {
                         
                    }
                    else
                    {
                        $message = "Cannot update your package stock, amount is higher than your stocks";
                        return Redirect::to('stockist/membership_code/add')->with('message',$message);
                    }
                    
                    $membership_code->code_activation = Globals::create_membership_code();
                    //IF code_type_id IS FREE SLOT / 2 SET PRODUCT PACKAGE TO NULL
                    // if(Request::input('code_type_id')==2 || Request::input('inventory_update_type_id') == 3)
                    if(Request::input('code_type_id')==2)
                    {
                        $membership_code->product_package_id = null;
                    }
                    $membership_code->origin = Stockist::info()->stockist_id;
                    $membership_code->account_id =  Request::input('account_id') ?: null;
                    $membership_code->created_at = Carbon::now();
                    $membership_code->save();

                    /**
                    * INSERT TO Rel_membership_code history
                    */
                    $insert['code_pin'] = $membership_code->code_pin;
                    // $insert['by_account_id'] = $name->account_id;
                    $insert['to_account_id'] = $membership_code->account_id;
                    $insert['updated_at'] = $membership_code->created_at;
                    $insert['description'] = "Created by ".$name->stockist_un;
                    DB::table("tbl_member_code_history")->insert($insert);

                    /**
                     * INSERT TO Rel_membership_code
                     */
                    $insert2['code_pin'] = $membership_code->code_pin;
                    $insert2['product_package_id'] = Request::input('product_package_id');
                    Rel_membership_code::insert($insert2);


                    $membership_total_amount = $membership_total_amount + $selected_membership->membership_price; 
                    $sale[] = $membership_code->code_pin;

                    $container[$i]["amount"]   =  $selected_membership->membership_price;
                    $container[$i]["code_pin"] =  $membership_code->code_pin;

                }



                /**
                 * INSERT TO MEMBERSHIP SALE
                 * 
                 */
                if(Request::input('code_type_id') == 1 )
                {
                    $insert_membership_code_sale['membershipcode_or_code'] = Globals::create_membership_code_sale();

                    $insert_membership_code_sale['sold_to'] = Request::input('account_id');
                    // $insert_membership_code_sale['generated_by'] = Admin::info()->account_id;
                    $insert_membership_code_sale['total_amount'] = $membership_total_amount;
                    $insert_membership_code_sale['payment'] = 1;
                    $insert_membership_code_sale['order_form_number'] = $request_order_form_number;
                    $tbl_membership_code_sale = new Tbl_membership_code_sale($insert_membership_code_sale);
                    $tbl_membership_code_sale->save($insert_membership_code_sale);
                }


                $new_voucher = null;
                //IF "CLAIMABLE" CREATE PRODUCT VOUCHER 
                if(Request::input('inventory_update_type_id') == 1 &&  Request::input('code_type_id') != 2 )
                {
                    $insert_voucher['account_id'] = Request::input('account_id');
                    $insert_voucher['or_number'] = "(MEMBERSHIPCODE PURCHASE) #".$tbl_membership_code_sale->membershipcode_or_num. ' CODE : '.$tbl_membership_code_sale->membershipcode_or_code;
                    $insert_voucher['voucher_code'] = Globals::create_voucher_code();
                    $insert_voucher['status'] = 'unclaimed';
                    $insert_voucher['discount'] = 0;
                    $insert_voucher_membership = Tbl_membership::find(Request::input('membership_id'));
                    $insert_voucher['total_amount']= $insert_voucher_membership->membership_price  * (Integer)Request::input('code_multiplier');
                    $insert_voucher['payment_mode'] = 1;
                    $insert_voucher['processed_by_name'] = Stockist::info()->stockist_un .' ( Stockist )';
                    $insert_voucher['origin'] = Stockist::info()->stockist_id;


                    $insert_voucher['package_id'] = Request::input('product_package_id');
                    $insert_voucher['if_package'] = 1;
                    $insert_voucher['multiplier'] = Request::input('code_multiplier');

                        $prod = Tbl_stockist_package_inventory::where('product_package_id', Request::input('product_package_id'))->where('stockist_id',Stockist::info()->stockist_id)->first();

                
                        $updated_stock = $prod->package_quantity - (Integer)Request::input('code_multiplier');
                        if($updated_stock >= 0)
                        {
                             Tbl_stockist_package_inventory::where('product_package_id',Request::input('product_package_id'))->where('stockist_id',Stockist::info()->stockist_id)->update(['package_quantity' => $updated_stock]);
                        }
                        else
                        {
                            $message = "Cannot update your package stock, amount is higher than your stocks";
                            return Redirect::to('stockist/membership_code/add')->with('message',$message);
                        }
                    // $insert_voucher['admin_id'] = Admin::info()->admin_id;

                    $new_voucher = new Tbl_voucher($insert_voucher);
                    $new_voucher->save();     


                    $member_name = Tbl_account::where('account_id',Request::input('account_id'))->first();            
                    $package_name = Tbl_product_package::where('product_package_id',Request::input('product_package_id'))->first();
                    $amount = $membership_total_amount;
                    $discountp = 0;
                    $discounta = 0;
                    $total = $membership_total_amount;
                    $transaction_by = Stockist::info()->stockist_un;
                    $transaction_to = $member_name->account_name;
                    $transaction_payment_type = "Generated code";
                    $transaction_by_stockist_id = Stockist::info()->stockist_id;
                    $transaction_to_id = $member_name->account_id;
                    $extra = "Product included : ".$package_name->product_package_name;

                    $trans_id = StockistLog::transaction("Membership Code",$amount,$discountp,$discounta,$total,$paid = 0,$claimed = 0,$transaction_by,$transaction_to,$transaction_payment_type,$transaction_by_stockist_id,$transaction_to_id,$extra,$new_voucher->voucher_id);
                    
                    foreach($container as $key => $con)
                    {
                        $product_id = NULL;
                        $product_package_id = NULL;
                        $code_pin = 1;
                        $transaction_amount = $container[$key]["amount"];
                        $transaction_qty = 1;
                        $transaction_total =  $container[$key]["amount"];
                        $log = "Code generated";
                        $code_pin = $container[$key]["code_pin"];

                        StockistLog::relative($trans_id,$if_product=0,$if_product_package = 0,$if_code_pin = 1,$product_id,$product_package_id,$code_pin,$transaction_amount,$log,$transaction_qty,$transaction_total);                       
                    }


                    $prod = Tbl_product_package_has::where('product_package_id', Request::input('product_package_id'))->get();
                    foreach ($prod as $key => $value)
                    {
                        $prodpack = Tbl_product::find($value->product_id);
                        $insert_voucher_item['voucher_id'] = $new_voucher->voucher_id;
                        $insert_voucher_item['product_id'] = $value->product_id;
                        $insert_voucher_item['price'] = 0;
                        $insert_voucher_item['sub_total'] = 0;
                        $insert_voucher_item['unilevel_pts'] = $prodpack->unilevel_pts * (Integer)Request::input('code_multiplier');
                        $insert_voucher_item['binary_pts'] = $prodpack->binary_pts * (Integer)Request::input('code_multiplier');
                        $insert_voucher_item['qty'] = $value->quantity * (Integer)Request::input('code_multiplier');
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
                



                // // "Deduct Right Away" DEDUCT THE PRODUCT INVENTORY
                // if(Request::input('inventory_update_type_id') == 2 && Request::input('code_type_id') != 2 )
                // {
                //     $prod = Tbl_stockist_package_inventory::where('product_package_id', Request::input('product_package_id'))->where('stockist_id',Stockist::info()->stockist_id)->first();

                
                //         $updated_stock = $prod->package_quantity - (Integer)Request::input('code_multiplier');
                //         if($updated_stock >= 0)
                //         {
                //              Tbl_stockist_package_inventory::where('product_package_id',Request::input('product_package_id'))->where('stockist_id',Stockist::info()->stockist_id)->update(['package_quantity' => $updated_stock]);
                //         }
                //         else
                //         {
                //             $message = "Cannot update your package stock, amount is higher than your stocks";
                //             return Redirect::to('stockist/membership_code/add')->with('message',$message);
                //         }

                    
                // }


                /**
                 * INSERT TO MEMBERSHIP SALE PRODUCT
                 * IF CODE TYPE IS NOT FREE SLOT
                 */
                if(Request::input('code_type_id') == 1 )
                {
                    foreach ( (array)$sale as $key => $value)
                    {
                        $insert_membership_code_sale_has_code['code_pin'] = $value;
                        $insert_membership_code_sale_has_code['sold_price'] = Tbl_membership::find(Request::input('membership_id'))->membership_price;
                        $insert_membership_code_sale_has_code['membershipcode_or_num'] = $tbl_membership_code_sale->membershipcode_or_num;
                        $tbl_membership_code_sale_has_code = new Tbl_membership_code_sale_has_code($insert_membership_code_sale_has_code);
                        $tbl_membership_code_sale_has_code->save();
                    }
                }


                $sold_to = Tbl_account::find(Request::input('account_id'));
                $account_name = $sold_to->account_name . " (".$sold_to->account_username.')';
                $log = "Sold membership_code to " .$account_name. 'as '. Stockist::info()->stockist_un .' with membership sale OR#'.$tbl_membership_code_sale->membershipcode_or_num . '.';
                Log::stockist(Stockist::info()->stockist_id,Stockist::info()->stockist_user_id, $log);
                return Redirect('stockist/membership_code/or?membershipcode_or_num='.$tbl_membership_code_sale->membershipcode_or_num);
    
    }


    public function custom_validate()
    {
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
            $prod = Tbl_stockist_package_inventory::where('product_package_id', $value )->where('stockist_id',Stockist::info()->stockist_id)->first();

            //IF inventory_update_type_id VALUE IS "DEDUCT RIGHT AWAY / 2" CHECK FOR INVENTORY
            if($parameters[0] == 2)
            {
                    if($prod->package_quantity > 0)
                    {
                        return true;
                    }

                    else
                    {
                        return false;
                    }   
            }
            else
            {
                return true;
            }                   
        });
    }


    public function load_product_package()
    {


        $prodpack = Tbl_product_package::where('membership_id', Request::input('membership_id'))->where("archived",0)->get();

        return $prodpack;


    }

    public function show_sale_or()
    {


        // dd();

        $or_num = Request::input('membershipcode_or_num');



        $membership_code_sale = Tbl_membership_code_sale::find($or_num);
        // $generated_by = Tbl_account::find($membership_code_sale->generated_by);
        // $membership_code_sale->generated_by = $generated_by->account_name . " (".  $generated_by->account_username.")";
        $sold_to = Tbl_account::find($membership_code_sale->sold_to);
        $membership_code_sale->sold_to = $sold_to->account_name;
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


        return view('stockist.membership_code.sale_or', $data);
    }



}
