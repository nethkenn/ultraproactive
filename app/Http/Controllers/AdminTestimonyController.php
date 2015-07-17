<?php namespace App\Http\Controllers;
use DB;
use Redirect;
use Request;
use App\Classes\Image;

class AdminTestimonyController extends AdminController
{
	public function index()
	{
		$data["_testimony"] = DB::table("tbl_testimony")->where("archived", 0)->get();

        return view('admin.maintenance.testimony', $data);
	}
	public function add()
	{
        return view('admin.maintenance.testimony_add');
	}
	public function add_submit()
	{
		$text = Request::input("text");
		$person = Request::input("person");
		$position = Request::input("position");
		$date = date('Y-m-d H:i:s');

		DB::table("tbl_testimony")->insert(['testimony_text' => $text, 'testimony_person' => $person, 'testimony_position' => $position, 'created_at' => $date]);

        return Redirect::to("/admin/maintenance/testimony");
	}	
	public function edit()
	{
		$id = Request::input("id");
		$data["testimony"] = DB::table("tbl_testimony")->where("testimony_id", $id)->first();

        return view('admin.maintenance.testimony_edit', $data);
	}
	public function edit_submit()
	{
		$text = Request::input("text");
		$person = Request::input("person");
		$position = Request::input("position");
		$date = date('Y-m-d H:i:s');
		$id = Request::input("id");

		DB::table("tbl_testimony")->where("testimony_id", $id)->update(['testimony_text' => $text, 'testimony_person' => $person, 'testimony_position' => $position, 'updated_at' => $date]);

        return Redirect::to("/admin/maintenance/testimony");
	}	
	public function delete()
	{
		$id = Request::input("id");

		DB::table("tbl_testimony")->where("testimony_id", $id)->update(['archived' => 1]);

        return Redirect::to("/admin/maintenance/testimony");
	}	
}