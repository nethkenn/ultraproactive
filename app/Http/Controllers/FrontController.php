<?php namespace App\Http\Controllers;
use DB;
use App\Classes\Image;
use Request;
use Input;
use Mail;
use App\Classes\Globals;
use Redirect;

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
		$data["_news"] = DB::table("tbl_news")->where("archived", 0)->get();
		foreach ($data["_news"] as $key => $value) 
		{
			$get = $value->news_image;
			$imagee = Image::view($get, "700x301");
			$data["_news"][$key]->image = $imagee;
		}
        return view('front.news', $data);
	}
	public function news_content()
	{
		$id = Request::input("id");
		$data["news"] = DB::table("tbl_news")->where("news_id", $id)->first();
		// $imagee = Image::view($data["news"]->news_image, "1100x473");
		$imagee = Image::view($data["news"]->news_image, "700x301");
		$data["news"]->image = $imagee;

		$datee = $data["news"]->news_date;
		$time=strtotime($datee);
		$month=date("F",$time);
		$day=date("d",$time);

		$data["news"]->month = $month;
		$data["news"]->day = $day;

	

		// $multidate = Globals::multiexplode(array("-","-"," "), $datee);
		// $date["month"] = $multidate["1"];
		// $date["day"] = $multidate["2"];

        return view('front.news_content', $data);
	}
	public function contact()
	{
        return view('front.contact');
	}
	public function contact_submit()
	{
		$fromEmail = Input::get('email');
	    $fromName = Input::get('name');
	    $subject = Input::get('subject');
	    $data["data"] = Input::get('message');

	    $toEmail = 'admin@prolife.global';
	    $toName = 'Customer';

	    Mail::send('emails.contact', $data, function($message) use ($toEmail, $toName, $fromEmail, $fromName, $subject)
	    {
	        $message->to($toEmail, $toName);

	        $message->from($fromEmail, $fromName);

	        $message->subject($subject);
	    });

	    return Redirect::to("/contact");
	}
	public function register()
	{
        return view('front.register');
	}
}