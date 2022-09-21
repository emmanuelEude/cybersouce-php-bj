<?php

    require_once __DIR__. DIRECTORY_SEPARATOR .'../vendor/autoload.php';
    require_once __DIR__. DIRECTORY_SEPARATOR .'../ExternalConfiguration.php';


	$requestObjArr = [
		"encryptionType" => "RsaOaep",
		"targetOrigin" =>"http://localhost:8000"
	];

	$requestObj = new CyberSource\Model\GeneratePublicKeyRequest($requestObjArr);

	$format = "JWT";

	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();

	$api_client = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\KeyGenerationApi($api_client);


	$captureContext = '';
	try {
		$apiResponse = $api_instance->generatePublicKey($format, $requestObj);
		print_r($apiResponse);
		$captureContext = $apiResponse[0]["keyId"];

	} catch (Cybersource\ApiException $e) {
		print_r($e->getResponseBody());
		print_r($e->getMessage());
	}

?>