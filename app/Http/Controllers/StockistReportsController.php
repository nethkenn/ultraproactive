<?php namespace App\Http\Controllers;
use JasperPHP;
use Request;
use DB;
use App\Classes\Product;
use Carbon\Carbon;
use Config;
use App\Classes\Stockist;
use App\Tbl_transaction;
use App\Rel_transaction;
use Datatables;	
class StockistReportsController extends StockistController
{
	public function sales()
	{	



		if(Request::isMethod("post"))
		{
			$data["to"] = date("m/d/o", strtotime(Request::input("to")));
			$data["from"] = date("m/d/o", strtotime(Request::input("from")));
			$data["group"] = Request::input("group-date");
		}
		else
		{
			$data["to"] = $to = date("m/d/o", time());
			$data["from"] = $from = date("m/d/o", time() - (60 * 60 * 24 * 30));
			$data["group"] = "daily";
		}

		switch(Request::input("report-source"))
		{
			default: $data = $this->sales_report($data, Request::input("report-source")); break;
		}

        return view('stockist.report.product_sales', $data);
	}



	public static function currency_format($price)
    {
        $currency = Config::get('app.currency');
        return number_format($price, 2);
    }


	public function sales_report($data, $filter_sales)
	{
		$to = $data["to"];
		$from = $data["from"];
		$group = $data["group"];

		$column_date = 'created_at';
		$column_value = 'SUM(`total_amount`)';
		
		if($group == "daily")
		{
			$select = "$column_value as 'value', $column_date as 'date'";
			$groupBy = "YEAR($column_date), MONTH($column_date), DAY($column_date)";
			$increment = "days";
			$time_string = "m/d/o";
		}
		elseif($group == "monthly")
		{
			$select = "$column_value as 'value', $column_date as 'date'";
			$groupBy = "YEAR($column_date), MONTH($column_date)";
			$increment = "months";
			$time_string = "F Y";
		}
		elseif($group == "yearly")
		{
			$select = "$column_value as 'value', $column_date as 'date'";
			$groupBy = "YEAR($column_date)";
			$increment = "years";
			$time_string = "Y";
		}

		$_order = DB::table("tbl_voucher")->select(DB::raw($select))
											->groupBy(DB::raw($groupBy))
											->where('status','<>','cancelled')
											->where('origin', '=', Stockist::info()->stockist_id)
											->where(function($query) use($filter_sales)
											{ 
												switch ($filter_sales)
												{
													case '0':
														$query->where('payment_mode', '0');	
														break;
													case '1':
														$query->where('payment_mode', '1');	
														break;
														$query->whereNotNull('payment_mode');	
													default:

												}
												
											})
											->get();

		foreach($_order as $key => $order)
		{
			$label = date($time_string, strtotime($order->date));
			$data["_order"][$label] = $order;
			$data["_order"][$label]->label = $label ;
			$data["_order"][$label]->income = $this->currency_format($order->value);
		}	

		$ctr = 0;

		while(strtotime($from) <= strtotime($to))
		{
			$date = date($time_string, strtotime($from));
			$data["_report"][$ctr]["date"] = $date;
			$data["_report"][$ctr]["value"] = isset($data["_order"][$date]->value) ? $data["_order"][$date]->value : 0;
			$data["_report"][$ctr]["income"] = $this->currency_format($data["_report"][$ctr]["value"]);
			$from = date($time_string, strtotime($from . "+1 $increment"));
			$ctr++;
		}

		return $data;
	}

	public function transaction()
	{


 		return view('stockist.report.transaction_record');
	}

	public function ajax_get_trans()
	{

		$transaction = Tbl_transaction::where('transaction_by_stockist_id',Stockist::info()->stockist_id)->get();

        return Datatables::of($transaction)	->addColumn('view','<a href="stockist/reports/transaction/view?id={{$transaction_id}}">View</a>')
	        								->make(true);
	}   

	public function view_transaction()
	{
		$id = Request::input('id');
		$data['transaction'] = Tbl_transaction::where('transaction_id',$id)->first();
		$data['checking'] = 0;

		if($data['transaction']->transaction_description != "Membership Code")
		{
				$data['checking'] = 1;
				$data['product'] = Rel_transaction::where('transaction_id',$id)->where('rel_transaction.product_id','!=','NULL')
																   ->join('tbl_product','tbl_product.product_id','=','rel_transaction.product_id')
																   ->get();
				$data['package'] = Rel_transaction::where('transaction_id',$id)->where('rel_transaction.product_package_id','!=','NULL')
																   ->where('rel_transaction.product_package_id','!=',0)
																   ->join('tbl_product_package','tbl_product_package.product_package_id','=','rel_transaction.product_package_id')
																   ->get();												   

		}
		else
		{
				$data['code'] = Rel_transaction::where('transaction_id',$id)->where('rel_transaction.code_pin','!=','NULL')
																			->where('rel_transaction.code_pin','!=',0)
																            ->get();
            	$data['checking'] = 2;
		}


		return view('stockist.report.view_transaction',$data);
	}
 

}


