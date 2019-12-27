<?php

namespace VnCoder\Helper;

class WooCommerceAPI
{
    protected $api_key = "ck_18804a433a9194f8153ffbb59893bc307fc681c4";
    protected $api_token = "cs_99ad24f58018258600497fd9e7c2486638da2ee1";
    protected $api_url = "https://mayflower.vn/wp-json/wc/v3/";

    static function createCoupon(){

    }

    function f(){

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://example.com/wp-json/wc/v3/coupons");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n  \"code\": \"10off\",\n  \"discount_type\": \"percent\",\n  \"amount\": \"10\",\n  \"individual_use\": true,\n  \"exclude_sale_items\": true,\n  \"minimum_amount\": \"100.00\"\n}");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_USERPWD, "consumer_key" . ":" . "consumer_secret");

        $headers = array();
        $headers[] = "Content-Type: application/json";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            info('Error:' . curl_error($ch));
            return false;
        }
        curl_close ($ch);
        return $result;
    }
}