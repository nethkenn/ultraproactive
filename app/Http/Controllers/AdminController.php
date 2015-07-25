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
        include('/gapi.class.php');

        $ga = new gapi('529499913489-tqo50906hcr6do6elgi18d54inr7rvac@developer.gserviceaccount.com','client_secrets.p12');

        $ga->requestReportData(105785789,array('date'),array('pageviews','visits'));

        // foreach($ga->getResults() as $result)
        // {
        //   echo '<strong>'.$result.'</strong><br />';
        //   echo 'Pageviews: ' . $result->getPageviews() . ' ';
        //   echo 'Visits: ' . $result->getVisits() . '<br />';
        // }

        // echo '<p>Total pageviews: ' . $ga->getPageviews() . ' total visits: ' . $ga->getVisits() . '</p>';
        
        return view('admin.dashboard.dashboard');
    }
}