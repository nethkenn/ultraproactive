<?php namespace App\Http\Controllers;
use DB;
use Redirect;
use Request;
use App\Classes\Image;

class AdminStoriesController extends AdminController
{
	public function index()
	{
		$data["_stories"] = DB::table("tbl_stories")->where("archived", 0)->get();

        return view('admin.content.stories', $data);
	}
	public function add()
	{
        return view('admin.content.stories_add');
	}
	public function add_submit()
	{
		$title = Request::input("title");
		$description = Request::input("description");
		$url = Request::input("link");
		$video_id = explode("?v=", $url); // For videos like http://www.youtube.com/watch?v=...
		if (empty($video_id[1]))
		    $video_id = explode("/v/", $url); // For videos like http://www.youtube.com/watch/v/..

		$video_id = explode("&", $video_id[1]); // Deleting any other params
		$video_id = $video_id[0];
		$date = date('Y-m-d H:i:s');

		DB::table("tbl_stories")->insert(['stories_title' => $title, 'stories_description' => $description, 'created_at' => $date, 'stories_link' => $video_id]);

        return Redirect::to("/admin/content/stories");
	}	
	public function edit()
	{
		$id = Request::input("id");
		$data["stories"] = DB::table("tbl_stories")->where("stories_id", $id)->first();

        return view('admin.content.stories_edit', $data);
	}
	public function edit_submit()
	{
		$id = Request::input("id");
		$title = Request::input("title");
		$description = Request::input("description");
		$url = Request::input("link");
		$video_id = explode("?v=", $url); // For videos like http://www.youtube.com/watch?v=...
		if (empty($video_id[1]))
		    $video_id = explode("/v/", $url); // For videos like http://www.youtube.com/watch/v/..

		$video_id = explode("&", $video_id[1]); // Deleting any other params
		$video_id = $video_id[0];
		$date = date('Y-m-d H:i:s');

		DB::table("tbl_stories")->where("stories_id", $id)->update(['stories_title' => $title, 'stories_description' => $description, 'updated_at' => $date, 'stories_link' => $video_id]);

        return Redirect::to("/admin/content/stories");
	}	
	public function delete()
	{
		$id = Request::input("id");

		DB::table("tbl_stories")->where("stories_id", $id)->update(['archived' => 1]);

        return Redirect::to("/admin/content/stories");
	}	
}