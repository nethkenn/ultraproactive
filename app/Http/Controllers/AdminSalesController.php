<?php namespace App\Http\Controllers;

class AdminSalesController extends AdminController
{
	public function index()
	{
        return view('admin.transaction.sale');
	}
}