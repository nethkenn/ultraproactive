<?php namespace App\Http\Controllers;
use Request;
use DB;
use App\Classes\Stockist;
use Redirect;
use Session;
use gapi;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tbl_stockist_user;
use App\Tbl_stockist;
use App\Classes\CheckStockist;
use App\Tbl_stockist_inventory;
use App\Tbl_stockist_package_inventory;
use Datatables;
use App\Tbl_product_package;
use App\Tbl_product;
use App\Tbl_order_stocks;
use Carbon\Carbon;
use App\Rel_order_stocks;
use App\Rel_order_stocks_package;

class StockistOrderStocksController extends StockistController
{
    public function index()
    {
        $id = Stockist::info()->stockist_id;
        $status = Request::input('status');
        if($status == "")
        {
            $status = "Pending";
        }
        $data['success'] = Session::get('message');
        $data['_order'] = Tbl_order_stocks::where('tbl_order_stocks.stockist_id',$id)->where('status',$status)->join('tbl_stockist_user','tbl_stockist_user.stockist_user_id','=','tbl_order_stocks.stockist_user_id')
                                                                    ->get();
        return view('stockist.order.order_stocks',$data);
    }


    public function order()
    {
                    $owner = Tbl_stockist::where('stockist_id',Stockist::info()->stockist_id)->join('tbl_stockist_type','stockist_type','=','stockist_type_id')->first();

                                    $id = $owner->stockist_id;
                                    $data['error'] = null;  
                                    $data['id'] = $id;

                                    $data["stockist"] = Tbl_stockist::where('tbl_stockist.stockist_id',$id)->join('tbl_stockist_type','tbl_stockist_type.stockist_type_id','=','tbl_stockist.stockist_type')                                                                
                                                                                                     ->first();
                                    $data['inventory'] = Tbl_stockist_inventory::where('stockist_id',$id)
                                                                                ->orderBy('tbl_stockist_inventory.product_id','asc')
                                                                                ->where('tbl_stockist_inventory.archived',0)
                                                                                ->join('tbl_product','tbl_product.product_id','=','tbl_stockist_inventory.product_id')
                                                                                ->get();

                                     $ctr = 0;       
                                     if(Request::input('quantity') || Request::input('quantitypack'))
                                     {
                                        $insert['stockist_id'] = Stockist::info()->stockist_id;
                                        $insert['stockist_user_id'] = Stockist::info()->stockist_user_id;
                                        $insert['confirmed'] = 0;
                                        $insert['paid'] = 0;
                                        $insert['created_at'] = Carbon::now();

                                        $order_id = Tbl_order_stocks::insertGetId($insert);
                                     }  

                                     if(Request::input('quantity'))
                                     {
                                            foreach($_POST['quantity'] as $key => $value)
                                            {
                                                $insert_product['quantity'] = $value;
                                                $insert_product['product_id'] = $key;
                                                $insert_product['order_stocks_id'] = $order_id;
                                                Rel_order_stocks::insert($insert_product);
                                            }
                                     }             

                                     if(Request::input('quantitypack'))
                                     {
                                            foreach($_POST['quantitypack'] as $key => $value)
                                            {
                                                $insert_product_package['quantity'] = $value;
                                                $insert_product_package['product_package_id'] = $key;
                                                $insert_product_package['order_stocks_id'] = $order_id;
                                                Rel_order_stocks_package::insert($insert_product_package);
                                            }
                                     }   

                                     if(Request::input('quantity') || Request::input('quantitypack'))
                                     {
                                       return Redirect::to('stockist/order_stocks')->with('message','Successfully request an order.');
                                     }  
                             

                                    return view('stockist.order.order_stocks_user', $data);                                              
    }


    public function ajax_get()
    {
        $id = Request::input('id');                          
        $data['product'] = Rel_order_stocks::where('order_stocks_id',$id)->join('tbl_product','tbl_product.product_id','=','rel_order_stocks.product_id')->select('product_name','quantity','tbl_product.product_id')->get();
        $data['package'] = Rel_order_stocks_package::where('order_stocks_id',$id)->join('tbl_product_package','tbl_product_package.product_package_id','=','rel_order_stocks_package.product_package_id')->select('product_package_name','quantity','tbl_product_package.product_package_id')->get();

        return json_encode($data);
    }


    public function check_rank()
    {
        $id = Stockist::info()->stockist_id;
        $data['_error'] = Session::get('message');
        $data['_success'] = Session::get('success');
        if(isset($_POST['request']))
        {
            return Redirect::to('stockist/accept_stocks/accept?request='.$_POST['request']);
        }
        return view('stockist.order.accept_order',$data);  
    }

    public function accept()
    {
        $request = Request::input('request');
        $id = Stockist::info()->stockist_id;
        $sender = Tbl_order_stocks::where('order_stocks_id',$request)->join('tbl_stockist','tbl_stockist.stockist_id','=','tbl_order_stocks.stockist_id')
                                                                     ->join('tbl_stockist_type','tbl_stockist_type.stockist_type_id','=','tbl_stockist.stockist_type')
                                                                     ->first();
        $receiver = Tbl_stockist::where('stockist_id',Stockist::info()->stockist_id)->join('tbl_stockist_type','stockist_type_id','=','stockist_type')->first();
        $data['error'] = null;
        if($sender)
        {       
                $product = Rel_order_stocks::where('order_stocks_id',$request)->get();
                $package = Rel_order_stocks_package::where('order_stocks_id',$request)->get();
                // $data['error'][$ctr] = $package_name->product_package_name." didn't refill, cannot give quantity that is higher than your stocks.";
                // $ctr++;

                $data['product'] = Rel_order_stocks::where('order_stocks_id',$request)->join('tbl_product','tbl_product.product_id','=','rel_order_stocks.product_id')->select('product_name','quantity','tbl_product.product_id')->get();
                $data['package'] = Rel_order_stocks_package::where('order_stocks_id',$request)->join('tbl_product_package','tbl_product_package.product_package_id','=','rel_order_stocks_package.product_package_id')->select('product_package_name','quantity','tbl_product_package.product_package_id')->get();


                if($sender->stockist_type_discount > $receiver->stockist_type_discount)
                {
                            if($sender->status != "Pending")
                            {
                                 return Redirect::to('stockist/accept_stocks')->with('message','This request is already completed.');     
                            }

                            if(isset($_POST['_token']))
                            {   
                                $condition = true;
                                foreach($product as $key => $get)
                                {
                                    $sender_count = Tbl_stockist_inventory::where('stockist_id',$sender->stockist_id)->where('product_id',$get->product_id)->first();
                                    $receiver_count = Tbl_stockist_inventory::where('stockist_id',$id)->where('product_id',$get->product_id)->first();

                                    $sender_total = $sender_count->stockist_quantity + $get->quantity;
                                    $receiver_total = $receiver_count->stockist_quantity - $get->quantity;

                                    if($receiver_total < 0)
                                    {
                                        $condition = false;
                                    } 
                                }   

                                foreach($package as $key => $get)
                                {
                                    $sender_count = Tbl_stockist_package_inventory::where('stockist_id',$sender->stockist_id)->where('product_package_id',$get->product_package_id)->first();
                                    $receiver_count = Tbl_stockist_package_inventory::where('stockist_id',$id)->where('product_package_id',$get->product_package_id)->first();
                                    $sender_total = $sender_count->package_quantity + $get->quantity;
                                    $receiver_total = $receiver_count->package_quantity - $get->quantity;

                                    if($receiver_total < 0)
                                    {

                                        $condition = false;
                                    } 
                                }    


                                if($condition == true)
                                {
                                    foreach($product as $key => $get)
                                    {
                                        $sender_count = Tbl_stockist_inventory::where('stockist_id',$sender->stockist_id)->where('product_id',$get->product_id)->first();
                                        $receiver_count = Tbl_stockist_inventory::where('stockist_id',$id)->where('product_id',$get->product_id)->first();

                                        $update_sender['stockist_quantity'] = $sender_count->stockist_quantity + $get->quantity;
                                        $update_receiver['stockist_quantity']= $receiver_count->stockist_quantity - $get->quantity;
                                    
                                        Tbl_stockist_inventory::where('stockist_id',$sender->stockist_id)->where('product_id',$get->product_id)->update($update_sender);
                                        Tbl_stockist_inventory::where('stockist_id',$id)->where('product_id',$get->product_id)->update($update_receiver);
                                    }   

                                    foreach($package as $key => $get)
                                    {
                                        $sender_count = Tbl_stockist_package_inventory::where('stockist_id',$sender->stockist_id)->where('product_package_id',$get->product_package_id)->first();
                                        $receiver_count = Tbl_stockist_package_inventory::where('stockist_id',$id)->where('product_package_id',$get->product_package_id)->first();

                                        $update_sender2['package_quantity'] = $sender_count->package_quantity + $get->quantity;
                                        $update_receiver2['package_quantity'] = $receiver_count->package_quantity - $get->quantity;

                                        Tbl_stockist_package_inventory::where('stockist_id',$sender->stockist_id)->where('product_package_id',$get->product_package_id)->update($update_sender2);
                                        Tbl_stockist_package_inventory::where('stockist_id',$id)->where('product_package_id',$get->product_package_id)->update($update_receiver2);
                                    } 

                                    Tbl_order_stocks::where('order_stocks_id',$id)->update(['status'=>"Confirm"]);
                                    return Redirect::to('stockist/accept_stocks')->with('success','Requested orders are successfully given.');      
                                }
                                else
                                {
                                    $data['error'][0] = "One of your stocks quantity is not enough to refill this request";
                                }                           
                            }

                    return view('stockist.order.accept_order_user',$data);                                           
                }
                else
                {
                     return Redirect::to('stockist/accept_stocks')->with('message','Cannot accept this request due to your rank.');     
                }

        }
        else
        {
             return Redirect::to('stockist/accept_stocks')->with('message','Invalid request ID');           
        }


    }

}
