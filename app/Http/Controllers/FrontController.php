<?php namespace App\Http\Controllers;

class FrontController extends Controller
{
	public function index()
	{
        return view('front.home');
	}
	public function about()
	{
        return view('front.about');
	}
	public function earn()
	{
        return view('front.earn');
	}
	public function service()
	{
        return view('front.service');
	}
	public function product()
	{
        return view('front.product');
	}
	public function news()
	{
        return view('front.news');
	}
	public function contact()
	{
        return view('front.contact');
	}
}