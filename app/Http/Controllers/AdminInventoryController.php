<?php namespace App\Http\Controllers;

class AdminInventoryController extends AdminController
{
	public function index()
	{
        return view('admin.maintenance.inventory');
	}
}