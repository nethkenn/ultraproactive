<?php namespace App\Http\Controllers;
use Request;
use DB;
use App\Classes\Stockist;
use Redirect;
use Session;
use gapi;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class StockistDashboardController extends StockistController
{
    public function index()
    {
        include('resources/views/sikreto/gapi.class.php');

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
        return view('stockist.dashboard',$data);
    }
}
