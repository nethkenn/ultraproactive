<?php namespace App\Http\Controllers;
use Request;
use App\Tbl_account;
use App\Tbl_admin;
use DB;
use App\Classes\Admin;
use Redirect;
use Session;
use App\Tbl_admin_position_has_module;
use App\Tbl_module;
use gapi;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
	public function __construct()
	{
        $Tbl_module = Tbl_module::firstOrCreate(['url_segment' => 'register_url']);
        $Tbl_module->module_name = 'admin/register_url';
        $Tbl_module->save();

        $data['slot_limit'] = DB::table('tbl_settings')->where('key','slot_limit')->first();

        if(!$data['slot_limit'])
        {
            DB::table('tbl_settings')->insert(['key'=>'slot_limit','value'=>1]);
        }
        
        $admin_info = Admin::info();
        if($admin_info)
        {

            $admin_module = Tbl_admin_position_has_module::module()->where('admin_position_id',$admin_info->admin_position_id )->get();
            $array_segment = $this->get_url_segment(Request::path());

            $_admin_module = null;

            if($admin_module)
            {
                foreach ($admin_module as $key => $value)
                {
                    $_admin_module[] = $value->url_segment;
                    
                }
            }

            if(!DB::table('tbl_settings')->where('key','global_pv_sharing_percentage')->first())
            {
                DB::table('tbl_settings')->insert(['key'=>'global_pv_sharing_percentage','value'=>3]);
            }

            $_admin_module[] = "admin";  
            $_admin_module[] = "account";
            $intersected_array = array_intersect($array_segment, $_admin_module);
            View()->share("admin", $admin_info);
            $access_to_product_codes = Admin::info()->admin_rank_position;
            View()->share('access_to_product_codes',$access_to_product_codes);
            if(Request::path() != "admin" && count($intersected_array) <= 1 && Request::path() != "admin/developer/migration")
            {
                if(Admin::info()->admin_position_id == 1 )
                {
                    return redirect('admin/register_url?new_admin_url='.Request::path())->send();
                }
                // return abort(404);
                   return redirect('admin')->with('not_allow','You are no allowed to access '. Request::path())->send();
                // return view('admin.not_allow');
            }
            // dd($array_segment,$admin_module, $_admin_module);
            // var_dump( $intersected_array);   
        }
        else
        {
            return Redirect::to("admin/login")->send();
        }


	}


    public function get_url_segment($request_path)
    {
        $array_segment = explode("/", $request_path);

        return  $array_segment;
    }

    public function index()
    {
        include('resources/views/sikreto/gapi.class.php');

        $profile_id = "107929951";
        $report_id = "xxxxxxxx";
        $dimensions = array('date');
        $metrics = array('pageviews','visits');
        $sort_metric = array('date'); 
        $filter = null;
        $start_date = date('Y-m-d', strtotime('-15 days'));
        $end_date = date("Y-m-d");
        $start_index = 1;
        $max_results = 10000;

        $ga = new gapi('593916331522-79d647ld3kdmqadbss30a4pads94sqlp@developer.gserviceaccount.com','ultraproactive.p12');

        $ga->requestReportData($profile_id, $dimensions, $metrics, $sort_metric, $filter, $start_date, $end_date, $start_index, $max_results);

        $data['json'] = null;


        foreach($ga->getResults() as $key =>$result)
        {
            $date =  strtotime($result);
            // echo '<strong>' . date("j n", $date) . '</strong><br />';
            // echo 'Pageviews: ' . $result->getPageviews() . ' ';
            // echo 'Visits: ' . $result->getVisits() . '<br />';
            $data['json'][$key]['visits']  = $result->getVisits();
            $data['json'][$key]['day'] =date("m/d/o", $date);
            // $data['json'][$key]['day'] = date("n", $date);

        }
        $data['json'] = json_encode($data['json']);
 
        // echo '<p>Total pageviews: ' . $ga->getPageviews() . ' total visits: ' . $ga->getVisits() . '</p>';

        $data["members"] = DB::table("tbl_account")->count();
        $data["slots"] = DB::table("tbl_slot")->count();
        $data["codes"] = DB::table("tbl_membership_code")->count();
        return view('admin.dashboard.dashboard',$data);
    }
}
