<?php

namespace App\Http\Controllers;

use Request;
use App\Http\Controllers\Controller;
use App\Models\Tbl_opportunity;
use Carbon\Carbon;
use App\Classes\Log;
use App\Classes\Admin;
use Redirect;
class AdminOppurtunityController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data["_opportunity"] = Tbl_opportunity::where("archived",0)->get();
        
        return view("admin.content.opportunity.opportunity",$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $data["action"] = "/admin/content/opportunity/add_submit";
        
        if(Request::input("id"))
        {
            $data["opportunity"] = Tbl_opportunity::where("opportunity_id",Request::input("id"))->first();
            $data["action"] = "/admin/content/opportunity/edit_submit";
        }
        
        return view("admin.content.opportunity.opportunity_add",$data);
    }
    
    public function edit_submit()
    {
        $id = Request::input("opportunity_id");
        $title = Request::input("opportunity_title");
        $content = Request::input("opportunity_content");
        $url = Request::input("opportunity_link");
        
		$video_id = explode("?v=", $url); // For videos like http://www.youtube.com/watch?v=...
		if (empty($video_id[1]))
		    $video_id = explode("/v/", $url); // For videos like http://www.youtube.com/watch/v/..

		$video_id = explode("&", $video_id[1]); // Deleting any other params
		$video_id = $video_id[0];
		
		$old = Tbl_opportunity::where('opportunity_id',$id)->first();
		Tbl_opportunity::where("opportunity_id",$id)->update(['opportunity_title' => $title, 'opportunity_content' => $content, 'opportunity_link' => $video_id]);
		
		$new = Tbl_opportunity::where('opportunity_id',$id)->first();
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." Add Opportunity #".$id,serialize($old),serialize($new));

        return Redirect::to("/admin/content/opportunity");
        
    }
    
	public function delete()
	{
		$id = Request::input("id");
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." Delete Opportunity #".$id);
		Tbl_opportunity::where("opportunity_id", $id)->update(['archived' => 1]);

        return Redirect::to("/admin/content/opportunity");
	}	
    public function add_submit()
    {
        $title = Request::input("opportunity_title");
        $content = Request::input("opportunity_content");
        $url = Request::input("opportunity_link");
        
		$video_id = explode("?v=", $url); // For videos like http://www.youtube.com/watch?v=...
		if (empty($video_id[1]))
		    $video_id = explode("/v/", $url); // For videos like http://www.youtube.com/watch/v/..

		$video_id = explode("&", $video_id[1]); // Deleting any other params
		$video_id = $video_id[0];
		
		$date = Carbon::now();
		
		$id = Tbl_opportunity::insertGetId(['opportunity_title' => $title, 'opportunity_content' => $content, 'created_at' => $date, 'opportunity_link' => $video_id]);
		
		$new = Tbl_opportunity::where('opportunity_id',$id)->first();
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." Add Opportunity #".$id,null,serialize($new));

        return Redirect::to("/admin/content/opportunity");
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
