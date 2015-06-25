<?php namespace App\Http\Controllers;

class AdminPackageController extends AdminController
{
	public function index()
	{
        return view('admin.maintenance.package');
	}
}