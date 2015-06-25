<?php namespace App\Classes;
use DB;

class Settings
{
    public static function get($key)
    {
        return DB::table("tbl_settings")->where("key", $key)->pluck("value");
    }
}
