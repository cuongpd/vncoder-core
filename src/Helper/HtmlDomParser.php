<?php


namespace VnCoder\Helper;

require __DIR__ . '/includes/simple_html_dom.php';

class HtmlDomParser
{
    public static function dom($url = "")
    {
        $request = self::request($url);
        if ($request) {
            return self::str_get_html($request);
        }
        return false;
    }

    public static function file_get_html()
    {
        return call_user_func_array('file_get_html', func_get_args());
    }

    public static function str_get_html()
    {
        return call_user_func_array('str_get_html', func_get_args());
    }

    public function innertext()
    {
    }
    public function outertext()
    {
    }
    public function plaintext()
    {
    }

    public static function request($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

        curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

        $headers = array();
        $headers[] = "Cache-Control: max-age=0";
        $headers[] = "Upgrade-Insecure-Requests: 1";
        $headers[] = "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36";
        $headers[] = "Dnt: 1";
        $headers[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8";
        $headers[] = "Accept-Encoding: gzip, deflate, br";
        $headers[] = "Accept-Language: en,vi;q=0.9,zh-CN;q=0.8,zh-TW;q=0.7,zh;q=0.6,ar;q=0.5,pt;q=0.4,es;q=0.3,mg;q=0.2,ja;q=0.1";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            info('Error:' . curl_error($ch));
            return false;
        }
        curl_close($ch);
        return $result;
    }
}
