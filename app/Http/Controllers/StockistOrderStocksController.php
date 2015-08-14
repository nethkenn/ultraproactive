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
}
