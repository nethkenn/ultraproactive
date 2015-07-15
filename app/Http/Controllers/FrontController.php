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
		$data["_news"] = DB::table("tbl_news")->where("archived", 0)->take(3)->get();
		foreach ($data["_news"] as $key => $value) 
		{
			$get = $value->news_image;
			$imagee = Image::view($get, "300x160");
			$data["_news"][$key]->image = $imagee;
		}

		foreach ($data["_news"] as $keys => $values) 
		{
			$datee = $values->news_date;
			$time=strtotime($datee);
			$month=date("F",$time);
			$day=date("d",$time);
			$data["_news"][$key]->month = $month;
			$data["_news"][$key]->day = $day;
		}

		$data["_product"] = DB::table("tbl_product")->where("archived", 0)->take(8)->get();
		foreach ($data["_product"] as $keyss => $valuess) 
		{
			$gets = $valuess->image_file;
			$imagees = Image::view($gets, "514x360");
			$data["_product"][$keyss]->image = $imagees;
		}

		$data["_slide"] = DB::table("tbl_slide")->where("archived", 0)->get();
		foreach ($data["_slide"] as $keysss => $valuesss) 
		{
			$getss = $valuesss->slide_image;
			$imageess = Image::view($getss, "1110x400");
			$data["_slide"][$keysss]->image = $imageess;
		}
		foreach ($data["_slide"] as $xx => $yy) {
			$aa = $yy->slide_image;
			$bb = Image::view($aa, "125x96");
			$data["_slide"][$xx]->thumb = $bb;
		}

		$data["_team"] = DB::table("tbl_team")->where("archived", 0)->get();
		foreach ($data["_team"] as $susi => $halaga) 
		{
			$kuha = $halaga->team_image;
			$litrato = Image::view($kuha, "415x415");
			$data["_team"][$susi]->image = $litrato;
		}

		// dd($data["_team"]);

        return view('front.home', $data);
	}
	public function about()
	{
		$data["_team"] = DB::table("tbl_team")->where("archived", 0)->get();
		foreach ($data["_team"] as $susi => $halaga) 
		{
			$kuha = $halaga->team_image;
			$litrato = Image::view($kuha, "415x415");
			$data["_team"][$susi]->image = $litrato;
		}

        return view('front.about', $data);
	}
	public function earn()
	{
		$data["_earn"] = DB::table("tbl_earn")->where("archived", 0)->get();

        return view('front.earn', $data);
	}
	public function service()
	{
        return view('front.service');
	}
	public function product()
	{
		$data["_product"] = DB::table("tbl_product")->where("archived", 0)->get();
		foreach ($data["_product"] as $key => $value) 
		{
			$get = $value->image_file;
			$imagee = Image::view($get, "256x180");
			$data["_product"][$key]->image = $imagee;
		}

		$data["_category"] = DB::table("tbl_product_category")->where("archived", 0)->get();
		
        return view('front.product', $data);
	}
	public function product_content()
	{
		$id = Request::input("id");
		$data["product"] = DB::table("tbl_product")->where("archived", 0)->where("product_id", $id)->first();
		$get = $data["product"]->image_file;
		$imagee = Image::view($get, "726x750");
		$data["product"]->image = $imagee;
	
		$date = $data["product"]->created_at;
		$time=strtotime($date);
		$month=date("F",$time);
		$day=date("d",$time);
		$year=date("Y",$time);

		$data["product"]->month = $month;
		$data["product"]->day = $day;
		$data["product"]->year = $year;
		return view('front.product_content', $data);
	}
	public function news()
	{
		$data["_news"] = DB::table("tbl_news")->where("archived", 0)->get();
		$data["_newss"] = DB::table("tbl_news")->where("archived", 0)->orderBy('news_id', 'desc')->take(4)->get();
		$data["_product"] =  DB::table("tbl_product")->where("archived", 0)->orderBy('product_id', 'desc')->take(6)->get();
		foreach ($data["_news"] as $key => $value) 
		{
			$get = $value->news_image;
			$imagee = Image::view($get, "700x301");
			$data["_news"][$key]->image = $imagee;
		}
		foreach ($data["_product"] as $keys => $values) 
		{
			$gets = $values->image_file;
			$imagees = Image::view($gets, "75x75");
			$data["_product"][$keys]->image = $imagees;
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