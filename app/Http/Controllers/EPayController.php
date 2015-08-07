<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Classes\Ventaja;
use Request;


class EPayController extends MemberController
{

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

    public function signIn($method, $code)
    {

        
        $signature = "";
        try
        { 

            $pem_path = str_replace('\\',"/",storage_path());
            $certFile = 'file:///'.$pem_path . "/client.private.pem";  
            $baseUrl = "http://121.58.224.179/VentajaAPI/api/";

            // $method = "GetFields";
            // $method = "Validate";
            // $method = "Process";
            // $method = "Inquiry";
            // $method = "Cancel";


            



            $params = new Ventaja();       
            $params->id = "130031400022";
            $params->uid = "teller";
            $params->pwd = "p@ssw0rD";
            $params->code = $code;

            



        



            // note: you can create a class like RequestParam for each or generate it as a string and use json_decode
            $params->data = json_decode('{"lastName":"NATIVIDAD","firstName":"HENRY","middleName":"VILLANUEVA","birthDate":"05/06/1960"}');
            // $params->data = json_decode('{"lastName":"PONCE","firstName":"MARK ANTHONY","middleName":"ALDAY","birthDate":"31/03/1990"}');
            $res = $this->callApi($baseUrl . $method, $params, $certFile);


            return $res;

            // echo json_encode($res);
        }
        catch (Exception $e)
        { 
            die($e->getMessage());
        }
    }

    public function get_field($code)
    {
        $res = $this->signIn('GetFields', $code);
        $data_field = null;
        
        if($res['responseCode'] == 100 && $res['data'])
        {
            foreach ((array)$res['data'] as $key => $value)
            {
                $data_field[$key] =  $value;
                $data_field[$key]['placeholder'] = "";
                $data_field[$key]['true_type'] = $value['type'];

                if($value['type'] == 'string' || $value['type'] == 'bigint' || $value['type']=='integer')
                {
                    $data_field[$key]['type'] = 'text';
                }

                if($value['type'] == 'integer' && is_array($value['data']))
                {
                    $data_field[$key]['type'] = 'select';
                }

               if($value['type'] == 'datetime')
                {
                    $data_field[$key]['type'] = 'date';
                    $data_field[$key]['placeholder'] = 'mm/dd/yyyy';
                
                }

                if($value['name'] == 'emailAddress' && $value['type'] == 'string')
                {
                    $data_field[$key]['type'] = 'email';
                }

                if($value['type'] == 'money')
                {
                    $data_field[$key]['type'] = 'number';
                }


                if($value['type'] == 'integer' && ($value['name'] == 'endMonth' || $value['name'] == 'endYear' || $value['name'] == 'startMonth' || $value['name'] == 'startYear'))
                {
                    $data_field[$key]['type'] = 'number';
                    switch ($value['name'])
                    {
                        case 'endMonth':
                        case 'startMonth':
                            $data_field[$key]['placeholder'] = '(1-12)';
                            break;
                        default:
                            # code...
                            break;
                    }

                }

            }
        }

        return $data_field;
    }


    public function index()
    {
        $data = [];
         $data['_input_field'] = null;
        if(Request::isMethod('get') && Request::input('transaction_code'))
        {

            $data['_input_field'] = $this->get_field(Request::input('transaction_code'));


        }

        return view('member.epayment', $data);
    }

    

}



