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
		$data["_news"] = DB::table("tbl_news")->where("archived", 0)->orderBy('news_date', 'desc')->take(3)->get();
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
			$data["_news"][$keys]->month = $month;
			$data["_news"][$keys]->day = $day;
		}

		$data["_product"] = DB::table("tbl_product")->where("image_file", "!=", "default.jpg")->where("image_file", "!=", "")->orderBy('created_at', 'desc')->where("archived", 0)->take(6)->get();
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

		$data["_testimony"] = DB::table("tbl_testimony")->where("archived", 0)->get();

		$data["_partner"] = DB::table("tbl_partner")->where("archived", 0)->get();
		foreach ($data["_partner"] as $edi => $wow) 
		{
			$nice = $wow->partner_image;
			$pre = Image::view($nice, "150x60");
			$data["_partner"][$edi]->image = $pre;
		}
		// dd($data["_news"]);

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
		$data["about"] = DB::table("tbl_about")->where("archived", 0)->where("about_name", "About")->first();
		$data["vision"] = DB::table("tbl_about")->where("archived", 0)->where("about_name", "Vision")->first();
		$data["mission"] = DB::table("tbl_about")->where("archived", 0)->where("about_name", "Mission")->first();
		$data["philosophy"] = DB::table("tbl_about")->where("archived", 0)->where("about_name", "Philosophy")->first();
        return view('front.about', $data);
	}
	public function partner()
	{
		$data["_partner"] = DB::table("tbl_partner")->where("archived", 0)->get();
		foreach ($data["_partner"] as $key => $value) 
		{
			$get = $value->partner_image;
			$imagee = Image::view($get, "150x60");
			$data["_partner"][$key]->image = $imagee;
		}

		$data["_testimony"] = DB::table("tbl_testimony")->where("archived", 0)->get();
		$data["partner"] = DB::table("tbl_about")->where("archived", 0)->where("about_name", "Partners")->first();
        return view('front.partner', $data);
	}
	public function earn()
	{
        return view('front.earn', $data);
	}
	public function service()
	{	
		$data["_service"] = DB::table("tbl_service")->where("archived", 0)->get();
		foreach ($data["_service"] as $key => $value) 
		{
			$get = $value->service_image;
			$imagee = Image::view($get, "723x530");
			$data["_service"][$key]->image = $imagee;
		}

        return view('front.service', $data);
	}
	public function product()
	{
		$data["_product"] = DB::table("tbl_product")->where("image_file", "!=", "default.jpg")->where("image_file", "!=", "")->where("archived", 0)->get();
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
		$data["_product"] =  DB::table("tbl_product")->where("archived", 0)->where("image_file", "!=", "default.jpg")->where("image_file", "!=", "")->orderBy('product_id', 'desc')->take(6)->get();
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
		$data["contact"] = DB::table("tbl_about")->where("archived", 0)->where("about_name", "Contact")->first();
		$_settings = DB::table("tbl_settings")->get();
			
		$set = new \stdClass();
		foreach($_settings as $setting)
		{
			$key = $setting->key;
			$value = $setting->value;
			
			$set->$key = $value;
		}
		$data["company"] = $set;
        return view('front.contact', $data);
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