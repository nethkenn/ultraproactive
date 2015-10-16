<?php namespace App\Http\Controllers;
use App\Tbl_product;
use DB;
use Request;
use Redirect;
use App\Classes\Log;
use App\Classes\Admin;
class AdminInventoryController extends AdminController
{
	public function index()
	{
	    $_product = DB::table("tbl_product")   ->where('archived',0)
                                               ->get();
                                                         
        $data["_inventory"] = $_product;                                   

        if(isset($_POST['addfood']))
        {
            
         $insert = $this->getdata(Request::input('ingrid'),Request::input('amt'));

         

         return Redirect::to('admin/maintenance/inventory'); 
        }
        else
        {
            Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits Inventory");
        }

        if(isset($_POST['singleadd']))
        {    
        	if(Request::input('ingrid') != "")
        	{
       		   $this->singlecompute(Request::input('ingrid'),Request::input('singleamount'),Request::input('option'));        		
        	}
          return Redirect::to('admin/maintenance/inventory'); 
        }
		return view('admin.maintenance.inventory', $data);
	}

    public function getdata($ings,$amt)
    {
    	if($ings)
    	{
	        $ctr = 0;
	        foreach( $ings as $ing)
	        {
	          $insert[$ctr]['ing'] = $ing;
	          $ctr++;
	        } 
	        $ctr = 0;
	        foreach($amt as $ing)
	        {
	          $insert[$ctr]['amount'] = $ing;
	          $ctr++;        
	        }
	        $ctr = 0;
	        $this->compute($insert);
	        return $insert;
    	}

    } 

    public function compute($insert)
    {
	        foreach($insert as $key => $inserts)
	        {  
	            $two = DB::table('tbl_product')->where('product_id',$inserts['ing'])->first();

	            $amount = $inserts['amount'] + $two->stock_qty;

	            DB::table('tbl_product')->where('product_id',$inserts['ing'])->update(['stock_qty'=>$amount]);

                $new = DB::table('tbl_product')->where('product_id',$inserts['ing'])->first();
                Log::Admin(Admin::info()->account_id,Admin::info()->account_username." add an amount of ".$inserts['amount']." to product id #".$inserts['ing'],serialize($two),serialize($new));
	      
                 $log = Admin::info()->account_username." add an amount of ".$inserts['amount']." to product id #".$inserts['ing'];
                 Log::inventory_log(Admin::info()->account_id,$inserts['ing'],$inserts['amount'],$log,0,0);
            }	
    }

    public function singlecompute($ings,$amt,$opt)
    {
        $old = DB::table('tbl_product')->where('product_id',$ings)->first();
        if($opt == 1)
        {
            $two = DB::table('tbl_product')->where('product_id',$ings)->first();
            $amount =  $two->stock_qty - ($amt);
            DB::table('tbl_product')->where('product_id',$ings)->update(['stock_qty'=>$amount]);
            $new = DB::table('tbl_product')->where('product_id',$ings)->first();
            Log::Admin(Admin::info()->account_id,Admin::info()->account_username." consume the amount of product id #".$ings." by ".$amt,serialize($old),serialize($new));
            $log = Admin::info()->account_username." consume the amount of product id #".$ings." by ".$amt;
            Log::inventory_log(Admin::info()->account_id,$ings,0-$amt,$log,0,0);
        }
        else if($opt == 2)
        {
            $two = DB::table('tbl_product')->where('product_id',$ings)->first();
            $amount =  $amt;
            DB::table('tbl_product')->where('product_id',$ings)->update(['stock_qty'=>$amount]);
            $new = DB::table('tbl_product')->where('product_id',$ings)->first();
            Log::Admin(Admin::info()->account_id,Admin::info()->account_username." change the amount of product id #".$ings." to ".$amt,serialize($old),serialize($new));
           
            $log = Admin::info()->account_username." change the amount of product id #".$ings." to ".$amt;
            Log::inventory_log(Admin::info()->account_id,$ings,$amt - $two->stock_qty,$log,0,0);
        }
        else
        {
            $two = DB::table('tbl_product')->where('product_id',$ings)->first();
            $amount =   $two->stock_qty + ($amt);
            DB::table('tbl_product')->where('product_id',$ings)->update(['stock_qty'=>$amount]);
            $new = DB::table('tbl_product')->where('product_id',$ings)->first();
            Log::Admin(Admin::info()->account_id,Admin::info()->account_username." add the amount of product id #".$ings." by ".$amt,serialize($old),serialize($new));
            
            $log = Admin::info()->account_username." add the amount of product id #".$ings." by ".$amt;
            Log::inventory_log(Admin::info()->account_id,$ings,$amt,$log,0,0);
        }

        
    }

}