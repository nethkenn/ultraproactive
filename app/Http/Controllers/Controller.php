<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use DB;
use App\Classes\Settings;
use App\Classes\Image;

abstract class Controller extends BaseController
{
	use DispatchesCommands, ValidatesRequests;
	public function __construct()
	{
		$_newsfooter = DB::table("tbl_news")->where("archived", 0)->orderBy('news_date', 'desc')->take(3)->get();
		foreach ($_newsfooter as $key => $value) 
		{
			$image_get =  $value->news_image;
			$image_view = Image::view($image_get, "50x50");
			$_newsfooter[$key]->image = $image_view;
			$date = strtotime($value->news_date);
			$month = date("F",$date);
			$day = date("d",$date);
			$year = date("Y",$date);
			$_newsfooter[$key]->month = $month;
			$_newsfooter[$key]->day = $day;
			$_newsfooter[$key]->year = $year;
		}

		$_productfooter = DB::table("tbl_product")->where("archived", 0)->orderBy('created_at', 'desc')->take(6)->get();
		foreach ($_productfooter as $keys => $values) 
		{
			$image_get =  $values->image_file;
			$image_view = Image::view($image_get, "100x100");
			$_productfooter[$keys]->image = $image_view;
		}

		$_settings = DB::table("tbl_settings")->get();
			
			$set = new \stdClass();
			foreach($_settings as $setting)
			{
				$key = $setting->key;
				$value = $setting->value;

				// if($key == "logo")
				// {
				// 	$set->logo_image = Image::view($value, '250x250');
				// }
				
				$set->$key = $value;
			}

		// $data["settings"] = $set;

		View()->share("_newsfooter", $_newsfooter);
		View()->share("_productfooter", $_productfooter);
		View()->share("_setting", $set);
	}
}