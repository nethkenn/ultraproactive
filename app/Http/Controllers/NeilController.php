<?php namespace App\Http\Controllers;
use Request;
use Crypt;

class NeilController extends Controller
{
	public function index()
	{

		echo Crypt::decrypt('eyJpdiI6IkJpMFE0ejVUNGhacVRoNDMzOWxBTHc9PSIsInZhbHVlIjoiR25YazdybnJzTlYrZWNtYVpxMTVIQ3MwQm50Wkx2bkNLdGJvUExSbENPTT0iLCJtYWMiOiJjMmZlMjNiNDliZWIwNDhiNjZmZDI3NmY5ZWVmMDU4ZTg4ZDcyODQwYThmMGJmZTA1ZTU1NDJmNjFiNTRkNWE0In0=');
		die();
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