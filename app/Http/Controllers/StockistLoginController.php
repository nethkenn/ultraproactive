<?php namespace App\Http\Controllers;
use DB;
use Request;
use Redirect;
use App\Classes\Stockist;
use Session;

class StockistLoginController extends Controller
{
    public function index()
    {
        $data['_error'] = null;
       
        
        if(isset($_POST['username']))
        {
            $user = Stockist::authenticate(Request::input('username'), Request::input('password'));

            if($user)
            {
                Stockist::login($user->stockist_un, Request::input('password'));
                return Redirect::to("stockist");
            }
            else
            {
                $data['_error'] = "Username or password is incorrect.";
            }
        }


        return view('stockist.stockist_login', $data);
    }


    public function logout()
    {
        Session::forget('user');
        return Redirect::to('stockist/login');
    }
}