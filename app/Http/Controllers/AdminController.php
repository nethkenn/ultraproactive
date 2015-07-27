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

class AdminController extends Controller
{
	public function __construct()
	{




        $admin_info = Admin::info();
        if($admin_info)
        {

            $admin_module = Tbl_admin_position_has_module::module()->get();
            $array_segment = $this->get_url_segment(Request::path());

            $_admin_module = null;

            if($admin_module)
            {
                foreach ($admin_module as $key => $value)
                {
                    $_admin_module[] = $value->url_segment;
                    
                    # code...
                }
            }

            $_admin_module[] = "admin";  
            $_admin_module[] = "account";



            $intersected_array = array_intersect($array_segment, $_admin_module);
            if(Request::path() != "admin" && count($intersected_array) <= 1)
            {
                return abort(404);
                  
            }


            // dd($array_segment,$admin_module, $_admin_module);
            // var_dump( $intersected_array);




            View()->share("admin", $admin_info);



           
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
        include('/resources/views/sikreto/gapi.class.php');

        $profile_id = "105785789";
        $report_id = "xxxxxxxx";
        $dimensions = array('date');
        $metrics = array('pageviews','visits');
        $sort_metric = array('date'); 
        $filter = null;
        $start_date = date('Y-m-d', strtotime('-15 days'));
        $end_date = date("Y-m-d");
        $start_index = 1;
        $max_results = 10000;

        $ga = new gapi('529499913489-tqo50906hcr6do6elgi18d54inr7rvac@developer.gserviceaccount.com','client_secrets.p12');

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
        
        return view('admin.dashboard.dashboard',$data);
    }
}
