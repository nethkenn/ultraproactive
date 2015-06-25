<?php namespace App\Http\Controllers;

class AdminPositionController extends AdminController
{
	public function index()
	{
        return view('admin.utilities.position');
	}
}