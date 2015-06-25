<?php namespace App\Http\Controllers;

class AdminDeductionController extends AdminController
{
	public function index()
	{
        return view('admin.maintenance.encashment_deduction');
	}
}