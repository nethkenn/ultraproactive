<?php

namespace App\Http\Controllers;

use Request;
use App\Http\Controllers\Controller;
use App\Tbl_item_packages;
use App\Models\Tbl_opportunity;
use Carbon\Carbon;
use App\Classes\Log;
use App\Classes\Admin;
use DB;
use Redirect;
use App\Classes\Image;
class AdminItemPackagesController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data["_item_packages"] = DB::table('tbl_item_packages')->where("archived",0)->get();
        
        return view("admin.content.item_packages.item_packages",$data);
    }
  public function add()
    {
        $data["action"] = "/admin/content/item_packages/add_submit";
        
        if(Request::input("id"))
        {
            $data["item_packages"] = DB::table('tbl_item_packages')->where("item_package_id",Request::input("id"))->first();
            
		    $data['item_packages']->item_package_image = $data['item_packages']->item_package_image == 'default.jpg' ? 'resources/assets/img/1428733091.jpg' : Image::view($data['item_packages']->item_package_image, $size="250x250");
            $data["action"] = "/admin/content/item_packages/edit_submit";
        }
        
        return view("admin.content.item_packages.item_packages_add",$data);
    }
    
    public function edit_submit()
    {
        $id = Request::input("item_packages_id");
        $title = Request::input("item_packages_title");
        $image = Request::input("image_file");
		
		$old = DB::table('tbl_item_packages')->where('item_package_id',$id)->first();
		DB::table('tbl_item_packages')->where("item_package_id",$id)->update(['item_package_title' => $title, 'item_package_image' => $image]);
		
		$new = DB::table('tbl_item_packages')->where('item_package_id',$id)->first();
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." Add item_packages #".$id,serialize($old),serialize($new));

        return Redirect::to("/admin/content/item_packages");
    }
    
	public function delete()
	{
		$id = Request::input("id");
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." Delete item_packages #".$id);
		DB::table('tbl_item_packages')->where("item_package_id", $id)->update(['archived' => 1]);

        return Redirect::to("/admin/content/item_packages");
	}	
    public function add_submit()
    {
        $title = Request::input("item_packages_title");
        $image = Request::input("image_file");
        
		$date = Carbon::now();
		
		$id = DB::table('tbl_item_packages')->insertGetId(['item_package_title' => $title, 'item_package_image' => $image, 'created_at' => $date]);
		
		$new = DB::table('tbl_item_packages')->where('item_package_id',$id)->first();
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." Add item_packages #".$id,null,serialize($new));

        return Redirect::to("/admin/content/item_packages");
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
