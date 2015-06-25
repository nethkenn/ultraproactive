<?php namespace App\Http\Controllers;

class AdminClaimController extends AdminController
{
	public function index()
	{
        return view('admin.transaction.claim');
	}
}