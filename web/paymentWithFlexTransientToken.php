<?php
    require_once __DIR__. DIRECTORY_SEPARATOR .'../vendor/autoload.php';
    require_once __DIR__. DIRECTORY_SEPARATOR .'../ExternalConfiguration.php';
	
	$apiResponse = '';
	$transientTokenJWK = $transientToken;
	$payement_success=false;
	$payement_payement_have_response=false;
	$response_msg="";
	if($order!=null && $transientTokenJWK!=null ){

		$clientReferenceInformationArr = [
			"code" => $order['code']."__".time()
		];
		$clientReferenceInformation = new CyberSource\Model\Ptsv2paymentsClientReferenceInformation($clientReferenceInformationArr);

		$orderInformationAmountDetailsArr = [
			"totalAmount" => $order['total_amount'],
			"currency" => "XOF"
		];
		$orderInformationAmountDetails = new CyberSource\Model\Ptsv2paymentsOrderInformationAmountDetails($orderInformationAmountDetailsArr);

		$orderInformationBillToArr = [
			"firstName" => $order['customer']['firstname'],
			"lastName" =>  $order['customer']['lastname'],
			"address1" => $order['facturation_address']['information'],
			"locality" => $order['facturation_address']['state'],
			//"administrativeArea" => "MI",
			"postalCode" =>  $order['facturation_address']['code_postal'],
			"country" => $order['facturation_address']['country']['name'] ,
			"district" => $order['facturation_address']['district']['name'],
			//"buildingNumber" => "123",
			"email" => $order['customer']['email'],
			"phoneNumber" =>$order['customer']['phone']
		];
		$orderInformationBillTo = new CyberSource\Model\Ptsv2paymentsOrderInformationBillTo($orderInformationBillToArr);

		$orderInformationArr = [
			"amountDetails" => $orderInformationAmountDetails,
			"billTo" => $orderInformationBillTo
		];
		$orderInformation = new CyberSource\Model\Ptsv2paymentsOrderInformation($orderInformationArr);

		$tokenInformationArr = [
			"transientTokenJwt" => $transientTokenJWK
		];
		$tokenInformation = new CyberSource\Model\Ptsv2paymentsTokenInformation($tokenInformationArr);

		$requestObjArr = [
			"clientReferenceInformation" => $clientReferenceInformation,
			"orderInformation" => $orderInformation,
			"tokenInformation" => $tokenInformation
		];
		$requestObj = new CyberSource\Model\CreatePaymentRequest($requestObjArr);


		$commonElement = new CyberSource\ExternalConfiguration();
		$config = $commonElement->ConnectionHost();
		$merchantConfig = $commonElement->merchantConfigObject();

		$api_client = new CyberSource\ApiClient($config, $merchantConfig);
		$api_instance = new CyberSource\Api\PaymentsApi($api_client);

		try {
			$apiResponse = $api_instance->createPayment($requestObj);
			$payement_payement_have_response=true;
		} catch (Cybersource\ApiException $e) {
			$response_msg=$e->getMessage();
		}
	}	
	if($order!=null && $order['status']=="sold"){
		$payement_success=true;
	}
	if($payement_payement_have_response){
		$curl = curl_init();
		if($apiResponse[0]['status']=="AUTHORIZED"){
			curl_setopt_array($curl, array(
				CURLOPT_URL => "https://api.test.com/api/order/".$apiResponse[0]['id']."/validate-transaction",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_HTTPHEADER => array(),
				));
			
				$verify_response = curl_exec($curl);
			
				curl_close($curl);
			
				$verify_decode=json_decode($verify_response,true);
				if(array_key_exists('success',$verify_decode)){
					if($verify_decode['success']==true){
						echo '<script type="text/javascript">
									window.location = "'.$redirect_uri.'?transactionId='.$apiResponse[0]['id'].'&status='.$apiResponse[0]['status'].'"
								</script>';
					}else{
						$response_msg= $verify_decode['message'];
						print_r($verify_decode['error']);
						print_r($verify_decode['transaction']);
					}
				}
		}else{
			$response_msg= "Paiment non effectué. Statut de la transaction ".$apiResponse[0]['status'];
		}
	}
?>
