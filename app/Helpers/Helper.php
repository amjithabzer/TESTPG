<?php

namespace App\Helpers;

class Helper
{
    public static function sign ($params) {
        return self::signData(self::buildDataToSign($params), SECRET_KEY_3DS);
    }
    public static function signData($data, $secretKey) {
        return base64_encode(hash_hmac(HMAC_SHA256, $data, $secretKey, true));
    }
    public static function buildDataToSign($params) {
            $signedFieldNames = explode(".",$params);
            foreach ($signedFieldNames as $field) {
            //$dataToSign[] = $field . "=" . $params[$field];
            $dataToSign[] = $field;
            }
            return self::commaSeparate($dataToSign);
    }

    public static function commaSeparate ($dataToSign) {
        return implode(".",$dataToSign);
    }
    public static function CreateApiToken()
    {
        $data = "merchant.TEST120800000022:067b275c4037865b6c19afd47e50cf73";
        return base64_encode($data);
    }
    

}
