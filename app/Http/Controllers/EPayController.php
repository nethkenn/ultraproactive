<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Classes\Ventaja;


class EPayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

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

    public function signIn()
    {

        
        $signature = "";
        try
        { 

            $pem_path = str_replace('\\',"/",storage_path());
            $certFile = 'file:///'.$pem_path . "/demo.pem";  
            $baseUrl = "http://121.58.224.179/VentajaAPI/api/";
            $method = "Process";


            $params = new Ventaja();       
            $params->id = "130081500001";
            $params->uid = "teller";
            $params->pwd = "p@ssw0rD";
            $params->code = 101;

            // str_replace(search, replace, subject)


        



            // note: you can create a class like RequestParam for each or generate it as a string and use json_decode
            $params->data = json_decode('{"lastName":"NATIVIDAD","firstName":"HENRY","middleName":"VILLANUEVA","birthDate":"05/06/1960"}');
           
            $res = $this->callApi($baseUrl . $method, $params, $certFile);

            echo json_encode($res);
        }
        catch (Exception $e)
        { 
            die($e->getMessage());
        }
    }

}



