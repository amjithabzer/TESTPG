<?php

namespace App\Http\Controllers;
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../public/Resources/ExternalConfiguration.php';
use CyberSource\ExternalConfiguration;
use Illuminate\Http\Request;
use CyberSource;
use Helper;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class _3dsController extends Controller
{
    public function PayerAuthenticationSetup(Request $request)
    {
        $clientReferenceInformationPartnerArr = [
			"developerId" => "7891234",
			"solutionId" => "89012345"
        ];
        $clientReferenceInformationPartner = new CyberSource\Model\Riskv1decisionsClientReferenceInformationPartner($clientReferenceInformationPartnerArr);

        $clientReferenceInformationArr = [
                "code" => 'AMJ'.date('YmdHis'),
                "partner" => $clientReferenceInformationPartner
        ];
        $clientReferenceInformation = new CyberSource\Model\Riskv1decisionsClientReferenceInformation($clientReferenceInformationArr);

        $paymentInformationCardArr = [
                "type" => "001",
                "expirationMonth" => "01",
                "expirationYear" => "2025",
                "number" => "4111111111111111"
        ];
        $paymentInformationCard = new CyberSource\Model\Riskv1authenticationsetupsPaymentInformationCard($paymentInformationCardArr);

        $paymentInformationArr = [
                "card" => $paymentInformationCard
        ];
        $paymentInformation = new CyberSource\Model\Riskv1authenticationsetupsPaymentInformation($paymentInformationArr);

        $requestObjArr = [
                "clientReferenceInformation" => $clientReferenceInformation,
                "paymentInformation" => $paymentInformation
        ];
        $requestObj = new CyberSource\Model\PayerAuthSetupRequest($requestObjArr);


        $commonElement = new CyberSource\ExternalConfiguration();
        $config = $commonElement->ConnectionHost();
        $merchantConfig = $commonElement->merchantConfigObject();

        $api_client = new CyberSource\ApiClient($config, $merchantConfig);
        $api_instance = new CyberSource\Api\PayerAuthenticationApi($api_client);

        try {
            $apiResponse = $api_instance->payerAuthSetup($requestObj);
            //print_r(PHP_EOL);
            //return response($apiResponse);

             return response($apiResponse[0]);
        } catch (Cybersource\ApiException $e) {
            print_r($e->getResponseBody());
            print_r($e->getMessage());
        }
    }
    public function DeviceDataCollection(Request $request)
    {
        $currentTime = time();
        $expireTime = 3600; // expiration in seconds - this equals 1hr
        $orderDetails = array(
            "OrderDetails" => array(
                "OrderNumber" =>  time()
            )
        );
        $token = array();
        $token['jti'] = uniqid();
        $token['iss'] = API_KEY_3DS;  // API Key Identifier
        $token['iat'] = $currentTime; // JWT Issued At Time
        $token['exp'] = $currentTime + $expireTime; // JWT Expiration Time
        $token['OrgUnitId'] = ORG_ID_3DS; // Merchant's OrgUnit
        $token['Payload'] = $orderDetails;
        $token['ReferenceId'] = $request->ReferenceId;
        $token['ReturnUrl'] = $request->ReturnUrl;
        $token['ObjectifyPayload'] = true;
        $header 	= array('typ' => 'JWT', 'alg' => 'HS256');
        $segments[] = base64_encode(json_encode($header));
        $segments[] = base64_encode(json_encode($token));
        $signing_input = implode('.', $segments);
        $signature     =  Helper::sign($signing_input);
        $JWT = $signing_input.".".$signature;

        // $response = Http::withOptions([
        //     'debug' => true,
        // ])->post('https://centinelapistag.cardinalcommerce.com/V1/Cruise/Collect', [
        //     'JWT' => $JWT
        // ]);

        //dd($JWT);
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'https://centinelapistag.cardinalcommerce.com/V1/Cruise/Collect', [
            'form_params' => [
                'JWT' => $JWT,
            ]
        ]);
        dd($response);

    }
    public function DeviceDataCollectionOutSide(Request $request,$org_id,$api_key,$secret)
    {
        //dd($org_id);

        //Config::set('cybersource-profiles.SECRET_KEY_3DS', $secret);
        $currentTime = time();
        $expireTime = 3600; // expiration in seconds - this equals 1hr
        $orderDetails = array(
            "OrderDetails" => array(
                "OrderNumber" =>  time()
            )
        );
        $token = array();
        $token['jti'] = uniqid();
        $token['iss'] = $api_key;  // API Key Identifier
        $token['iat'] = $currentTime; // JWT Issued At Time
        $token['exp'] = $currentTime + $expireTime; // JWT Expiration Time
        $token['OrgUnitId'] = $org_id; // Merchant's OrgUnit
        $token['Payload'] = $orderDetails;
        $token['ReferenceId'] = $request->ReferenceId;
        $token['ReturnUrl'] = $request->ReturnUrl;
        $token['ObjectifyPayload'] = true;
        $header 	= array('typ' => 'JWT', 'alg' => 'HS256');
        $segments[] = base64_encode(json_encode($header));
        $segments[] = base64_encode(json_encode($token));
        $signing_input = implode('.', $segments);
        $signature     =  Helper::sign($signing_input);
        $JWT = $signing_input.".".$signature;
        //dd($token);
        // $response = Http::withOptions([
        //     'debug' => true,
        // ])->post('https://centinelapistag.cardinalcommerce.com/V1/Cruise/Collect', [
        //     'JWT' => $JWT
        // ]);

        //dd($JWT);
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'https://centinelapistag.cardinalcommerce.com/V1/Cruise/Collect', [
            'form_params' => [
                'JWT' => $JWT,
            ]
        ]);
        dd($response);

    }
    public function CheckEntrollement(Request $request)
    {
        $clientReferenceInformationPartnerArr = [
			"developerId" => "7891234",
			"solutionId" => "89012345"
        ];
        $clientReferenceInformationPartner = new CyberSource\Model\Riskv1decisionsClientReferenceInformationPartner($clientReferenceInformationPartnerArr);

        $clientReferenceInformationArr = [
                "code" => "AMJ20220530052853",
                "partner" => $clientReferenceInformationPartner
        ];
        $clientReferenceInformation = new CyberSource\Model\Riskv1decisionsClientReferenceInformation($clientReferenceInformationArr);

        $orderInformationAmountDetailsArr = [
                "currency" => "AED",
                "totalAmount" => "100"
        ];
        $orderInformationAmountDetails = new CyberSource\Model\Riskv1authenticationsOrderInformationAmountDetails($orderInformationAmountDetailsArr);

        $orderInformationBillToArr = [
                "address1" => "1 Market St",
                "address2" => "Address 2",
                "administrativeArea" => "CA",
                "country" => "US",
                "locality" => "san francisco",
                "firstName" => "John",
                "lastName" => "Doe",
                "phoneNumber" => "4158880000",
                "email" => "test@cybs.com",
                "postalCode" => "94105"
        ];
        $orderInformationBillTo = new CyberSource\Model\Riskv1authenticationsOrderInformationBillTo($orderInformationBillToArr);

        $orderInformationArr = [
                "amountDetails" => $orderInformationAmountDetails,
                "billTo" => $orderInformationBillTo
        ];
        $orderInformation = new CyberSource\Model\Riskv1authenticationsOrderInformation($orderInformationArr);

        $paymentInformationCardArr = [
                "type" => "001",
                "expirationMonth" => "01",
                "expirationYear" => "2025",
                "number" => "4111111111111111"
        ];
        $paymentInformationCard = new CyberSource\Model\Riskv1authenticationsPaymentInformationCard($paymentInformationCardArr);

        $paymentInformationArr = [
                "card" => $paymentInformationCard
        ];
        $paymentInformation = new CyberSource\Model\Riskv1authenticationsPaymentInformation($paymentInformationArr);
        $consumerAuthenticationInformationArr = [
			"transactionMode" => "MOTO",
			"referenceId" => "64129c2f-1c02-4ad5-9f04-c4f29b88bcb4"
        ];
        $consumerAuthenticationInformation = new CyberSource\Model\Riskv1decisionsConsumerAuthenticationInformation($consumerAuthenticationInformationArr);
        $requestObjArr = [
                "clientReferenceInformation" => $clientReferenceInformation,
                "orderInformation" => $orderInformation,
                "consumerAuthenticationInformation" => $consumerAuthenticationInformation,
                "paymentInformation" => $paymentInformation
        ];
        $requestObj = new CyberSource\Model\CheckPayerAuthEnrollmentRequest($requestObjArr);


        $commonElement = new CyberSource\ExternalConfiguration();
        $config = $commonElement->ConnectionHost();
        $merchantConfig = $commonElement->merchantConfigObject();

        $api_client = new CyberSource\ApiClient($config, $merchantConfig);
        $api_instance = new CyberSource\Api\PayerAuthenticationApi($api_client);

        try {
            $apiResponse = $api_instance->checkPayerAuthEnrollment($requestObj);

            return response($apiResponse[0]);
        } catch (Cybersource\ApiException $e) {
            print_r($e->getResponseBody());
            print_r($e->getMessage());
        }
    }
    public function AuthenticatingEnrolledCards()
    {
        $currentTime = time();
        $expireTime = 3600; // expiration in seconds - this equals 1hr

        $orderDetails = array(
                "ACSUrl" =>  "https://merchantacsstag.cardinalcommerce.com/MerchantACSWeb/pareq.jsp?gold=AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA",
                "Payload" =>  "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",
                "TransactionId" =>  "BN5Qpm0Hb336o65vmi70"
        );
        $token = array();
        $token['jti'] = uniqid();
        $token['iss'] = API_KEY_3DS;  // API Key Identifier
        $token['iat'] = $currentTime; // JWT Issued At Time
        $token['OrgUnitId'] = ORG_ID_3DS; // Merchant's OrgUnit
        $token['ReturnUrl'] = "";
        $token['ReferenceId'] = "AMJ20220518052149";
        $token['Payload'] = $orderDetails;
        $token['ObjectifyPayload'] = true;

        $header 	= array('typ' => 'JWT', 'alg' => 'HS256');
        $segments[] = base64_encode(json_encode($header));
        $segments[] = base64_encode(json_encode($token));

        $signing_input = implode('.', $segments);
        $signature     =  Helper::sign($signing_input);
        $JWT = $signing_input.".".$signature;

        $data = array(
            'JWT' => $JWT,
            'MD' => "BN5Qpm0Hb336o65vmi70"
        );
        return view('test',compact('data'));
    }
    public function AuthorizationWithPayerAuthValidation(Request $request)
    {
        $clientReferenceInformationArr = [
			"code" => "AMJ20220510043601"
        ];
        $clientReferenceInformation = new CyberSource\Model\Ptsv2paymentsClientReferenceInformation($clientReferenceInformationArr);

        $processingInformationActionList = array();
        $processingInformationActionList[0] = "VALIDATE_CONSUMER_AUTHENTICATION";
        $processingInformationArr = [
                "actionList" => $processingInformationActionList,
                "capture" => false
        ];
        $processingInformation = new CyberSource\Model\Ptsv2paymentsProcessingInformation($processingInformationArr);

        $paymentInformationCardArr = [
            "type" => "001",
            "expirationMonth" => "12",
            "expirationYear" => "2025",
            "number" => "4000000000001091"
        ];
        $paymentInformationCard = new CyberSource\Model\Ptsv2paymentsPaymentInformationCard($paymentInformationCardArr);

        $paymentInformationArr = [
                "card" => $paymentInformationCard
        ];
        $paymentInformation = new CyberSource\Model\Ptsv2paymentsPaymentInformation($paymentInformationArr);
        $orderInformationAmountDetailsArr = [
                "currency" => "AED",
                "totalAmount" => "100"
        ];
        $orderInformationAmountDetails = new CyberSource\Model\Riskv1authenticationsOrderInformationAmountDetails($orderInformationAmountDetailsArr);
        $orderInformationBillToArr = [
                "firstName" => "John",
                "lastName" => "Smith",
                "address1" => "201 S. Division St._1",
                "address2" => "Suite 500",
                "locality" => "Foster City",
                "administrativeArea" => "CA",
                "postalCode" => "94404",
                "country" => "US",
                "email" => "accept@cybs.com",
                "phoneNumber" => "6504327113"
        ];
        $orderInformationBillTo = new CyberSource\Model\Ptsv2paymentsOrderInformationBillTo($orderInformationBillToArr);

        $orderInformationArr = [
            "amountDetails" => $orderInformationAmountDetails,
                "billTo" => $orderInformationBillTo
        ];
        $orderInformation = new CyberSource\Model\Ptsv2paymentsOrderInformation($orderInformationArr);

        $consumerAuthenticationInformationArr = [
                "authenticationTransactionId" => "fxbXP5GU7wxKTqqIg050",

        ];
        $consumerAuthenticationInformation = new CyberSource\Model\Ptsv2paymentsConsumerAuthenticationInformation($consumerAuthenticationInformationArr);

        $requestObjArr = [
                "clientReferenceInformation" => $clientReferenceInformation,
                "processingInformation" => $processingInformation,
                "paymentInformation" => $paymentInformation,
                "orderInformation" => $orderInformation,
                "consumerAuthenticationInformation" => $consumerAuthenticationInformation
        ];
        $requestObj = new CyberSource\Model\CreatePaymentRequest($requestObjArr);


        $commonElement = new CyberSource\ExternalConfiguration();
        $config = $commonElement->ConnectionHost();
        $merchantConfig = $commonElement->merchantConfigObject();

        $api_client = new CyberSource\ApiClient($config, $merchantConfig);
        $api_instance = new CyberSource\Api\PaymentsApi($api_client);

        try {
            $apiResponse = $api_instance->createPayment($requestObj);
            print_r(PHP_EOL);
            print_r($apiResponse);

            return $apiResponse;
        } catch (Cybersource\ApiException $e) {
            print_r($e->getResponseBody());
            print_r($e->getMessage());
        }
    }

}
