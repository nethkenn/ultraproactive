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
class StockistIssueController extends StockistController
{
    public function index()
    {
        $id = Stockist::info()->stockist_id;
        $data['_error'] = Session::get('message');

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
        $user = Tbl_stockist_user::where('stockist_un',$user)->stockist()->join('tbl_stockist_type','stockist_type','=','stockist_type_id')->first();
        if($user)
        {
            if($owner->stockist_type_id < $user->stockist_type_id)
            {
                        $id = $owner->stockist_id;
                        $data['error'] = null;  
                        $data['id'] = $id;


                        CheckStockist::checkinventory($user->stockist_id);
                        CheckStockist::checkinventory($owner->stockist_id);
                        CheckStockist::checkpackage($user->stockist_id);
                        CheckStockist::checkpackage($owner->stockist_id);


                        $data["stockist"] = Tbl_stockist::where('tbl_stockist.stockist_id',$id)->join('tbl_stockist_type','tbl_stockist_type.stockist_type_id','=','tbl_stockist.stockist_type')                                                                
                                                                                         ->first();
                        $data['inventory'] = Tbl_stockist_inventory::where('stockist_id',$id)
                                                                    ->orderBy('tbl_stockist_inventory.product_id','asc')
                                                                    ->where('tbl_stockist_inventory.archived',0)
                                                                    ->join('tbl_product','tbl_product.product_id','=','tbl_stockist_inventory.product_id')
                                                                    ->get();

                         $ctr = 0;       
                                                              
                         if(Request::input('quantity'))
                         {
                                foreach($_POST['quantity'] as $key => $value)
                                {

                                    $own = Tbl_stockist_inventory::where('stockist_id',$id)->where('product_id',$key)->first();
                                    $recipient = Tbl_stockist_inventory::where('stockist_id',$user->stockist_id)->where('product_id',$key)->first();
                                    $updateown['stockist_quantity'] = $own->stockist_quantity - $value;
                                    $prodname = Tbl_product::where('product_id',$key)->first();
                                    $updaterecipient['stockist_quantity'] = $recipient->stockist_quantity + $value;    

                                    if($updateown['stockist_quantity'] >= 0)
                                    {
                                        if($value >= 0)
                                        {
                                            Tbl_stockist_inventory::where('stockist_id',$id)->where('product_id',$key)->update($updateown);
                                            Tbl_stockist_inventory::where('stockist_id',$user->stockist_id)->where('product_id',$key)->update($updaterecipient);
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
                         }             

                         if(Request::input('quantitypack'))
                         {
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
                                            Tbl_stockist_package_inventory::where('stockist_id',$id)->where('product_package_id',$key)->update($updateowner);
                                            Tbl_stockist_package_inventory::where('stockist_id',$user->stockist_id)->where('product_package_id',$key)->update($updaterecipients);
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

        $product = Tbl_stockist_inventory::where('stockist_id',$id)
                                                    ->orderBy('tbl_stockist_inventory.product_id','asc')
                                                    ->where('tbl_stockist_inventory.archived',0)
                                                    ->join('tbl_product','tbl_product.product_id','=','tbl_stockist_inventory.product_id')
                                                    ->get();
        return Datatables::of($product) ->addColumn('add','<a class="add-to-package" href="#" product-id="{{$product_id}}">ADD</a>')
                                        ->make(true);
    }

    public function ajax_get_product_package()
    {
        $id = Request::input('id');

        $product = Tbl_stockist_package_inventory::where('stockist_id',$id)
                                                    ->join('tbl_product_package','tbl_product_package.product_package_id','=','tbl_stockist_package_inventory.product_package_id')
                                                    ->get();

        return Datatables::of($product) ->addColumn('add','<a class="add-to-package-pack" href="#" product-id="{{$product_package_id}}">ADD</a>')
                                        ->make(true);
    }
}
