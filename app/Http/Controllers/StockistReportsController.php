<?php namespace App\Http\Controllers;
use JasperPHP;
use Request;
use DB;
use App\Classes\Product;
use Carbon\Carbon;
use Config;
use App\Classes\Stockist;
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


}


