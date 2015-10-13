<?php namespace App\Http\Controllers;
use JasperPHP;
use Request;
use DB;
use App\Classes\Product;
use Carbon\Carbon;
use Config;
use App\Classes\Log;
use App\Classes\Admin;
use App\Tbl_wallet_logs;
use App\Tbl_tree_sponsor;
use Datatables;
use App\Tbl_slot;
class AdminReportController extends AdminController
{
	public function bonus_summary()
	{	
		$data['ctr']     = 1;
		$data['title']   = 'Bonus summary';



		return view('admin.report.other_report', $data);
	}

	public function bonus_summary_get()
    {
		$summary = Tbl_slot::select('tbl_slot.slot_id','account_name',DB::raw('SUM(CASE When keycode="Old System Wallet" And wallet_type="Wallet" Then wallet_amount Else 0 End ) as old'),
														   DB::raw('SUM(CASE When keycode="Dynamic Compression" And wallet_type="Wallet" Then wallet_amount Else 0 End ) as dynamic'),
														   DB::raw('SUM(CASE When keycode="binary" And wallet_type="Wallet" Then wallet_amount Else 0 End ) as matching'),
														   DB::raw('SUM(CASE When keycode="direct" And wallet_type="Wallet" Then wallet_amount Else 0 End ) as sponsor'),
														   DB::raw('SUM(CASE When keycode="matching" And wallet_type="Wallet" Then wallet_amount Else 0 End ) as mentor'),
														   DB::raw('SUM(CASE When keycode="matching" or keycode="Dynamic Compression" or keycode="Old System Wallet" or keycode="direct" or keycode="binary" And wallet_type="Wallet" Then wallet_amount Else 0 End ) as subtotal'),
														   DB::raw('SUM(CASE When wallet_amount < 0 And keycode!="Old System Wallet" And wallet_type="Wallet" Then wallet_amount Else 0 End ) as encash'),
														   DB::raw('SUM(wallet_amount) as total'))
								->leftJoin('tbl_wallet_logs','tbl_slot.slot_id','=','tbl_wallet_logs.slot_id')
								->leftJoin('tbl_account','tbl_account.account_id','=','tbl_slot.slot_owner')
								->groupBy('tbl_slot.slot_id')
								->get();

        return Datatables::of($summary)->editColumn('old','{{number_format($old,2)}}')
								       ->editColumn('dynamic','{{number_format($dynamic,2)}}')
								       ->editColumn('matching','{{number_format($matching,2)}}')
								       ->editColumn('sponsor','{{number_format($sponsor,2)}}')
									   ->editColumn('mentor','{{number_format($mentor,2)}}')
									   ->editColumn('subtotal','{{number_format($subtotal,2)}}')
									   ->editColumn('encash','{{number_format($encash,2)}}')
									   ->editColumn('total','{{number_format($total,2)}}')
        							   ->make(true);


    }

	public function gc_summary()
    {
		$data['ctr']     = 1;
		$data['title']   = 'GC summary';



		return view('admin.report.gc_summary', $data);
    }

	public function gc_summary_get()
    {
		$summary = Tbl_slot::select('tbl_slot.slot_id','account_name',DB::raw('SUM(CASE When wallet_amount > 0 And wallet_type="GC" Then wallet_amount Else 0 End ) as subtotal'),
							  		 DB::raw('SUM(CASE When wallet_type="GC" Then wallet_amount Else 0 End ) as total'),
							  		 DB::raw('SUM(CASE When wallet_amount < 0 And wallet_type="GC" Then wallet_amount Else 0 End ) as encash'))
									->leftjoin('tbl_wallet_logs','tbl_slot.slot_id','=','tbl_wallet_logs.slot_id')
									->leftjoin('tbl_account','tbl_account.account_id','=','tbl_slot.slot_owner')
									->groupBy('tbl_slot.slot_id')
									->get();

        return Datatables::of($summary)->editColumn('subtotal','{{number_format($subtotal,2)}}')
									   ->editColumn('encash','{{number_format($encash,2)}}')
									   ->editColumn('total','{{number_format($total,2)}}')
        							   ->make(true);


    }

	// public function top_earner()
 //    {
	// 	$data['ctr']     = 1;
	// 	$data['title']   = 'Top Earner';

	// 	$summary = Tbl_slot::select('tbl_slot.slot_id','account_name','ROW_NUMBER() OVER (ORDER BY (SELECT 1)) AS number',DB::raw('SUM(CASE When wallet_amount > 0 And wallet_type="GC" Then wallet_amount Else 0 End ) as subtotal'),
	// 						  		 DB::raw('SUM(CASE When wallet_type="GC" Then wallet_amount Else 0 End ) as total'),
	// 						  		 DB::raw('SUM(CASE When wallet_amount < 0 And wallet_type="GC" Then wallet_amount Else 0 End ) as encash'))
	// 								->leftjoin('tbl_wallet_logs','tbl_slot.slot_id','=','tbl_wallet_logs.slot_id')
	// 								->leftjoin('tbl_account','tbl_account.account_id','=','tbl_slot.slot_owner')
	// 								->groupBy('tbl_slot.slot_id')
	// 								->first();
	// 								dd($summary);
	// 	return view('admin.report.gc_summary', $data);
 //    }

	// public function top_earner_get()
 //    {


 //        return Datatables::of($summary)->editColumn('subtotal','{{number_format($subtotal,2)}}')
	// 								   ->editColumn('encash','{{number_format($encash,2)}}')
	// 								   ->editColumn('total','{{number_format($total,2)}}')
 //        							   ->make(true);


 //    }
}