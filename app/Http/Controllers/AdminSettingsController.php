<?php namespace App\Http\Controllers;

class AdminSettingsController extends AdminController
{
	public function index()
	{
        return view('admin.utilities.settings');
	}
}