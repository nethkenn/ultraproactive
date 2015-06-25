<?php namespace App\Classes;
use Config;

class Image
{
    public static function view($filename, $size="150x150", $mode="crop")
    {
        $image_server = Config::get('app.image_server');
        $domain = $_SERVER['SERVER_NAME'];
        return $image_server . "view?source=$domain&filename=$filename&size=$size&mode=$mode";
    }
    public static function get_path()
    {
        $image_server = Config::get('app.image_server');
        $domain = Image::giveHost($_SERVER['SERVER_NAME']);
        return $image_server . "uploads/$domain/image/";
    }
    public static function view_main($filename)
    {
        $image_server = Config::get('app.image_server');
        $domain = Image::giveHost($_SERVER['SERVER_NAME']);
        return $image_server . "uploads/$domain/image/$filename/$filename";
    }
    public static function giveHost($host_with_subdomain)
    {
        $array = explode(".", $host_with_subdomain);

        return (array_key_exists(count($array) - 2, $array) ? $array[count($array) - 2] : "").".".$array[count($array) - 1];
    }
}