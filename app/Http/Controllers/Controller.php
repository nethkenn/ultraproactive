<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use DB;

abstract class Controller extends BaseController
{
	use DispatchesCommands, ValidatesRequests;
	public function __construct()
	{
		$_newsfooter = DB::table("tbl_news")->where("archived", 0)->orderBy('news_date', 'asc')->take(4)->get();
		foreach ($_newsfooter as $key => $value) 
		{
			$date = strtotime($value->news_date);
			$month=date("F",$date);
			$day=date("d",$date);
			$year=date("Y",$date);
			$_newsfooter[$key]->month = $month;
			$_newsfooter[$key]->day = $day;
			$_newsfooter[$key]->year = $year;
		}
		View()->share("_newsfooter", $_newsfooter);
	}
}