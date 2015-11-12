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
		$data["_news"] = DB::table("tbl_news")->where("archived", 0)->orderBy('news_date', 'desc')->take(4)->get();
		foreach ($data["_news"] as $key => $value) 
		{
			$get = $value->news_image;
			$imagee = Image::view($get, "150x150");
			$data["_news"][$key]->image = $imagee;
		}

		foreach ($data["_news"] as $keys => $values) 
		{
			$datee = $values->news_date;
			$time=strtotime($datee);
			$month=date("M",$time);
			$day=date("d",$time);
			$year=date("Y",$time);
			$data["_news"][$keys]->month = $month;
			$data["_news"][$keys]->day = $day;
			$data["_news"][$keys]->year = $year;
		}

		$data["_product"] = DB::table("tbl_product")->where("image_file", "!=", "default.jpg")->where("image_file", "!=", "")->orderBy('created_at', 'desc')->where("archived", 0)->take(8)->get();
		foreach ($data["_product"] as $keyss => $valuess) 
		{
			$gets = $valuess->image_file;
			$imagees = Image::view($gets, "770x619");
			$data["_product"][$keyss]->image = $imagees;
		}

		$data["_category"] = DB::table("tbl_product_category")->where("archived", 0)->get();

		$data["_slide"] = DB::table("tbl_slide")->where("archived", 0)->get();
		foreach ($data["_slide"] as $keysss => $valuesss) 
		{
			$getss = $valuesss->slide_image;
			$imageess = Image::view($getss, "1366x461");
			$data["_slide"][$keysss]->image = $imageess;
		}
		foreach ($data["_slide"] as $xx => $yy) {
			$aa = $yy->slide_image;
			$bb = Image::view($aa, "125x96");
			$data["_slide"][$xx]->thumb = $bb;
		}

		$data["_team"] = DB::table("tbl_team")->where("archived", 0)->orderBy('team_sort', 'asc')->get();
		foreach ($data["_team"] as $susi => $halaga) 
		{
			$kuha = $halaga->team_image;
			$litrato = Image::view($kuha, "468x467");
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
		$data["_team"] = DB::table("tbl_team")->where("archived", 0)->orderBy('team_sort', 'asc')->get();
		foreach ($data["_team"] as $susi => $halaga) 
		{
			$kuha = $halaga->team_image;
			$litrato = Image::view($kuha, "468x467");
			$data["_team"][$susi]->image = $litrato;
		}
		$data["mission"] = DB::table("tbl_about")->where("about_name", "Mission")->first();
		$data["vision"] = DB::table("tbl_about")->where("about_name", "Vision")->first();
		$data["about"] = DB::table("tbl_about")->where("about_name", "About")->first();
        return view('front.about', $data);
	}
	public function stories()
	{
		$data["_stories"] = DB::table("tbl_stories")->where("archived", 0)->get();

        return view('front.stories', $data);
	}
	public function opportunity()
	{
        return view('front.opportunity');
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
			$imagee = Image::view($get, "770x619");
			$data["_product"][$key]->image = $imagee;
		}

		$data["_category"] = DB::table("tbl_product_category")->where("archived", 0)->get();
		
        return view('front.product', $data);
	}
	public function product_content()
	{
		$id = Request::input("id");
		$data["product"] = DB::table("tbl_product")->where("product_id", $id)->first();
		$get = $data["product"]->image_file;
		$imagee = Image::view($get, "770x619");
		$data["product"]->image = $imagee;
	
		$date = $data["product"]->created_at;
		$time=strtotime($date);
		$month=date("F",$time);
		$day=date("d",$time);
		$year=date("Y",$time);

		$data["product"]->month = $month;
		$data["product"]->day = $day;
		$data["product"]->year = $year;

		$category_id = $data["product"]->product_category_id;
		$data["category"] = DB::table("tbl_product_category")->where("product_category_id", $category_id)->first();
		$data["_product"] = DB::table("tbl_product")->where("product_category_id", $category_id)->where("archived", 0)->take(4)->get();

		$product_id = DB::table("tbl_product")->where("archived", 0)->orderBy('product_id', 'desc')->first();
		$data["product_id"] = $product_id->product_id;
		
		$next_id = $data["product"]->product_id;
		$next_id_next = $next_id + 1;
		$next_id_check = DB::table("tbl_product")->where("product_id", $next_id_next)->first();
		$next_id_check_id = $next_id_check->archived;
		if ($next_id_check_id == 1) 
		{
			$next_get = $next_id_next + 1;
		}
		else
		{
			$next_get = $next_id_next;
		}

		$data["next_id"] = $next_get;
		$prev_id = $data["product"]->product_id;
		$prev_ids = $prev_id;
		if ($prev_id == 1) 
		{
			$prev_ids = $prev_id + 1;
		}
		$prev_id_prev = $prev_ids - 1;
		$prev_id_check = DB::table("tbl_product")->where("product_id", $prev_id_prev)->first();
		$prev_id_check_id = $prev_id_check->archived;
		if ($prev_id_check_id == 1) 
		{
			$prev_get = $prev_id_prev - 1;
		}
		else
		{
			$prev_get = $prev_id_prev;
		}

		$data["prev_id"] = $prev_get;

		foreach ($data["_product"] as $key => $value) 
		{
			$image =  $value->image_file;
			$view = Image::view($image, "770x619");
			$data["_product"][$key]->image = $view;
		}
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
		$imagee = Image::view($data["news"]->news_image, "1170x500");
		$data["news"]->image = $imagee;

		$datee = $data["news"]->news_date;
		$time=strtotime($datee);
		$month=date("F",$time);
		$day=date("d",$time);
		$year=date("Y",$time);

		$data["news"]->month = $month;
		$data["news"]->day = $day;
		$data["news"]->year = $year;
	

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

	    $toEmail = 'admin@ultraproactive.net';
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
	public function mindsync()
	{
		$data["_image"] = DB::table("tbl_mindsync")->where("mindsync_image", "!=", "")->where("archived", 0)->get();
		foreach ($data["_image"] as $key => $value) 
		{
			$image = $value->mindsync_image;
			$image_view = "http://image.primiaworks.com/uploads/ultraproactive.net/image/$image/$image";
			$data["_image"][$key]->image = $image_view;
		}
		$data["_testimony"] = DB::table("tbl_mindsync")->where("mindsync_title", "!=", "")->where("mindsync_description", "!=", "")->where("archived", 0)->get();
		$data["_video"] = DB::table("tbl_mindsync")->where("mindsync_video", "!=", "")->where("archived", 0)->get();
		// foreach ($data["_mindsync"] as $key => $value) 
		// {
		// 	$explode = $value;
		// 	$get = explode(",", $explode->mindsync_image);
		// 	foreach ($get as $susi => $halaga) 
		// 	{
		// 		$imagee[$susi] = Image::view($halaga, "300x300");
		// 	}
		// 	// $imagee = "http://image.primiaworks.com/uploads/ultraproactive.net/image/$get/$get";
		// 	$data["_mindsync"][$key]->image = $imagee;
		// }
		
		return view('front.mindsync', $data);
	}
	public function faq()
	{
		$data["type"] = Request::input("type");
		if (isset($data["type"])) 
		{
			$data["_product"] = DB::table("tbl_faq")->where("archived", 0)->where("faq_type", "product")->get();
			$data["_mindsync"] = DB::table("tbl_faq")->where("archived", 0)->where("faq_type", "mindsync")->get();
			$data["_opportunity"] = DB::table("tbl_faq")->where("archived", 0)->where("faq_type", "opportunity")->get();
			$data["_glossary"] = DB::table("tbl_faq")->where("archived", 0)->where("faq_type", "glossary")->get();
			return view('front.faq', $data);
		}
        else
       	{
       		return Redirect::to("/");
       	}
	}
	public function foodcart()
	{
		$data["_foodcart"] = DB::table("tbl_foodcart")->where("archived", 0)->get();
		foreach ($data["_foodcart"] as $key => $value) 
		{
			$image = $value->foodcart_image;
			$image_view = Image::view_main($image);
			$data["_foodcart"][$key]->image = $image_view;
		}

        return view('front.foodcart', $data);
	}
}