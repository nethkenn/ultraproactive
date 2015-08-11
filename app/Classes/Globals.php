<?php namespace App\Classes;

use DB;
use App\Tbl_voucher;
use App\Tbl_product_code;
use App\Tbl_membership_code;
use App\Tbl_membership_code_sale;
class Globals
{
    public static function view($filename, $size="150x150", $mode="crop")
    {
        $image_server = Config::get('app.image_server');
        $domain = $_SERVER['SERVER_NAME'];
        return $image_server . "view?source=$domain&filename=$filename&size=$size&mode=$mode";
    }
    public static function hypenate($str)
    {
        return implode("-", str_split($str, 3));
    }
    public static function get_all_active_product_type(){
	    
	    $active_product_type = DB::table('tbl_product_type')->where('product_type_archive', '=', 0)->get();
	    
	    return $active_product_type;
	}
    
     public static function format_slug($slug){
        //foramt string
	    $slug = (str_replace([' ','_'],"-",trim($slug)));
	    
	    //remove the repeating -
	    $slug = preg_replace('/--+/', '-', $slug);
	    
	    return $slug;
     }
     
    public static function x($array) //CLOSE AND SHOW ARRAY VALUE
    {
        echo "<pre>";
        print_r($array);
        echo "</pre>";
        die();
    }
    
    public static function convertToHoursMins($time, $format = '%d:%d') {
        settype($time, 'integer');
        if ($time < 1) {
            return;
        }
        $hours = floor($time / 60);
        $minutes = ($time % 60);
        return sprintf($format, $hours, $minutes);
    }
    public static function image($filename, $size, $action = "crop", $class="", $alt="")
    {
        $dim = explode("x", $size);
        if($dim[0] == 0 || $dim[1] == 0) 
        {
            return '<img alt="' . $alt . '" class="' . $class . '" src="' .  GT::get_settings("file_server") .  '/images/?action=' . $action . '&size=' . $size . '&f=' . $filename . '">';        
        }
        else
        {
            return '<img alt="' . $alt . '" width="' . $dim[0] . '" height="' . $dim[1] . '" class="' . $class . ' lazy" data-original="' .  GT::get_settings("file_server") .  '/images/?action=' . $action . '&size=' . $size . '&f=' . $filename . '">';    
        }   
    }
    public static function imageraw($filename, $size, $action = "crop")
    {
        return GT::get_settings("file_server") .  '/images/?action=' . $action . '&size=' . $size . '&f=' . $filename;   
    }
    public static function check_admin_access($page)
    {
        $data["officer"] = GT::officer();
        $data["page"] = DB::table("rel_position_access")->where("rel_position_access.officer_position_id", $data["officer"]->officer_position)
                                                        ->join("cms_page", "cms_page.page_id", "=", "rel_position_access.page_id")
                                                        ->where("cms_page.page_url", $page)
                                                        ->first();
                                                        
        return $data["page"];
    }
    public static function get_ip()
    {
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if(filter_var($client, FILTER_VALIDATE_IP))
        {
            $ip = $client;
        }
        elseif(filter_var($forward, FILTER_VALIDATE_IP))
        {
            $ip = $forward;
        }
        else
        {
            $ip = $remote;
        }

        return $ip;
    }
    public static function tag($name, $type, $id)
    {
        return '<span class="popup-user" type="' . $type . '" tag="' . $id . '">' . strtolower($name) . ' </span>';
    }
    public static function tag_transaction($name, $id)
    {
        return '<a target="_blank" class="popup-user" href="voucher/' . Crypt::encrypt($id) . '">' . $name . '</a>';
    }
    public static function insert_audit($by, $by_id, $name, $description)
    {
        $audit = GT::tag($name, $by, $by_id) . " " . $description;
        $insert_audit["audit_by"] = $by;
        $insert_audit["audit_by_id"] = $by_id;
        $insert_audit["audit_description"] = $audit;
        $insert_audit["audit_date"] = GT::get_time();
        $insert_audit["audit_ip"] = GT::get_ip();
        DB::table("tbl_audit_trail")->insert($insert_audit);    
    }
    public static function format_id($i)
    {
        return sprintf("%06d", $i);
    }
    public static function deduct_global_tax_deduction($amount, $return = "amount")
    {
        $tax = 0.1;
        $data["deducted"] = $amount * $tax;
        $data["amount"] = $amount - $data["deducted"]; 
        return $data[$return];    
    }
    public static function restyle_text($input)
    {
        $input = number_format($input);
        $input_count = substr_count($input, ',');
        if($input_count != '0'){
            if($input_count == '1'){
                return substr($input, 0, -4).'k+';
            } else if($input_count == '2'){
                return substr($input, 0, -8).'mil+';
            } else if($input_count == '3'){
                return substr($input, 0,  -12).'bil+';
            } else {
                return;
            }
        } else {
            return $input;
        }
    }
    public static function get_settings($settings_for)
    {
        $xml = simplexml_load_file("assets/xml/settings.xml");
        return $xml->$settings_for;
    }
    public static function nencrypt($number, $mixer = "Reference Number")
    {
        $words = explode(" ", $mixer);
        $acronym = "";

        foreach ($words as $w)
        {
            $acronym .= $w[0];
        }
        
        $number = strtoupper($acronym) . "-" . $number * 13;
        return $number;     
    }
    public static function ndecrypt($number)
    {
        $number = preg_replace("/[^0-9,.]/", "", $number);
        $number = $number / 13;
        return $number;     
    }
    public static function valid_alphanumeric($str)
    {
        $allowed = array(".", "-", "_");

        if ( ctype_alnum( str_replace($allowed, '', $str ) ) )
        {
            return $str;
        }
        else
        {
            return false;
        }
    }
    public static function month($month)
    {
        $data[1] = "January";
        $data[2] = "February";
        $data[3] = "March";
        $data[4] = "Aprial";
        $data[5] = "May";
        $data[6] = "June";
        $data[7] = "July";
        $data[8] = "Auguest";
        $data[9] = "September";
        $data[10] = "October";
        $data[11] = "November";
        $data[12] = "December";  
        
        return $data[$month];  
    }
    public static function checkbox($value)
    {
        if($value == 1)
        {
            $return = '<input type="checkbox" checked  disabled="disabled">';
        }
        else
        {
            $return = '<input type="checkbox" disabled="disabled">';
        }
        
        return $return;
    }
    public static function redirect($url, $title = false, $message = false)
    {
        if($url == "back")
        {
            $url = $_SERVER['HTTP_REFERER'];
        }
        
        if($title == false)
        {
            return Redirect::to($url);
        }
        else
        {
            $noti["title"] = $title;
            $noti["message"] = $message;
            return Redirect::to($url)->with("notification", $noti); 
        }
        

    }
    public static function prevent_access_without_slot()
    {
        if(!GT::slot())
        {
            die();
        }
    }
    public static function checklocal()
    {
        $subdomain = explode('.', $_SERVER['HTTP_HOST']); 
        $subdomain = $subdomain[0];
        if($subdomain != "local"  && $subdomain != "test")
        {
            return false;
        }
        else
        {
            return true;
        }

    }
    public static function fortest()
    {
        $subdomain = explode('.', $_SERVER['HTTP_HOST']); 
		$subdomain = $subdomain[0];
		
        if($subdomain != "local"  && $subdomain != "test")
        {
            die("ACCESS NOT ALLOWED");
        }
    }
    public static function deadline($time)
    {
        
        //Convert to date
        $datestr=$time;//Your date

        $date=strtotime($datestr);//Converted to a PHP date (a second count)

        //Calculate difference
        $diff=$date-time();//time returns current time in seconds
        $days=floor($diff/(60*60*24));//seconds/minute*minutes/hour*hours/day)
        $hours=round(($diff-$days*60*60*24)/(60*60));

        if($days < 0)
        {
            return "<span class='red'>LATE</span>";
        }  
        elseif($days < 1)
        {
            if($hours == 1)
            {
                return "<span class='green'>$hours hour</span>";       
            }
            else
            {
                return "<span class='green'>$hours hours</span>";       
            }    
        }
        elseif($days == 1)
        {
            return $days . " day, $hours hours";      
        }
        else
        {
            return $days . " days, $hours hours";    
        }
        
        

        
    }
    public static function online_ago($tm,$rcs = 0)
    {
        $tm = strtotime($tm);
        $cur_tm = time(); $dif = $cur_tm-$tm;
        $pds = array('second','minute','hour','day','week','month','year','decade');
        $lngh = array(1,60,3600,86400,604800,2630880,31570560,315705600);
        
        for($v = sizeof($lngh)-1; ($v >= 0)&&(($no = $dif/$lngh[$v])<=1); $v--)
        {
            if($v < 0) $v = 0; $_tm = $cur_tm-($dif%$lngh[$v]);    
        }

        if($no > 1)
        {
           $no = floor($no); if($no <> 1) $pds[$v] .='s'; $x=sprintf("%d %s ",$no,$pds[$v]);
           if(($rcs == 1)&&($v >= 1)&&(($cur_tm-$_tm) > 0)) $x .= time_ago($_tm);
           
          
            
            if($pds[$v] != "seconds")
            {
                if(($pds[$v] == "minutes" || $pds[$v] == "minute") && $no < 5)
                {
                    return "<span class='green'>Online</span>";        
                }
                else
                {
                    return $x . ' ago';           
                }
            }
            else
            {
                return "<span class='green'>Online</span>";        
            }
        
           
        }
        else
        {

            return "<span class='green'>Online</span>";        
        }
    }
    public static function time_ago($tm,$rcs = 0)
    {
        $tm = strtotime($tm);
        $cur_tm = time(); $dif = $cur_tm-$tm;
        $pds = array('second','minute','hour','day','week','month','year','decade');
        $lngh = array(1,60,3600,86400,604800,2630880,31570560,315705600);
        for($v = sizeof($lngh)-1; ($v >= 0)&&(($no = $dif/$lngh[$v])<=1); $v--)
        {
            if($v < 0) $v = 0; $_tm = $cur_tm-($dif%$lngh[$v]);    
        }

       

        if($no > 1)
        {
           $no = floor($no); if($no <> 1) $pds[$v] .='s'; $x=sprintf("%d %s ",$no,$pds[$v]);
           if(($rcs == 1)&&($v >= 1)&&(($cur_tm-$_tm) > 0)) $x .= time_ago($_tm);
           return $x . ' ago';   
        }
        else
        {
            return "Just a moment ago...";
        }
      
    }
    public static function show_content($key)
    {
        $content = DB::table("tbl_content")->where("content_key", $key)->first();
        return $content->content_name; 
    }
    public static function get_global($id)
    {
        $content = DB::table("tbl_global")->where("global_id", $id)->first();
        return $content->global_amount; 
    }
    public static function set_global($id, $amount)
    {
        $update = null;
        $update["global_amount"] = $amount;
        DB::table("tbl_global")->where("global_id", $id)->update($update); 
    }
    public static function increment_global($id, $amount)
    {
        DB::select(DB::raw("UPDATE tbl_global_amount SET global_amount = global_amount + $amount WHERE global_id = $id"));
    }
    public static function currency($value)
    {
        echo GT::get_settings("currency") . " " . number_format($value ,2);    
    }

    public static function limit_words($string, $word_limit)
    {
    $words = explode(" ",$string);
    return implode(" ",array_splice($words,0,$word_limit));
    }
 
    public static function truncate($string,$length=100,$append="&hellip;") 
    {
        $string = trim($string);
        if(strlen($string) > $length) 
        {
        $string = wordwrap($string, $length);
        $string = explode("\n",$string);
        $string = array_shift($string) . $append;
        }
        return $string;
    }


    public static function compute_deduction($deduction, $amount)
    {
        if ($deduction >= 1)
        {
            return $deduction;
        }   
        else
        {
            return $deduction * $amount; 
        }
    }
    public static function officer_id()
    {
        return Crypt::decrypt(Session::get('admin'));
    }
    public static function officer()
    {
        $officer_id = Crypt::decrypt(Session::get('admin'));
        $officer_info = DB::table("tbl_officer")->where("officer_id", $officer_id)
                                                ->join("tbl_officer_position", "tbl_officer_position.officer_position_id", "=", "tbl_officer.officer_position")
                                                ->first();
        return $officer_info;
    }
    public static function member()
    {
        $member_id = Crypt::decrypt(Session::get('member'));
        $member_info = DB::table("tbl_member")->where("member_id", $member_id)
                                                ->first();
                                                
        return $member_info;
    }
    public static function member_id()
    {
        return Crypt::decrypt(Session::get('member'));
    }
    public static function stockist()
    {
        $stockist_id = Crypt::decrypt(Session::get('stockist'));
        $stockist_info = DB::table("tbl_stockist")->where("stockist_id", $stockist_id)
                                                ->join("tbl_stockist_type", "tbl_stockist_type.stockist_type_id", "=", "tbl_stockist.stockist_type")
                                                ->first();
        return $stockist_info;
    }
    public static function account()
    {
        $account_id = Crypt::decrypt(Session::get('account'));
        $account_info = DB::table("tbl_account")->where("account_id", $account_id)
                                                ->first();
        return $account_info;
    }
    public static function slot_list()
    {
        $_slots = DB::table("tbl_account_slot")->where("slot_owner", GT::account()->account_id)->get();
        return $_slots;
    }
    public static function encrypt($pure_string, $encryption_key = "!@#$%^&*")
    {
        $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, $encryption_key, utf8_encode($pure_string), MCRYPT_MODE_ECB, $iv);
        return $encrypted_string;
    }

    public static function decrypt($encrypted_string, $encryption_key = "!@#$%^&*")
    {
        $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $encryption_key, $encrypted_string, MCRYPT_MODE_ECB, $iv);
        return $decrypted_string;
    }
    public static function get_slot_info($slot_id)
    {
        $slot_info = DB::table("tbl_account_slot")  ->where("slot_id", $slot_id)
                                                    ->join("tbl_account", "tbl_account.account_id", "=" , "tbl_account_slot.slot_owner")
                                                    ->first();
        return $slot_info;
    }
    public static function slot()
    {        
        if(Session::get('slot') == "") //IF SESSION IS BLANK
        {
            $slot_info = DB::table("tbl_account_slot")->where("slot_owner", GT::account()->account_id)->first();

            if($slot_info)
            {
                Session::put('slot', $slot_info->slot_id);     
            }
            else                             
            {
                $slot_info = false;
            }
        }
        else 
        {
            $slot_info = DB::table("tbl_account_slot")->where("slot_id", Session::get('slot'))->first();  
            
            if(!$slot_info) //IF NOT FOUND
            {
                Session::forget('slot');
                $slot_info = false;      
            }  
                        
        }
        
        if($slot_info)
        {
            if($slot_info->slot_owner != GT::account()->account_id)
            {
                $slot_info = DB::table("tbl_account_slot")->where("slot_owner", GT::account()->account_id)->first();
                
                if($slot_info)
                {
                    Session::put('slot', $slot_info->slot_id);     
                }
                else
                {
                    $slot_info = false;     
                }
            }
        }
        
        return $slot_info;
    }

    public static function get_time()
    {
        return  date("Y-m-d H:i:s", time());    
    }  
    public static function show_time($time, $format = false)
    {
        if($format)
        {
            return  date($format,  strtotime($time));    
        }
        else
        {
            return  date("m/d/Y",  strtotime($time)) . " @ " .  date("h:i A", strtotime($time));    
        }
    }
    public static function setvar($var, $data, $varcontainer)
    {
        if($varcontainer == "")
        {
            $varcontainer[$data] = $var;
            $return = serialize($varcontainer);
        }
        else
        {
            $variable = unserialize($varcontainer);  
            $variable[$data] = $var;
            $return = serialize($variable);
        }
        
        return $return; 
    }
    public static function getvar($var = "", $data, $default = 0)
    {  
        if($var == "")
        {
            $return = $default;
        }
        else
        {
            $variable = unserialize($var);  
            
            if(isset($variable[$data]))
            {
                return $variable[$data];
            }
            else
            {
                $return = $default;    
            }
        }
        
        return $return; 
    }


    public static function emptyDirectory($dirname,$self_delete=false)
    {
       if (is_dir($dirname))
          $dir_handle = opendir($dirname);
       if (!$dir_handle)
          return false;
       while($file = readdir($dir_handle)) {
          if ($file != "." && $file != "..") {
             if (!is_dir($dirname."/".$file))
                @unlink($dirname."/".$file);
             else
                emptyDirectory($dirname.'/'.$file,true);    
          }
       }
       closedir($dir_handle);
       if ($self_delete){
            @rmdir($dirname);
       }   
       return true;
    }

    public static function multiexplode($delimiters,$string) 
    {
        $ready = str_replace($delimiters, $delimiters[0], $string);
        $launch = explode($delimiters[0], $ready);
        return  $launch;
    }

    public static function strip_tags_content($text, $tags = '', $invert = FALSE) {

      preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags);
      $tags = array_unique($tags[1]);
       
      if(is_array($tags) AND count($tags) > 0) {
        if($invert == FALSE) {
          return preg_replace('@<(?!(?:'. implode('|', $tags) .')\b)(\w+)\b.*?>.*?</\1>@si', '', $text);
        }
        else {
          return preg_replace('@<('. implode('|', $tags) .')\b.*?>.*?</\1>@si', '', $text);
        }
      }
      elseif($invert == FALSE) {
        return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text);
      }
      return $text;
    }


    public static function in_multiarray($elem, $array,$field)
    {
        $top = sizeof($array) - 1;
        $bottom = 0;
        while($bottom <= $top)
        {
            if($array[$bottom][$field] == $elem)
                return true;
            else 
                if(is_array($array[$bottom][$field]))
                    if(in_multiarray($elem, ($array[$bottom][$field])))
                        return true;

            $bottom++;
        }        
        return false;
    }

    public static function code_generator()
    {
        
        $chars="0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $res = "";
        for ($i = 0; $i < 8; $i++) {
            $res .= $chars[mt_rand(0, strlen($chars)-1)];
        }

        return $res;

    }

    public static function create_voucher_code()
    {
        $stop=false;
        while($stop==false)
        {
            $code = Globals::code_generator();

            $check = Tbl_voucher::where('voucher_code', $code)->first();
            if($check==null)
            {
                $stop = true;
            }
        }
        return $code;
    }


    public static function create_product_code()
    {
        $stop=false;
        while($stop==false)
        {
            $code = Globals::code_generator();

            $check = Tbl_product_code::where('code_activation', $code)->first();
            if($check==null)
            {
                $stop = true;
            }
        }
        return $code;
    }


    public static function create_membership_code()
    {
        $stop=false;
        while($stop==false)
        {
            $code = Globals::code_generator();

            $check = Tbl_membership_code::where('code_activation', $code)->first();
            if($check==null)
            {
                $stop = true;
            }
        }
        return $code;
    }


    public static function create_membership_code_sale()
    {
        $stop=false;
        while($stop==false)
        {
            $code = Globals::code_generator();

            $check = Tbl_membership_code_sale::where('membershipcode_or_code', $code)->first();
            if($check==null)
            {
                $stop = true;
            }
        }
        return $code;
    }



    





}
