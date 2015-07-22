<?php namespace App\Http\Controllers;

class AdminComplanController extends AdminController
{
	public function index()
	{
        return view('admin.utilities.complan');
	}
	public function binary()
	{
		return view('admin.comptation.binary');
	}
}