<?php

namespace App\Classes;

use \VentajaReqeustParam;
class EPayment
{
	public static function callApi($postUrl, $params, $key)
    {
      // you can also use http://phpseclib.sourceforge.net/ as alternative to signing

        $pkeyid = openssl_pkey_get_private($key);
        openssl_sign(json_encode($params, JSON_UNESCAPED_SLASHES ), $signature, $pkeyid, OPENSSL_ALGO_SHA1);
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




    public static function signIn($method, $code, $data=null)
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
            $params = new VentajaRequestParam();       
            $params->id = "130031400022";
            $params->uid = "teller";
            $params->pwd = "p@ssw0rD";
            $params->code = $code;
            $params->data = $data;
            // note: you can create a class like RequestParam for each or generate it as a string and use json_decode
            // $params->data = json_decode('{"lastName":"NATIVIDAD","firstName":"HENRY","middleName":"VILLANUEVA","birthDate":"05/06/1960"}');
            // $params->data = json_decode('{"lastName":"PONCE","firstName":"MARK ANTHONY","middleName":"ALDAY","birthDate":"31/03/1990"}');
            $res = EPayment::callApi($baseUrl . $method, $params, $certFile);
            
            return $res;

        }
        catch (Exception $e)
        { 
            die($e->getMessage());
        }
    }


    public static function get_field($code)
    {


        $res = EPayment::signIn('GetFields', $code, null);
        $data_field = null;
        if($res['responseCode'] == 100 && $res['data'])
        {
            foreach ((array)$res['data'] as $key => $value)
            {
                $data_field[$key] =  $value;
                $data_field[$key]['value'] =  null;
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

                if($value['name'] == 'agentRefNo')
                {
                    // $data_field[$key]['type'] = 'hidden';
                    unset($data_field[$key]);
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

    public static function validate_field($transaction_code ,$data)
    {

        $res = EPayment::signIn('Validate', $transaction_code, $data);
        return $res;
    }













}
