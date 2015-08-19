<?php namespace App\Http\Controllers;
use DB;
use Redirect;
use Request;
use App\Classes\Image;

class AdminMindSyncController extends AdminController
{
	public function index()
	{
		$data["_mindsync"] = DB::table("tbl_mindsync")->where("archived", 0)->get();
	
        return view('admin.content.mindsync', $data);
	}
	public function add()
	{
        return view('admin.content.mindsync_add');
	}
	public function add_submit()
	{
		$title = Request::input("title");
		$description = Request::input("description");
		$url = Request::input("video");
		$video_id = explode("?v=", $url); // For videos like http://www.youtube.com/watch?v=...
		if (empty($video_id[1]))
		    $video_id = explode("/v/", $url); // For videos like http://www.youtube.com/watch/v/..

		$video_id = explode("&", $video_id[1]); // Deleting any other params
		$video_id = $video_id[0];
		$image = Request::input("image_file");
		$images = implode(",", $image);
		$date = date('Y-m-d H:i:s');

		DB::table("tbl_mindsync")->insert(['mindsync_title' => $title, 'mindsync_description' => $description, 'mindsync_video' => $video_id, 'mindsync_image' => $images,'created_at' => $date]);

        return Redirect::to("/admin/content/mindsync");
	}	
	public function edit()
	{
		$id = Request::input("id");		
		$data["mindsync"] = DB::table("tbl_mindsync")->where("mindsync_id", $id)->first();
		$image = explode(",", $data["mindsync"]->mindsync_image);
		foreach ($image as $key => $value) 
		{
			$imagee = Image::view($value, "255x255");
			$data["mindsync"]->pictures[$key] = $imagee;
		}
	
		
		$data["mindsync"]->image = $imagee;
        return view('admin.content.mindsync_edit', $data);
	}
	public function edit_submit()
	{
		$id = Request::input("id");
		$title = Request::input("title");
		$description = Request::input("description");
		$url = Request::input("video");
		$video_id = explode("?v=", $url); // For videos like http://www.youtube.com/watch?v=...
		if (empty($video_id[1]))
		    $video_id = explode("/v/", $url); // For videos like http://www.youtube.com/watch/v/..

		$video_id = explode("&", $video_id[1]); // Deleting any other params
		$video_id = $video_id[0];
		$image = Request::input("image_file");
		$date = date('Y-m-d H:i:s');

		DB::table("tbl_mindsync")->where("mindsync_id", $id)->update(['mindsync_title' => $title, 'mindsync_description' => $description, 'mindsync_video' => $video_id, 'mindsync_image' => $image,'updated_at' => $date]);

        return Redirect::to("/admin/content/mindsync");
	}	
	public function delete()
	{
		$id = Request::input("id");

		DB::table("tbl_mindsync")->where("mindsync_id", $id)->update(['archived' => 1]);

        return Redirect::to("/admin/content/mindsync");
	}	
}