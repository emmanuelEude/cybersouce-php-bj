<?php

    require_once __DIR__. DIRECTORY_SEPARATOR .'../vendor/autoload.php';
    require_once __DIR__. DIRECTORY_SEPARATOR .'../ExternalConfiguration.php';

    $commonElement = new CyberSource\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSource\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSource\Api\TransactionDetailsApi($api_client);

    $apiResponse = $api_instance->getTransaction("transaction_id");
    print_r($apiResponse[0]);
    /*
        Make verification that you want
    */
   

?>