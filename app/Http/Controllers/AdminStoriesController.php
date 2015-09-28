<?php namespace App\Http\Controllers;
use DB;
use Redirect;
use Request;
use App\Classes\Image;
use App\Classes\Log;
use App\Classes\Admin;
class AdminStoriesController extends AdminController
{
	public function index()
	{
		$data["_stories"] = DB::table("tbl_stories")->where("archived", 0)->get();
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits Stories Maintenance");

        return view('admin.content.stories', $data);
	}
	public function add()
	{
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits Add Stories Maintenance");
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

		$id = DB::table("tbl_stories")->insertGetId(['stories_title' => $title, 'stories_description' => $description, 'created_at' => $date, 'stories_link' => $video_id]);
		
		$new = DB::table("tbl_stories")->where('stories_id',$id)->first();
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." Add Stories #".$id,null,serialize($new));

        return Redirect::to("/admin/content/stories");
	}	
	public function edit()
	{
		$id = Request::input("id");
		$data["stories"] = DB::table("tbl_stories")->where("stories_id", $id)->first();
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits Edit Stories Maintenance ID #".$id);
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

		$old = DB::table("tbl_stories")->where('stories_id',$id)->first();
		DB::table("tbl_stories")->where("stories_id", $id)->update(['stories_title' => $title, 'stories_description' => $description, 'updated_at' => $date, 'stories_link' => $video_id]);
		$new = DB::table("tbl_stories")->where('stories_id',$id)->first();
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." Edit Stories #".$id,serialize($old),serialize($new));

        return Redirect::to("/admin/content/stories");
	}	
	public function delete()
	{
		$id = Request::input("id");
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." Delete Stories #".$id);
		DB::table("tbl_stories")->where("stories_id", $id)->update(['archived' => 1]);

        return Redirect::to("/admin/content/stories");
	}	
}