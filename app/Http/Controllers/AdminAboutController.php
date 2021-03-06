<?php namespace App\Http\Controllers;
use DB;
use Redirect;
use Request;
use App\Classes\Image;

class AdminAboutController extends AdminController
{
	public function index()
	{
		$id = Request::input("id");
		$data["_about"] = DB::table("tbl_about")->get();

        return view('admin.content.about', $data);
	}
	public function submit()
	{
		$name = Request::input("name");
		$description = Request::input("description");

		$about = $name["About"];
		$mission = $name["Mission"];
		$vision = $name["Vision"];
		
		$abouts = $description["About"];
		$missions = $description["Mission"];
		$visions = $description["Vision"];

		$date = date('Y-m-d H:i:s');

		DB::table("tbl_about")->where("about_name", $about)->update(['about_description' => $abouts, 'created_at' => $date, 'updated_at' => $date]);
		DB::table("tbl_about")->where("about_name", $mission)->update(['about_description' => $missions, 'created_at' => $date, 'updated_at' => $date]);
		DB::table("tbl_about")->where("about_name", $vision)->update(['about_description' => $visions, 'created_at' => $date, 'updated_at' => $date]);

        return Redirect::to("/admin/content/about");
	}


	public function super_test()
	{
		return "super_test";
	}	
}