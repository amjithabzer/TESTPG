<?php

namespace App\Helpers;

class Helper
{
    public static function sign ($params) {
        return self::signData(self::buildDataToSign($params), '44e5fef0-d480-42f2-9211-86c3688642ef');
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
        $data = "merchant.200190700101:d12bbccc53d0f25b9aea69abf05c44a3";
        return base64_encode($data);
    }


}
