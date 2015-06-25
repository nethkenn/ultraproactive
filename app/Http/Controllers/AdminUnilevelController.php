<?php namespace App\Http\Controllers;

class AdminUnilevelController extends AdminController
{
	public function index()
	{
        return view('admin.transaction.unilevel');
	}
}