<?php namespace App\Http\Controllers;
use App\Tbl_product;
use DB;
use Request;
use Redirect;
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
	        }	
    }

    public function singlecompute($ings,$amt,$opt)
    {
        if($opt == 1)
        {
            $two = DB::table('tbl_product')->where('product_id',$ings)->first();
            $amount =  $two->stock_qty - ($amt);
            DB::table('tbl_product')->where('product_id',$ings)->update(['stock_qty'=>$amount]);
        }
        else if($opt == 2)
        {
            $two = DB::table('tbl_product')->where('product_id',$ings)->first();
            $amount =  $amt;
            DB::table('tbl_product')->where('product_id',$ings)->update(['stock_qty'=>$amount]);
        }
        else
        {
            $two = DB::table('tbl_product')->where('product_id',$ings)->first();
            $amount =   $two->stock_qty + ($amt);
            DB::table('tbl_product')->where('product_id',$ings)->update(['stock_qty'=>$amount]);
        }
    }

}