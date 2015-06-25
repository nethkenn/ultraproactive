<?php namespace App\Http\Controllers;

class AdminComplanController extends AdminController
{
	public function index()
	{
        return view('admin.utilities.complan');
	}
}