<?php

    $curl = curl_init();
    
    if(array_key_exists("redirect_url",$_GET) && $_GET["redirect_url"]!=null){
        $redirect_url=$_GET["redirect_url"];
    }

    if(array_key_exists("order_id",$_GET) && $_GET["order_id"]!=null){
        $order_id=$_GET["order_id"];
    }


    if($order_id!=null){
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.test.com/api/get-order-data/".$order_id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
              
                ),
            ));
        
            $response = curl_exec($curl);
        
            curl_close($curl);
        
            $order=null;
            $decode=json_decode($response,true);
            if(array_key_exists('success',$decode)){
                if($decode['success']==true){
                    if(array_key_exists('data',$decode)){
                        
                        $order=$decode['data'];
                    }
                }
            }
              
    }
    

?>