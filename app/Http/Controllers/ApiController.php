<?php

namespace App\Http\Controllers;
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../public/Resources/ExternalConfiguration.php';
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use CyberSource;
class ApiController extends Controller
{
    //
    public function CreateAuthorization(Request $request)
    {

        if (isset($flag) && $flag == "true") {
            $capture = true;
        } else {
            $capture = false;
        }
        $clientReferenceInformationArr = [
			"code" => "TC50171_3"
        ];
        $clientReferenceInformation = new CyberSource\Model\Ptsv2paymentsClientReferenceInformation($clientReferenceInformationArr);

        $processingInformationArr = [
                "capture" => $capture
        ];
        $processingInformation = new CyberSource\Model\Ptsv2paymentsProcessingInformation($processingInformationArr);

        $paymentInformationCardArr = [
                "number" => "4111111111111111",
                "expirationMonth" => "12",
                "expirationYear" => "2031"
        ];
        $paymentInformationCard = new CyberSource\Model\Ptsv2paymentsPaymentInformationCard($paymentInformationCardArr);

        $paymentInformationArr = [
                "card" => $paymentInformationCard
        ];
        $paymentInformation = new CyberSource\Model\Ptsv2paymentsPaymentInformation($paymentInformationArr);

        $orderInformationAmountDetailsArr = [
                "totalAmount" => "102.21",
                "currency" => "USD"
        ];
        $orderInformationAmountDetails = new CyberSource\Model\Ptsv2paymentsOrderInformationAmountDetails($orderInformationAmountDetailsArr);

        $orderInformationBillToArr = [
                "firstName" => "John",
                "lastName" => "Doe",
                "address1" => "1 Market St",
                "locality" => "san francisco",
                "administrativeArea" => "CA",
                "postalCode" => "94105",
                "country" => "US",
                "email" => "test@cybs.com",
                "phoneNumber" => "4158880000"
        ];
        $orderInformationBillTo = new CyberSource\Model\Ptsv2paymentsOrderInformationBillTo($orderInformationBillToArr);

        $orderInformationArr = [
                "amountDetails" => $orderInformationAmountDetails,
                "billTo" => $orderInformationBillTo
        ];
        $orderInformation = new CyberSource\Model\Ptsv2paymentsOrderInformation($orderInformationArr);

        $requestObjArr = [
                "clientReferenceInformation" => $clientReferenceInformation,
                "processingInformation" => $processingInformation,
                "paymentInformation" => $paymentInformation,
                "orderInformation" => $orderInformation
        ];
        $requestObj = new CyberSource\Model\CreatePaymentRequest($requestObjArr);
        $commonElement = new CyberSource\ExternalConfiguration();
        $config = $commonElement->ConnectionHost();
        $merchantConfig = $commonElement->merchantConfigObject();
        $api_client = new CyberSource\ApiClient($config, $merchantConfig);
	    $api_instance = new CyberSource\Api\PaymentsApi($api_client);
        try {
            $apiResponse = $api_instance->createPayment($requestObj);
            dd($apiResponse);
        } catch (Cybersource\ApiException $e) {
            print_r($e->getResponseBody());
            print_r($e->getMessage());
        }
    }
    public function Payment(Request $request)
    {
        if (isset($flag) && $flag == "true") {
            $capture = true;
        } else {
            $capture = false;
        }

        $clientReferenceInformationArr = [
                "code" => "TC50171_3"
        ];
        $clientReferenceInformation = new CyberSource\Model\Ptsv2paymentsClientReferenceInformation($clientReferenceInformationArr);

        $processingInformationArr = [
                "capture" => $capture
        ];
        $processingInformation = new CyberSource\Model\Ptsv2paymentsProcessingInformation($processingInformationArr);

        $paymentInformationCardArr = [
                "number" => "4111111111111111",
                "expirationMonth" => "12",
                "expirationYear" => "2031"
        ];
        $paymentInformationCard = new CyberSource\Model\Ptsv2paymentsPaymentInformationCard($paymentInformationCardArr);

        $paymentInformationArr = [
                "card" => $paymentInformationCard
        ];
        $paymentInformation = new CyberSource\Model\Ptsv2paymentsPaymentInformation($paymentInformationArr);

        $orderInformationAmountDetailsArr = [
                "totalAmount" => "102.21",
                "currency" => "USD"
        ];
        $orderInformationAmountDetails = new CyberSource\Model\Ptsv2paymentsOrderInformationAmountDetails($orderInformationAmountDetailsArr);

        $orderInformationBillToArr = [
                "firstName" => "John",
                "lastName" => "Doe",
                "address1" => "1 Market St",
                "locality" => "san francisco",
                "administrativeArea" => "CA",
                "postalCode" => "94105",
                "country" => "US",
                "email" => "test@cybs.com",
                "phoneNumber" => "4158880000"
        ];
        $orderInformationBillTo = new CyberSource\Model\Ptsv2paymentsOrderInformationBillTo($orderInformationBillToArr);

        $orderInformationArr = [
                "amountDetails" => $orderInformationAmountDetails,
                "billTo" => $orderInformationBillTo
        ];
        $orderInformation = new CyberSource\Model\Ptsv2paymentsOrderInformation($orderInformationArr);

        $requestObjArr = [
                "clientReferenceInformation" => $clientReferenceInformation,
                "processingInformation" => $processingInformation,
                "paymentInformation" => $paymentInformation,
                "orderInformation" => $orderInformation
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
    public function PayerEntrollment()
    {
        $clientReferenceInformationArr = [
            "code" => 'AMJ'.date('YmdHis')
        ];
        $clientReferenceInformation = new CyberSource\Model\Riskv1decisionsClientReferenceInformation($clientReferenceInformationArr);

        $orderInformationAmountDetailsArr = [
                "currency" => "AED",
                "totalAmount" => "100.00"
        ];
        $orderInformationAmountDetails = new CyberSource\Model\Riskv1authenticationsOrderInformationAmountDetails($orderInformationAmountDetailsArr);

        $orderInformationBillToArr = [
            "firstName" => "AMJITH",
            "lastName" => "K",
            "address1" => "Kottayi House",
            "address2" => "Puthussery",
            "locality" => "Peravoor",
            "administrativeArea" => "CA",
            "postalCode" => "670673",
            "country" => "IN",
            "email" => "amjith.ka@abzer.com",
            "phoneNumber" => "+919400828969"
        ];
        $orderInformationBillTo = new CyberSource\Model\Riskv1authenticationsOrderInformationBillTo($orderInformationBillToArr);

        $orderInformationArr = [
                "amountDetails" => $orderInformationAmountDetails,
                "billTo" => $orderInformationBillTo
        ];
        $orderInformation = new CyberSource\Model\Riskv1authenticationsOrderInformation($orderInformationArr);

        $paymentInformationCardArr = [
            "number" => "2222420000001113",
            "expirationMonth" => "12",
            "expirationYear" => "2022"
        ];
        $paymentInformationCard = new CyberSource\Model\Riskv1authenticationsPaymentInformationCard($paymentInformationCardArr);

        $paymentInformationArr = [
                "card" => $paymentInformationCard,
                "capture" => false
        ];
        $paymentInformation = new CyberSource\Model\Riskv1authenticationsPaymentInformation($paymentInformationArr);

        $buyerInformationArr = [
                "mobilePhone" => 919400828969
        ];
        $buyerInformation = new CyberSource\Model\Riskv1authenticationsBuyerInformation($buyerInformationArr);

        $consumerAuthenticationInformationArr = [
                "transactionMode" => "MOTO"
        ];
        $consumerAuthenticationInformation = new CyberSource\Model\Riskv1decisionsConsumerAuthenticationInformation($consumerAuthenticationInformationArr);

        $requestObjArr = [
                "clientReferenceInformation" => $clientReferenceInformation,
                "orderInformation" => $orderInformation,
                "paymentInformation" => $paymentInformation,
                "buyerInformation" => $buyerInformation,
                "consumerAuthenticationInformation" => $consumerAuthenticationInformation
        ];
        $requestObj = new CyberSource\Model\CheckPayerAuthEnrollmentRequest($requestObjArr);


        $commonElement = new CyberSource\ExternalConfiguration();
        $config = $commonElement->ConnectionHost();
        $merchantConfig = $commonElement->merchantConfigObject();

        $api_client = new CyberSource\ApiClient($config, $merchantConfig);
        $api_instance = new CyberSource\Api\PayerAuthenticationApi($api_client);

        try {
            $apiResponse = $api_instance->checkPayerAuthEnrollment($requestObj);
            print_r(PHP_EOL);
            dd($apiResponse);

            return $apiResponse;
        } catch (Cybersource\ApiException $e) {
            print_r($e->getResponseBody());
            print_r($e->getMessage());
        }
    }
    public function PayerAuthenticationValidation(Request $request)
    {

        $clientReferenceInformationPartnerArr = [
			"developerId" => "7891234",
			"solutionId" => "89012345"
        ];
        $clientReferenceInformationPartner = new CyberSource\Model\Riskv1decisionsClientReferenceInformationPartner($clientReferenceInformationPartnerArr);

        $clientReferenceInformationArr = [
                "code" => "AMJ20220420015852",
                "partner" => $clientReferenceInformationPartner
        ];
        $clientReferenceInformation = new CyberSource\Model\Riskv1decisionsClientReferenceInformation($clientReferenceInformationArr);


        $processingInformationActionList = array();
        $processingInformationActionList[0] = "VALIDATE_CONSUMER_AUTHENTICATION";
        $processingInformationArr = [
                "actionList" => $processingInformationActionList,
                "capture" => true
        ];
        $processingInformation = new CyberSource\Model\Ptsv2paymentsProcessingInformation($processingInformationArr);
        $paymentInformationCardArr = [
                "expirationMonth" => "12",
                "expirationYear" => "2050",
                "number" => "4000000000000002"
        ];
        $orderInformationAmountDetailsArr = [
            "currency" => "AED",
            "totalAmount" => "100.00"
        ];
        $orderInformationAmountDetails = new CyberSource\Model\Riskv1authenticationsOrderInformationAmountDetails($orderInformationAmountDetailsArr);

        $orderInformationLineItems = array();
        $orderInformationLineItems_0 = [
                "unitPrice" => "100",
                "quantity" => 1,
                "taxAmount" => "0.00"
        ];
        $orderInformationLineItems[0] = new CyberSource\Model\Riskv1authenticationresultsOrderInformationLineItems($orderInformationLineItems_0);

        $orderInformationArr = [
                "amountDetails" => $orderInformationAmountDetails,
                "lineItems" => $orderInformationLineItems
        ];
        $orderInformation = new CyberSource\Model\Riskv1authenticationresultsOrderInformation($orderInformationArr);
        $paymentInformationCard = new CyberSource\Model\Riskv1authenticationresultsPaymentInformationCard($paymentInformationCardArr);

        $paymentInformationArr = [
                "card" => $paymentInformationCard
        ];
        $paymentInformation = new CyberSource\Model\Riskv1authenticationresultsPaymentInformation($paymentInformationArr);

        $consumerAuthenticationInformationArr = [
                "authenticationTransactionId" => "X2NWswewB3DC0gu8tTc0",
                "signedPares" => "eNpVUtluwjAQfPdXRHxAfCScWiwBkQqVOERpoX2zkhWJCgYcp6H9+joJ9PDTzqx3vTNr2KQGMXrCuDAoYY55rvboZcmwtROLbV5iOQ6iCdsXPbuJWUvCarTGi4QPNHl20pL7zBdA75C4FiZOlbYSVHwZzxYy7PQF7wC9QQJHNLNIBiEPhQgFaw7Qhiag1RHlAm15Mu/eTFs0WlnXWx2A1jkC8anQ1nzKbi8EegcECnOQqbXnfEBpWZa+bpr4CoFWOQL0d7pVUUW5E33NErmNHpcvwSJ42yWTOVtH84eEL6fr59ev0RBodYNAoixKwYRgbmqP8UG7PxAcaM0TUMdqEBmlue9xxvxK040jcK5eGzWIN3r/Uk5SYQzq+K7pjgjg9XzS6O44l39ip+R3/sm08jq2zr12GPQ63drsGtflmTOnzXhTn9VO0aqG3lZJb1t30b/f8A2TWK1u"
        ];
        $consumerAuthenticationInformation = new CyberSource\Model\Riskv1authenticationresultsConsumerAuthenticationInformation($consumerAuthenticationInformationArr);

        $requestObjArr = [
                "clientReferenceInformation" => $clientReferenceInformation,
                "orderInformation" => $orderInformation,
                "paymentInformation" => $paymentInformation,
                "consumerAuthenticationInformation" => $consumerAuthenticationInformation
        ];
        $requestObj = new CyberSource\Model\ValidateRequest($requestObjArr);


        $commonElement = new CyberSource\ExternalConfiguration();
        $config = $commonElement->ConnectionHost();
        $merchantConfig = $commonElement->merchantConfigObject();

        $api_client = new CyberSource\ApiClient($config, $merchantConfig);
        $api_instance = new CyberSource\Api\PayerAuthenticationApi($api_client);
        //dd($requestObj);
        try {
            $apiResponse = $api_instance->validateAuthenticationResults($requestObj);
            print_r(PHP_EOL);
            print_r($apiResponse);

            return $apiResponse;
        } catch (Cybersource\ApiException $e) {
            print_r($e->getResponseBody());
            print_r($e->getMessage());
        }
    }
    public function PayerAuthentication(Request $request)
    {
        $clientReferenceInformationArr = [
			"code" => 'AMJ'.date('YmdHis')
        ];
        $clientReferenceInformation = new CyberSource\Model\Ptsv2paymentsClientReferenceInformation($clientReferenceInformationArr);

        $processingInformationActionList = array();
        $processingInformationActionList[0] = "CONSUMER_AUTHENTICATION";
        $processingInformationArr = [
                "actionList" => $processingInformationActionList,
                "capture" => false
        ];
        $processingInformation = new CyberSource\Model\Ptsv2paymentsProcessingInformation($processingInformationArr);

        $paymentInformationCardArr = [
                "number" => "4000000000000002",
                "expirationMonth" => "12",
                "expirationYear" => "2050"
        ];
        $paymentInformationCard = new CyberSource\Model\Ptsv2paymentsPaymentInformationCard($paymentInformationCardArr);

        $paymentInformationArr = [
                "card" => $paymentInformationCard
        ];
        $paymentInformation = new CyberSource\Model\Ptsv2paymentsPaymentInformation($paymentInformationArr);

        $orderInformationAmountDetailsArr = [
                "totalAmount" => "100.00",
                "currency" => "AED"
        ];
        $orderInformationAmountDetails = new CyberSource\Model\Ptsv2paymentsOrderInformationAmountDetails($orderInformationAmountDetailsArr);

        $orderInformationBillToArr = [
                "firstName" => "AMJITH",
                "lastName" => "K",
                "address1" => "Kottayi House",
                "address2" => "Puthussery",
                "locality" => "Peravoor",
                "administrativeArea" => "CA",
                "postalCode" => "670673",
                "country" => "IN",
                "email" => "amjith.ka@abzer.com",
                "phoneNumber" => "+919400828969"
        ];
        $orderInformationBillTo = new CyberSource\Model\Ptsv2paymentsOrderInformationBillTo($orderInformationBillToArr);

        $orderInformationArr = [
                "amountDetails" => $orderInformationAmountDetails,
                "billTo" => $orderInformationBillTo
        ];
        $orderInformation = new CyberSource\Model\Ptsv2paymentsOrderInformation($orderInformationArr);

        $consumerAuthenticationInformationArr = [
                "requestorId" => "123123197675",
                "referenceId" => "CybsCruiseTester-8ac0b02f"
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
            dd($apiResponse);

            return $apiResponse;
        } catch (Cybersource\ApiException $e) {
            print_r($e->getResponseBody());
            print_r($e->getMessage());
        }
    }
    public function PaymentAuthorizationValidationPayment()
    {
        $clientReferenceInformationArr = [
			"code" => "AMJ20220420015852"
        ];
        $clientReferenceInformation = new CyberSource\Model\Ptsv2paymentsClientReferenceInformation($clientReferenceInformationArr);

        $processingInformationActionList = array();
        $processingInformationActionList[0] = "VALIDATE_CONSUMER_AUTHENTICATION";
        $processingInformationArr = [
                "actionList" => $processingInformationActionList,
                "capture" => true
        ];
        $processingInformation = new CyberSource\Model\Ptsv2paymentsProcessingInformation($processingInformationArr);
        $orderInformationAmountDetailsArr = [
            "currency" => "AED",
            "totalAmount" => "100.00"
        ];
        $orderInformationAmountDetails = new CyberSource\Model\Riskv1authenticationsOrderInformationAmountDetails($orderInformationAmountDetailsArr);

        $orderInformationLineItems = array();
        $orderInformationLineItems_0 = [
                "unitPrice" => "100",
                "quantity" => 1,
                "taxAmount" => "0.00"
        ];
        $orderInformationLineItems[0] = new CyberSource\Model\Riskv1authenticationresultsOrderInformationLineItems($orderInformationLineItems_0);


        $paymentInformationCardArr = [
            "number" => "2222420000001113",
            "expirationMonth" => "12",
            "expirationYear" => "2022"
        ];
        $paymentInformationCard = new CyberSource\Model\Ptsv2paymentsPaymentInformationCard($paymentInformationCardArr);

        $paymentInformationArr = [
                "card" => $paymentInformationCard
        ];
        $paymentInformation = new CyberSource\Model\Ptsv2paymentsPaymentInformation($paymentInformationArr);

        $orderInformationBillToArr = [
            "firstName" => "AMJITH",
            "lastName" => "K",
            "address1" => "Kottayi House",
            "address2" => "Puthussery",
            "locality" => "Peravoor",
            "administrativeArea" => "CA",
            "postalCode" => "670673",
            "country" => "IN",
            "email" => "amjith.ka@abzer.com",
            "phoneNumber" => "+919400828969"
        ];
        $orderInformationBillTo = new CyberSource\Model\Ptsv2paymentsOrderInformationBillTo($orderInformationBillToArr);

        $orderInformationArr = [
                "billTo" => $orderInformationBillTo,
                "amountDetails" => $orderInformationAmountDetails,
                "lineItems" => $orderInformationLineItems
        ];
        $orderInformation = new CyberSource\Model\Ptsv2paymentsOrderInformation($orderInformationArr);

        $consumerAuthenticationInformationArr = [
                "authenticationTransactionId" => "P8C14W2KfxsLKi3otIb0"
                //"signedPares" => ""
        ];
        $consumerAuthenticationInformation = new CyberSource\Model\Ptsv2paymentsConsumerAuthenticationInformation($consumerAuthenticationInformationArr);

        $requestObjArr = [
                "clientReferenceInformation" => $clientReferenceInformation,
                "orderInformation" => $orderInformation,
                "processingInformation" => $processingInformation,
                "paymentInformation" => $paymentInformation,
                "consumerAuthenticationInformation" => $consumerAuthenticationInformation,

        ];
        $requestObj = new CyberSource\Model\CreatePaymentRequest($requestObjArr);

        //dd($requestObj);
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
