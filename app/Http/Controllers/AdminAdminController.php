<?php namespace App\Http\Controllers;

class AdminAdminController extends AdminController
{
	public function index()
	{
        return view('admin.utilities.admin');
	}
}