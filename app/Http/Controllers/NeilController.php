<?php namespace App\Http\Controllers;
use Request;

class NeilController extends Controller
{
	public function index()
	{
		if(Request::isMethod("post"))
		{
			$this->hiwalay();
		}
		else
		{
			$data["page"] = "Neil";
			return view('neil.neil', $data);
		}
	}
	public function hiwalay()
	{
		echo " nag submit na si koya" . Request::input("kljhlhjln");
	}
}