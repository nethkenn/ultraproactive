<?php namespace App\Http\Controllers;
use DB;
use Redirect;
use Request;
use App\Classes\Image;
use App\Classes\Log;
use App\Classes\Admin;

class AdminMindSyncController extends AdminController
{
	public function index()
	{
		$data["category"] = "index";
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits the Mindsync ");
        return view('admin.content.mindsync', $data);
	}
	public function video()
	{
		$data["_mindsync"] = DB::table("tbl_mindsync")->where('mindsync_video', "!=", "")->where("archived", 0)->get();
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits the Mindsync Video ");
		$data["category"] = "video";
        return view('admin.content.mindsync', $data);
	}
	public function image()
	{
		$data["_mindsync"] = DB::table("tbl_mindsync")->where('mindsync_image', "!=", "")->where("archived", 0)->get();
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits the Mindsync Image ");
		foreach ($data["_mindsync"] as $key => $value) 
		{
			$image = $value->mindsync_image;
			$image_view = Image::view($image, "500x500");
			$data["_mindsync"][$key]->image = $image_view;
		}
		$data["category"] = "image";
        return view('admin.content.mindsync', $data);
	}
	public function testimony()
	{
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits the Mindsync Testimony ");
		$data["_mindsync"] = DB::table("tbl_mindsync")->where('mindsync_title', "!=", "")->where('mindsync_description', "!=", "")->where("archived", 0)->get();
		$data["category"] = "testimony";
        return view('admin.content.mindsync', $data);
	}
	//VIDEO
	public function video_add()
	{
		$data["category"] = "video";
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits the Mindsync Add Video ");
        return view('admin.content.mindsync_add', $data);
	}
	public function video_add_submit()
	{
		// $title = Request::input("title");
		// $description = Request::input("description");
		if (null !== (Request::input("video"))) 
		{
			$url = Request::input("video");
			$video_id = explode("?v=", $url); // For videos like http://www.youtube.com/watch?v=...
			if (empty($video_id[1]))
			    $video_id = explode("/v/", $url); // For videos like http://www.youtube.com/watch/v/..

			$video_id = explode("&", $video_id[1]); // Deleting any other params
			$video_id = $video_id[0];
		}
		else
		{
			return Redirect::to("/admin/content/mindsync/video");
		}
		// $image = Request::input("image_file");
		// $images = implode(",", $image);
		$date = date('Y-m-d H:i:s');

		$id = DB::table("tbl_mindsync")->insertGetId(['mindsync_video' => $video_id, 'created_at' => $date]);
		$new = DB::table("tbl_mindsync")->where('mindsync_id',$id)->first();
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." Add a Mindsync Video ",null,serialize($new));

        return Redirect::to("/admin/content/mindsync/video");
	}	
	public function video_edit()
	{
		$id = Request::input("id");		
		$data["category"] = "video";
		$data["mindsync"] = DB::table("tbl_mindsync")->where("mindsync_id", $id)->first();
		// $image = explode(",", $data["mindsync"]->mindsync_image);
		// foreach ($image as $key => $value) 
		// {
		// 	$imagee = Image::view($value, "255x255");
		// 	$data["mindsync"]->pictures[$key] = $imagee;
		// }

		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits Mindsync Video Id #".$id);
        return view('admin.content.mindsync_edit', $data);
	}
	public function video_edit_submit()
	{
		$id = Request::input("id");
		// $title = Request::input("title");
		// $description = Request::input("description");
		$url = Request::input("video");
		$video_id = explode("?v=", $url); // For videos like http://www.youtube.com/watch?v=...
		if (empty($video_id[1]))
		    $video_id = explode("/v/", $url); // For videos like http://www.youtube.com/watch/v/..

		$video_id = explode("&", $video_id[1]); // Deleting any other params
		$video_id = $video_id[0];
		// $image = Request::input("image_file");
		$date = date('Y-m-d H:i:s');
		$old = DB::table("tbl_mindsync")->where("mindsync_id", $id)->first();
		DB::table("tbl_mindsync")->where("mindsync_id", $id)->update(['mindsync_video' => $video_id, 'updated_at' => $date]);
		$new = DB::table("tbl_mindsync")->where("mindsync_id", $id)->first();
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." edit Mindsync Video Id #".$id,serialize($old),serialize($new));
        return Redirect::to("/admin/content/mindsync/video");
	}	
	public function video_delete()
	{
		$id = Request::input("id");

		DB::table("tbl_mindsync")->where("mindsync_id", $id)->update(['archived' => 1]);
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." archive Mindsync Video Id #".$id);
        return Redirect::to("/admin/content/mindsync/video");
	}
	//IMAGE
	public function image_add()
	{
		$data["category"] = "image";
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits Add Mindsync Image");
        return view('admin.content.mindsync_add', $data);
	}
	public function image_add_submit()
	{
		// $title = Request::input("title");
		// $description = Request::input("description");
		// $url = Request::input("video");
		// $video_id = explode("?v=", $url); // For videos like http://www.youtube.com/watch?v=...
		// if (empty($video_id[1]))
		//     $video_id = explode("/v/", $url); // For videos like http://www.youtube.com/watch/v/..

		// $video_id = explode("&", $video_id[1]); // Deleting any other params
		// $video_id = $video_id[0];
		$image = Request::input("image_file");
		$date = date('Y-m-d H:i:s');

		$id = DB::table("tbl_mindsync")->insertGetId(['mindsync_image' => $image, 'created_at' => $date]);
		$new = DB::table('tbl_mindsync')->where('mindsync_id',$id)->first();
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." Add Mindsync Image Id #".$id,null,serialize($new));

        return Redirect::to("/admin/content/mindsync/image");
	}	
	public function image_edit()
	{
		$id = Request::input("id");		
		$data["category"] = "image";
		$data["mindsync"] = DB::table("tbl_mindsync")->where("mindsync_id", $id)->first();
		$image = $data["mindsync"]->mindsync_image;
		$imagee = Image::view($image, "255x255");
		$data["mindsync"]->image = $imagee;

		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits Edit Mindsync Image Id #".$id);
        return view('admin.content.mindsync_edit', $data);
	}
	public function image_edit_submit()
	{
		$id = Request::input("id");
		// $title = Request::input("title");
		// $description = Request::input("description");
		// $url = Request::input("video");
		// $video_id = explode("?v=", $url); // For videos like http://www.youtube.com/watch?v=...
		// if (empty($video_id[1]))
		//     $video_id = explode("/v/", $url); // For videos like http://www.youtube.com/watch/v/..

		// $video_id = explode("&", $video_id[1]); // Deleting any other params
		// $video_id = $video_id[0];
		$image = Request::input("image_file");
		$date = date('Y-m-d H:i:s');
		$old = DB::table('tbl_mindsync')->where('mindsync_id',$id)->first();
		DB::table("tbl_mindsync")->where("mindsync_id", $id)->update(['mindsync_image' => $image,'updated_at' => $date]);
		$new = DB::table('tbl_mindsync')->where('mindsync_id',$id)->first();
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." Edit Mindsync Image Id #".$id,serialize($old),serialize($new));
        return Redirect::to("/admin/content/mindsync/image");
	}	
	public function image_delete()
	{
		$id = Request::input("id");

		DB::table("tbl_mindsync")->where("mindsync_id", $id)->update(['archived' => 1]);
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." archive Mindsync Image Id #".$id);
        return Redirect::to("/admin/content/mindsync/image");
	}	
	//TESTIMONY
	public function testimony_add()
	{
		$data["category"] = "testimony";
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits Mindsync Testimony");
        return view('admin.content.mindsync_add', $data);
	}
	public function testimony_add_submit()
	{
		$title = Request::input("title");
		$description = Request::input("description");

		// $url = Request::input("video");
		// $video_id = explode("?v=", $url); // For videos like http://www.youtube.com/watch?v=...
		// if (empty($video_id[1]))
		//     $video_id = explode("/v/", $url); // For videos like http://www.youtube.com/watch/v/..

		// $video_id = explode("&", $video_id[1]); // Deleting any other params
		// $video_id = $video_id[0];
		// $image = Request::input("image_file");
		$date = date('Y-m-d H:i:s');

		$id = DB::table("tbl_mindsync")->insertGetId(['mindsync_title' => $title, 'mindsync_description' => $description, 'created_at' => $date]);
		$new = DB::table('tbl_mindsync')->where('mindsync_id',$id)->first();
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." Add Mindsync Testimony Id #".$id,null,serialize($new));
        return Redirect::to("/admin/content/mindsync/testimony");
	}	
	public function testimony_edit()
	{
		$id = Request::input("id");		
		$data["category"] = "testimony";
		$data["mindsync"] = DB::table("tbl_mindsync")->where("mindsync_id", $id)->first();
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." Visits Edit Mindsync Testimony Id #".$id);
        return view('admin.content.mindsync_edit', $data);
	}
	public function testimony_edit_submit()
	{
		$id = Request::input("id");
		$title = Request::input("title");
		$description = Request::input("description");
		// $url = Request::input("video");
		// $video_id = explode("?v=", $url); // For videos like http://www.youtube.com/watch?v=...
		// if (empty($video_id[1]))
		//     $video_id = explode("/v/", $url); // For videos like http://www.youtube.com/watch/v/..

		// $video_id = explode("&", $video_id[1]); // Deleting any other params
		// $video_id = $video_id[0];
		// $image = Request::input("image_file");
		$date = date('Y-m-d H:i:s');
		$old = DB::table('tbl_mindsync')->where('mindsync_id',$id)->first();
		DB::table("tbl_mindsync")->where("mindsync_id", $id)->update(['mindsync_title' => $title, 'mindsync_description' => $description, 'updated_at' => $date]);
		$new = DB::table('tbl_mindsync')->where('mindsync_id',$id)->first();
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." Edit Mindsync Testimony Id #".$id,serialize($old),serialize($new));
        return Redirect::to("/admin/content/mindsync/testimony");
	}	
	public function testimony_delete()
	{
		$id = Request::input("id");

		DB::table("tbl_mindsync")->where("mindsync_id", $id)->update(['archived' => 1]);
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." archive Mindsync Testimony Id #".$id);
        return Redirect::to("/admin/content/mindsync/testimony");
	}
}