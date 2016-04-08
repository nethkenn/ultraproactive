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
use App\Classes\StockistLog;
use App\Tbl_product_package_has;
class StockistIssueController extends StockistController
{
    public function index()
    {
        $id = Stockist::info()->stockist_id;
        $data['_error'] = Session::get('message');
        $data['_success'] = Session::get('success');
        if(isset($_POST['username']))
        {
            return Redirect::to('stockist/issue_stocks/issue?username='.$_POST['username']);
        }
        return view('stockist.issue.issue_stockist',$data);
    }

    public function issue()
    {
        $user = Request::input('username');
        $owner = Tbl_stockist::where('stockist_id',Stockist::info()->stockist_id)->join('tbl_stockist_type','stockist_type','=','stockist_type_id')->first();
        $user = Tbl_stockist_user::where('tbl_stockist_user.stockist_un',$user)->stockist()->join('tbl_stockist_type','stockist_type','=','stockist_type_id')->first();
        if($user)
        {

            if($owner->stockist_type_discount > $user->stockist_type_discount)
            {
                        $id = $owner->stockist_id;
                        $data['error'] = null;  
                        $data["success"] = null;
                        $data['id'] = $id;
                        $data['product'] = $owner->stockist_type_discount;
                        $data['pack'] = $owner->stockist_type_package_discount;
                        $status = false;
                        $status2 = false;
                        CheckStockist::checkinventory($user->stockist_id);
                        CheckStockist::checkinventory($owner->stockist_id);
                        CheckStockist::checkpackage($user->stockist_id);
                        CheckStockist::checkpackage($owner->stockist_id);


                        $data["stockist"] = Tbl_stockist::where('tbl_stockist.stockist_id',$id)->join('tbl_stockist_type','tbl_stockist_type.stockist_type_id','=','tbl_stockist.stockist_type')                                                                
                                                                                         ->first();
                        $data['inventory'] = Tbl_stockist_inventory::where('stockist_id',$id)
                                                                    ->orderBy('tbl_stockist_inventory.product_id','asc')
                                                                    ->where('tbl_stockist_inventory.archived',0)
                                                                    ->where('tbl_product.archived',0)
                                                                    ->join('tbl_product','tbl_product.product_id','=','tbl_stockist_inventory.product_id')
                                                                    ->get();

                         $total  = null;
                         if(Request::input('quantity'))
                         {

                                $ctr = 0;       
                                $overall = 0;
                                $overallpercent = 0;
                                $overallwithout = 0;
                                
                                foreach($_POST['quantity'] as $key => $value)
                                {

                                    $own = Tbl_stockist_inventory::where('stockist_id',$id)->where('product_id',$key)->first();
                                    $recipient = Tbl_stockist_inventory::where('stockist_id',$user->stockist_id)->where('product_id',$key)->first();
                                    $updateown['stockist_quantity'] = $own->stockist_quantity - $value;
                                    $prodname = Tbl_product::where('product_id',$key)->first();
                                    $updaterecipient['stockist_quantity'] = $recipient->stockist_quantity + $value;    

                                    $product = Tbl_stockist_inventory::where('stockist_id',$id)
                                                                                ->orderBy('tbl_stockist_inventory.product_id','asc')
                                                                                ->where('tbl_stockist_inventory.archived',0)
                                                                                ->join('tbl_product','tbl_product.product_id','=','tbl_stockist_inventory.product_id')
                                                                                ->get();


                                    if($updateown['stockist_quantity'] >= 0)
                                    {
                                        if($value >= 0)
                                        {
                                            $status = true;
                                            Tbl_stockist_inventory::where('stockist_id',$id)->where('product_id',$key)->update($updateown);
                                            Tbl_stockist_inventory::where('stockist_id',$user->stockist_id)->where('product_id',$key)->update($updaterecipient);
                                            
                                            $overall = $overall + $prodname->price - (($data['product']/100)*$prodname->price);
                                            $overall = $overall * $value;

                                            $overallpercent = $data['product'];
                                            $overallwithout = $overallwithout + $prodname->price * $value;
                                            $total[$key]['sub'] = $prodname->price - (($data['product']/100)*$prodname->price);
                                            $total[$key]['id'] = $prodname->product_id;
                                            $total[$key]['qty'] = $value;
                                            $total[$key]['total'] = $total[$key]['sub'] * $value;
                                        }
                                        else
                                        {
                                            $data['error'][$ctr] = "Product ".$prodname->product_name." didn't issue, cannot give quantity that is negative.";
                                            $ctr++;
                                        }                                        
                                    }
                                    else
                                    {
                                            $data['error'][$ctr] = "Product ".$prodname->product_name." didn't issue, cannot give quantity that is higher than your stocks.";
                                            $ctr++;
                                    }

                                }

                                $process = "ISSUE STOCK";
                                $amount = $overallwithout;
                                $discountp = $data['product'];
                                $discounta = $overallpercent;
                                $totality = $overall;
                                $paid = 0;
                                $claimed = 0;
                                $transaction_by = Stockist::info()->stockist_un;
                                $transaction_to = Request::input('username');
                                $transaction_payment_type = "ISSUE STOCK";
                                $transaction_by_stockist_id = Stockist::info()->stockist_id;
                                $transaction_to_id = $user->stockist_id;
                                $extra = "ISSUED";
                                $voucher = NULL;

                                $trans_id = StockistLog::transaction($process,$amount,$discountp,$discounta,$totality,$paid = 0,$claimed = 0,$transaction_by,$transaction_to,$transaction_payment_type,$transaction_by_stockist_id,null,$extra,$voucher,$transaction_to_id);
                               if(isset($total))
                               {
                                    foreach($total as $key => $t)
                                    {
                                        $product_id = $total[$key]['id']; 
                                        $product_package_id = NULL;
                                        $code_pin = NULL;
                                        $transaction_amount = $total[$key]['sub'];
                                        $log = "Product Issued";
                                        $transaction_qty  = $total[$key]['qty'];
                                        $transaction_total = $total[$key]['total'];
                                        StockistLog::relative($trans_id,$if_product=1,$if_product_package = 0,$if_code_pin = 0,$product_id,$product_package_id,$code_pin,$transaction_amount,$log,$transaction_qty,$transaction_total);
                                    }                                
                               }


                         }  
                         else
                         {
                             $status = true;
                         }           
                         $total  = null;
                         if(Request::input('quantitypack'))
                         {

                                $ctr = 0;       
                                $overall = 0;
                                $overallpercent = 0;
                                $overallwithout = 0;


                                foreach($_POST['quantitypack'] as $key => $value)
                                {
                                    $own = Tbl_stockist_package_inventory::where('stockist_id',$id)->where('product_package_id',$key)->first();
                                    $recipient = Tbl_stockist_package_inventory::where('stockist_id',$user->stockist_id)->where('product_package_id',$key)->first();
                                    $package_name = Tbl_product_package::where('product_package_id',$key)->first();
                                    $updateowner['package_quantity'] = $own->package_quantity - $value;
                                    $updaterecipients['package_quantity'] = $recipient->package_quantity + $value;   



                                    if($updateowner['package_quantity'] >= 0)
                                    {
                                        if($value >= 0)
                                        {
                                            $status2 = true;
                                            Tbl_stockist_package_inventory::where('stockist_id',$id)->where('product_package_id',$key)->update($updateowner);
                                            Tbl_stockist_package_inventory::where('stockist_id',$user->stockist_id)->where('product_package_id',$key)->update($updaterecipients);
                                       
                                            $get = Tbl_product_package_has::where('product_package_id',$package_name->product_package_id)->product()->get();
                                            
                                            $package_price = 0;

                                            foreach($get as  $g)
                                            {
                                                $package_price = $package_price + $g->price;
                                            }

                                            $overall = $overall + $package_price - (($data['pack']/100)*$package_price);
                                            $overall = $overall * $value;

                                            $overallpercent = $data['pack'];
                                            $overallwithout = $overallwithout + $package_price * $value;
                                            $total[$key]['sub'] = $package_price - (($data['pack']/100)*$package_price);
                                            $total[$key]['id'] = $key;
                                            $total[$key]['qty'] = $value;
                                            $total[$key]['total'] = $total[$key]['sub'] * $value;

                                        }
                                        else
                                        {
                                            $data['error'][$ctr] = $package_name->product_package_name." didn't issue, cannot give quantity that is negative.";
                                            $ctr++;
                                        }
                                    }
                                    else
                                    {
                                            $data['error'][$ctr] = $package_name->product_package_name." didn't issue, cannot give quantity that is higher than your stocks.";
                                            $ctr++;          
                                    }

                                }


                                $process = "ISSUE STOCK";
                                $amount = $overallwithout;
                                $discountp = $data['pack'];
                                $discounta = $overallpercent;
                                $totality = $overall;
                                $paid = 0;
                                $claimed = 0;
                                $transaction_by = Stockist::info()->stockist_un;
                                $transaction_to = Request::input('username');
                                $transaction_payment_type = "ISSUE STOCK";
                                $transaction_by_stockist_id = Stockist::info()->stockist_id;
                                $transaction_to_id = $user->stockist_id;
                                $extra = "ISSUED";
                                $voucher = NULL;

                                $transpack_id = StockistLog::transaction($process,$amount,$discountp,$discounta,$totality,$paid = 0,$claimed = 0,$transaction_by,$transaction_to,$transaction_payment_type,$transaction_by_stockist_id,$transaction_to_id,$extra,$voucher);
                               if(isset($total))
                               {
                                    foreach($total as $key => $t)
                                    {
                                        $product_id = NULL; 
                                        $product_package_id = $total[$key]['id'];
                                        $code_pin = NULL;
                                        $transaction_amount = $total[$key]['sub'];
                                        $log = "Product Issued";
                                        $transaction_qty  = $total[$key]['qty'];
                                        $transaction_total = $total[$key]['total'];
                                        StockistLog::relative($transpack_id,$if_product=0,$if_product_package = 1,$if_code_pin = 0,$product_id,$product_package_id,$code_pin,$transaction_amount,$log,$transaction_qty,$transaction_total);
                                    }                                
                               }

                         }
                         else
                         {
                             $status2 = true;
                         }
                             
                        if(Request::input('quantity') || Request::input('quantitypack'))
                        {
                            if($status == true && $status2 == true)
                            {
                                $data['success'][0] = "Successfully issued without any problem.";
                            }  
                        }

                        return view('stockist.issue.issue_stockist_user', $data);                                              
            }
            else
            {
                return Redirect::to('stockist/issue_stocks')->with('message','Your rank should be higher than the target stockist. This stockist is a '.$user->stockist_type_name.'.');
            }
        }
        else
        {
            return Redirect::to('stockist/issue_stocks')->with('message','Username not found');
        }
    }

    public function ajax_get_product()
    {
        $id = Request::input('id');
        $discount = Request::input('product');
        if($discount)
        {
            $product = Tbl_stockist_inventory::where('stockist_id',$id)
                                                        ->orderBy('tbl_stockist_inventory.product_id','asc')
                                                        ->where('tbl_stockist_inventory.archived',0)
                                                        ->where('tbl_product.archived',0)
                                                        ->join('tbl_product','tbl_product.product_id','=','tbl_stockist_inventory.product_id')
                                                        ->get();
            foreach($product as $key => $prod)
            {
                $product[$key]["total"] = $prod->price - (($discount/100)*$prod->price);
            }                                           
            return Datatables::of($product) ->addColumn('add','<a class="add-to-package" href="#" product-id="{{$product_id}}">ADD</a>')
                                            ->addColumn('percent',"$discount%")
                                            ->make(true);            
        }
        else
        {
            $product = Tbl_stockist_inventory::where('stockist_id',$id)
                                                        ->orderBy('tbl_stockist_inventory.product_id','asc')
                                                        ->where('tbl_stockist_inventory.archived',0)
                                                        ->where('tbl_product.archived',0)
                                                        ->join('tbl_product','tbl_product.product_id','=','tbl_stockist_inventory.product_id')
                                                        ->get();
            foreach($product as $key => $prod)
            {
                $product[$key]["total"] = $prod->price;
            }                                           
            return Datatables::of($product) ->addColumn('add','<a class="add-to-package" href="#" product-id="{{$product_id}}">ADD</a>')
                                            ->addColumn('percent',"No Discount")
                                            ->make(true);   
         }

    }

    public function ajax_get_product_package()
    {
        $id = Request::input('id');
        $discount = Request::input('package');

        if($discount)
        {
            $product = Tbl_stockist_package_inventory::where('stockist_id',$id)
                                                        ->where('tbl_product_package.archived',0)
                                                        ->join('tbl_product_package','tbl_product_package.product_package_id','=','tbl_stockist_package_inventory.product_package_id')
                                                        ->get();

            foreach($product as $key => $prod)
            {
                $total = 0;
                $get = Tbl_product_package_has::where('product_package_id',$prod->product_package_id)->product()->get();

                foreach($get as  $g)
                {
                    $total = $total + ($g->price * $g->quantity);
                }
                $product[$key]["price"] = $total;
                $product[$key]["total"] = $total - (($discount/100)*$prod->price);
            }          

            return Datatables::of($product) ->addColumn('add','<a class="add-to-package-pack" href="#" product-id="{{$product_package_id}}">ADD</a>')
                                            ->addColumn('percent',"$discount%")
                                            ->make(true);            
        }
        else
        {
            $product = Tbl_stockist_package_inventory::where('stockist_id',$id)
                                            ->where('tbl_product_package.archived',0)
                                            ->join('tbl_product_package','tbl_product_package.product_package_id','=','tbl_stockist_package_inventory.product_package_id')
                                            ->get();
            foreach($product as $key => $prod)
            {
                $total = 0;
                $get = Tbl_product_package_has::where('product_package_id',$prod->product_package_id)->product()->get();

                foreach($get as  $g)
                {
                    $total = $total + ($g->price * $g->quantity);
                }

                $product[$key]["price"] = $total;
                $product[$key]["total"] = $total;

            }          

            return Datatables::of($product) ->addColumn('add','<a class="add-to-package-pack" href="#" product-id="{{$product_package_id}}">ADD</a>')
                                            ->addColumn('percent',"No Discount")
                                            ->make(true);
        }

    }
}
