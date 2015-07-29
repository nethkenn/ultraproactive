<?php namespace App\Http\Controllers;

class AdminReportController extends AdminController
{
	public function product_sales()
	{
		
        return view('admin.report.product_sales');
	}
	public function membership_sales()
	{
        return view('admin.report.membership_sales');
	}
}