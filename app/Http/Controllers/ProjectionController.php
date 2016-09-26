<?php namespace App\Http\Controllers;
use Request;
class ProjectionController extends Controller
{
    public function index()
    {
        if(Request::isMethod("post"))
        {
            $data["payin"] = $payin = Request::input("payin");
            $data["per_pair"] = $per_pair = Request::input("per_pair");
            $data["direct"] = $direct = Request::input("direct");

            $data["_projection"] = null;
            $slot_accumulate = 0;


            for($level=1;$level<=30;$level++)
            {
                $data["_projection"][$level]["level"] = $level;
                $data["_projection"][$level]["slot_count"] = pow(2, $level-1);
                $slot_accumulate += $data["_projection"][$level]["slot_count"];
                $data["_projection"][$level]["total_slot_count"] = $slot_accumulate;
                $data["_projection"][$level]["total_payin"] = $slot_accumulate * $payin;
                $data["_projection"][$level]["binary_payout"] = $this->compute_payout($level+1, $per_pair);
                $data["_projection"][$level]["direct_referral"] = ($slot_accumulate-1) * $direct;

                $data["_projection"][$level]["total_payout"] =  $data["_projection"][$level]["binary_payout"] + 
                                                                $data["_projection"][$level]["direct_referral"];


                $data["_projection"][$level]["first_member_income"] = (($data["_projection"][$level]["total_slot_count"] - 1) / 2) * $data["per_pair"];

                if($data["_projection"][$level]["total_payin"] > $data["_projection"][$level]["total_payout"])
                {
                    $data["_projection"][$level]["status"] = "<span style='color:green'>GOOD</span>";    
                }
                else
                {
                    $data["_projection"][$level]["status"] = "<span style='color:red'>OVERPAYOUT</span>";  
                }
            }
            return view("projection.projection", $data);    
        }
        else
        {
            return view("projection.projection_form");
        }


        
    }
    public function compute_payout($level, $per_pair)
    {
        $level--;
        $first = 0;
        $second = 0;
        $leftright = 0;
        $payout = 0;
        for($ctr=1;$ctr<=$level;$ctr++)
        {
            $leftright++;
            $first = pow(2, $ctr-1); 
            $second = pow(2, $level - $ctr) - 1;
            $output = $first * $second;
            $payout += $output;
        }

        return $payout * $per_pair;
    }
}