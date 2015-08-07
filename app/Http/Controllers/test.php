<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Classes\Ventaja

class test extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return "test ventaja";
    }



    public function callApi($postUrl, $params, $key)
    {
    // you can also use http://phpseclib.sourceforge.net/ as alternative to signing
        $pkeyid = openssl_pkey_get_private($key);
        openssl_sign(json_encode($params), $signature, $pkeyid);
        openssl_free_key($pkeyid);

        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => array(
                    'Content-type: application/json',
                    'Signature: ' . base64_encode($signature)
                    ),
                'content' => json_encode($params)
            )
        );       
        $context  = stream_context_create($opts);   
        $response = file_get_contents($postUrl, false, $context);
       
        return json_decode($response, true);
    }


}
