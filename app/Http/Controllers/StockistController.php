<?php namespace App\Http\Controllers;
use Request;
use DB;
use App\Classes\Stockist;
use Redirect;
use Session;
use gapi;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class StockistController extends Controller
{
	public function __construct()
	{
        $user = Stockist::info();
        if($user)
        {
            View()->share("user", $user);       
        }
        else
        {
            return Redirect::to("stockist/login")->send();
        }
	}
}
