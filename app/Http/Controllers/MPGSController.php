<?php

namespace App\Http\Controllers;

use Helper;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class MPGSController extends Controller
{
    public function __construct()
    {
        $this->client = new Client([
            'headers' => [

                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . Helper::CreateApiToken(),
            ]
        ]);
        $this->baseUrl = 'https://test-network.mtf.gateway.mastercard.com/api/rest/version/63/merchant/'.config('app.MPGS_marchant_id');

    }
    public static function CreateApiToken()
    {
        return Helper::CreateApiToken();
    }
    public function CreateSession()
    {
        $response = $this->client->post($this->baseUrl.'/session');
        $response = json_decode($response->getBody()->getContents());
        return $response->session->id;
    }
    public function UpdateSession(Request $request)
    {
        //https://test-adcb.mtf.gateway.mastercard.com/api/rest/version/57/merchant/120810000020/session/SESSION0002436463526N91661134N3
        $content = preg_replace("/\r|\n/", "", $request->getContent());
        $content = preg_replace("/\t/", "", $content);
        $response = $this->client->put($this->baseUrl.'/session/'.$this->CreateSession(),
        [
            'body' => str_replace(' ','',$content)
        ]);
        return $response->getBody()->getContents();
    }
    public function CreateToken(Request $request)
    {
        //https://test-network.mtf.gateway.mastercard.com/api/rest/version/63/merchant/TEST200200004071/token
        $content = preg_replace("/\r|\n/", "", $request->getContent());
        $content = preg_replace("/\t/", "", $content);
        $response = $this->client->post($this->baseUrl.'/token',
        [
            'body' => str_replace(' ','',$content)
        ]);
        return $response->getBody()->getContents();
    }
    public function PaymentAuthorization(Request $request)
    {
        //https://test-adcb.mtf.gateway.mastercard.com/api/rest/version/49/merchant/120810000020/order/order12345678/transaction/Txn12345678
        $TransactionId = 'AMJTXN'.time();
        $OrderId = 'AMJORD'.time();
        $content = preg_replace("/\r|\n/", "", $request->getContent());
        $content = preg_replace("/\t/", "", $content);
        $response = $this->client->put($this->baseUrl.'/order/'.$OrderId.'/transaction/'.$TransactionId,
        [
            'body' => str_replace(' ','',$content)
        ]);
        if($response)
        {
            $responseObj = json_decode($response->getBody()->getContents());
            //return $responseObj;
            $responseHtml = $responseObj->authentication->redirectHtml;
            $requestObj = json_decode(str_replace(' ','',$content));
            $session_id = $requestObj->session->id;
            $dataArray = array(
                'response' => $responseObj,
                'transaction_id' => $TransactionId,
                'order_id' => $OrderId,
                'session_id' => $session_id,
                'url' => url('mpgs/payment/')."/".base64_encode($responseHtml),
                'next_url' => url('api/MPGS/3ds/payer_authentication')."/".$OrderId."/".$TransactionId,
                'payment_request_url' => url('api/MPGS/3ds/pay_request')."/".$OrderId."/".$TransactionId."/".$session_id
            );
            return response($dataArray);
        }
    }
    public function PayerAuthentication($OrderId,$TransactionId,Request $request)
    {
        $content = preg_replace("/\r|\n/", "", $request->getContent());
        $content = preg_replace("/\t/", "", $content);
        $res1 = $this->client->put($this->baseUrl.'/order/'.$OrderId.'/transaction/'.$TransactionId,
        [
            'body' => str_replace(' ','',$content)
        ]);
        $responseObj = json_decode($res1->getBody()->getContents());

        $responseHtml = $responseObj->authentication->redirectHtml;
        $requestObj = json_decode(str_replace(' ','',$content));
        $session_id = $requestObj->session->id;
        $dataArray = array(
            'response' => $responseObj,
            'transaction_id' => $TransactionId,
            'order_id' => $OrderId,
            'url' => url('mpgs/payment/')."/".base64_encode($responseHtml),
            'next_url' => url('api/MPGS/3ds/payer_authentication')."/".$OrderId."/".$TransactionId,
            'payment_request_url' => url('api/MPGS/3ds/pay_request')."/".$OrderId."/".$TransactionId."/".$session_id
        );
        return response($dataArray);
    }
    public function PaymentView($data)
    {
        $data1 = array(
            'data' => base64_decode($data)
        );
        return view('mpgs.payment',compact('data1'));
    }
    public function PaymentRequest($OrderId,$TransactionId,$session_id)
    {
        //dd("ok");
        $AuthenticationBody = array (
            'apiOperation' => 'PAY',
            'authentication' =>
            array (
              'transactionId' => $TransactionId,
            ),
            'order' =>
            array (
              'amount' => '100',
              'currency' => 'AED',
              'reference' => $OrderId,
            ),
            'sourceOfFunds' =>
            array (
              'provided' =>
              array (
                'card' =>
                array (
                  'number' => '4508750015741019',
                  'expiry' =>
                  array (
                    'month' => '01',
                    'year' => '39',
                  ),
                ),
              ),
              'type' => 'CARD',
            ),
            'session' => array(
                'id' => $session_id
            ),
            'transaction' =>
            array (
              'reference' => $OrderId,
            ),
        );
        //return json_encode($AuthenticationBody);
        $response = $this->client->put($this->baseUrl.'/order/'.$OrderId.'/transaction/'.time(),
        [
            'body' => json_encode($AuthenticationBody)
        ]);
        return json_decode($response->getBody()->getContents());
    }
    public function ProcessACSResult(Request $request,$_3dsid)
    {
        $content = preg_replace("/\r|\n/", "", $request->getContent());
        $content = preg_replace("/\t/", "", $content);
        $response = $this->client->post($this->baseUrl.'/3DSecureId/'.$_3dsid ,
        [
            'body' => str_replace(' ','',$content)
        ]);
    }
    public function PaymentRedirect(Request $request)
    {
        dd($request->all());
    }
}
