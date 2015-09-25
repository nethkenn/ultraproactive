<?php namespace App\Http\Controllers;
use DB;
use Redirect;
use Request;
use App\Classes\Image;
use App\Classes\Log;
use App\Classes\Admin;
class AdminNewsController extends AdminController
{
	public function index()
	{
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits News Maintenance");
		$data["_news"] = DB::table("tbl_news")->where("archived", 0)->get();
		foreach ($data["_news"] as $key => $value) {
			$get = $value->news_image;
			$imagee = Image::view($get, "500x500");
			$data["_news"][$key]->image = $imagee;
		}

        return view('admin.content.news', $data);
	}
	public function add()
	{
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits Add News");
        return view('admin.content.news_add');
	}
	public function add_submit()
	{
		$title = Request::input("title");
		$description = Request::input("description");
		$date = date('Y-m-d H:i:s');
		$image = Request::input("image_file");

		$id = DB::table("tbl_news")->insertGetId(['news_title' => $title, 'news_description' => $description, 'news_date' => $date, 'news_image' => $image]);
		$new = DB::table("tbl_news")->where('news_id',$id)->first();
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." Add News #".$id,null,serialize($new));
        return Redirect::to("/admin/content/news");
	}	
	public function edit()
	{
		$id = Request::input("id");
		$data["news"] = DB::table("tbl_news")->where("news_id", $id)->first();
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits Edit News Id #".$id);
		$imagee = Image::view($data["news"]->news_image, "255x255");
		$data["news"]->image = $imagee;

        return view('admin.content.news_edit', $data);
	}
	public function edit_submit()
	{
		$id = Request::input("id");
		$title = Request::input("title");
		$description = Request::input("description");
		$date = date('Y-m-d H:i:s');
		$image = Request::input("image_file");

		$old = DB::table("tbl_news")->where('news_id',$id)->first();

		DB::table("tbl_news")->where("news_id", $id)->update(['news_title' => $title, 'news_description' => $description, 'news_date' => $date, 'news_image' => $image]);
		
		$new = DB::table("tbl_news")->where('news_id',$id)->first();
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." Add News",serialize($old),serialize($new));

        return Redirect::to("/admin/content/news");
	}	
	public function delete()
	{
		$id = Request::input("id");
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits archive News Id #".$id);
		DB::table("tbl_news")->where("news_id", $id)->update(['archived' => 1]);

        return Redirect::to("/admin/content/news");
	}	
}