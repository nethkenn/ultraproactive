<?php namespace App\Http\Controllers;

class AdminPayoutController extends AdminController
{
	public function index()
	{
        return view('admin.transaction.payout');
	}
}