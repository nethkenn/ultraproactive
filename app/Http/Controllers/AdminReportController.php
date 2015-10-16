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

	public function other_reports()
    {

		$data['total_flushed'] = Tbl_wallet_logs::sum('flushed_out');
		$data['ps'] = Tbl_slot::where('slot_type','PS')->count();
		$data['cd'] = Tbl_slot::where('slot_type','CD')->count();
		$data['fs'] = Tbl_slot::where('slot_type','FS')->count();
		$data['total_slot'] = Tbl_slot::count();

		$data['matching_gc']	 = Tbl_wallet_logs::where('keycode','=','binary')->where('wallet_type','GC')->sum('wallet_amount');
		$data['sponsor_gc']  = Tbl_wallet_logs::where('keycode','=','direct')->where('wallet_type','GC')->sum('wallet_amount');

		$data['old_wallet'] = Tbl_wallet_logs::where('keycode','=','Old System Wallet')->sum('wallet_amount');
		$data['mentor']   = Tbl_wallet_logs::where('keycode','=','matching')->wallet()->sum('wallet_amount');
		$data['matching']	 = Tbl_wallet_logs::where('keycode','=','binary')->wallet()->sum('wallet_amount');
		$data['sponsor']  = Tbl_wallet_logs::where('keycode','=','direct')->wallet()->sum('wallet_amount');
		$data['dynamic'] = Tbl_wallet_logs::where('keycode','=','Dynamic Compression')->sum('wallet_amount');
		// $data['binary_repurchase'] = Tbl_wallet_logs::where('keycode','=','binary_repurchase')->sum('wallet_amount');
		$data['total']   = $data['old_wallet']+$data['mentor']  +$data['matching']+$data['sponsor'] +$data['dynamic'];
		 
		$data['total_encashment'] = Tbl_wallet_logs::where('keycode','=','Encashment')->sum('wallet_amount');
		$data['count_encash'] = DB::table('tbl_account_encashment_history')->count();

		$data['total_order'] = DB::table('tbl_voucher')->where('origin',null)->count();
		$data['total_items'] = DB::table('tbl_voucher')->where('origin',null)->join('tbl_voucher_has_product','tbl_voucher_has_product.voucher_id','=','tbl_voucher.voucher_id')->sum('qty');
		$data['total_sales'] = DB::table('tbl_voucher')->where('origin',null)->sum('total_amount');
		$data['total_ps_price'] = DB::table('tbl_slot')->where('slot_type','PS')->join('tbl_membership','membership_id','=','membership_entry_id')->sum('membership_price');
		$data['company_subtotal'] = $data['total_sales'] + $data['total_ps_price'];
		$data['company_total'] = $data['company_subtotal'] - $data['total'];

		$data['total_codes'] = DB::table('tbl_membership_code')->count();
		$data['total_used_codes'] = DB::table('tbl_membership_code')->where('used',1)->count();
		$data['total_avail_codes'] = DB::table('tbl_membership_code')->where('used',0)->count();



		return view('admin.report.reports_other', $data);
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

	public function top_earner()
    {
		$data['ctr']     = 1;
		$data['title']   = 'Top Earner';

							
		return view('admin.report.top_earner', $data);
    }

	public function top_earner_get()
    {


		$summary = Tbl_slot::select('tbl_slot.slot_id','account_name',
									 DB::raw('SUM(CASE When wallet_amount > 0 And wallet_type="GC" Then wallet_amount Else 0 End ) as gc_earned'),
							  		 DB::raw('SUM(CASE When wallet_amount > 0 And wallet_type="WALLET" Then wallet_amount Else 0 End ) as wallet_earned'),
							  		 DB::raw('SUM(CASE When wallet_amount > 0 Then wallet_amount Else 0 End ) as total_earned'))
									->leftjoin('tbl_wallet_logs','tbl_slot.slot_id','=','tbl_wallet_logs.slot_id')
									->leftjoin('tbl_account','tbl_account.account_id','=','tbl_slot.slot_owner')
									->groupBy('tbl_slot.slot_id')
									->orderBy('total_earned','DESC')
									->get();

        return Datatables::of($summary)->editColumn('gc_earned','{{number_format($gc_earned,2)}}')
									   ->editColumn('wallet_earned','{{number_format($wallet_earned,2)}}')
									   ->editColumn('total_earned','{{number_format($total_earned,2)}}')
        							   ->make(true);


    }

	public function top_recruiter()
    {
		$data['ctr']     = 1;
		$data['title']   = 'Top Recruiter';

							
		return view('admin.report.top_recruiter', $data);
    }

	public function top_recruiter_get()
    {

		$summary = Tbl_slot::select('tbl_slot.slot_id','account_name',DB::raw('COUNT(slot_id) as count')) ->account()
																	->join('tbl_tree_sponsor','sponsor_tree_parent_id','=','slot_id')
																	->where('sponsor_tree_level',1)
																	->groupBy('slot_id')
																	->orderBy('count','DESC')
																	->get();
		$ctr = 0;
		$ctr2 = 0;
		foreach($summary as $key => $s)
		{

			if(!isset($compare))
			{
				$compare = $summary[$key]->count;
				$ctr++;
				$ctr2++;
				$summary[$key]->ctr = $ctr;
			}
			else
			{
				if($compare == $summary[$key]->count)
				{
					$ctr2++;
					$summary[$key]->ctr = $ctr;
				}
				else
				{
					$ctr2++;
					$ctr = $ctr2;
					$summary[$key]->ctr = $ctr2;
				}
				$compare = $summary[$key]->count;
			}	

			

		}
        return Datatables::of($summary)->make(true);


    }
}