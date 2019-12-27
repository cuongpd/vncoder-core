<?php

if (!function_exists('newObject')) {
    function newObject()
    {
        return new stdClass();
    }
}

if(!function_exists('getConfig')){
    function getConfig($key , $default = ''){
        $config = app('VnConfig')->getConfig($key);
        return $config ?? $default;
    }
}

if(!function_exists('numberx')){
    function numberx($number = 0 , $rand = true){
        $random = $rand ? rand(0,87) : 0;
        $number = 88*$number+ 120290 + $random;
        return dechex($number);
    }
}

if (!function_exists('getParam')) {
    function getParam($param, $default = "")
    {
        $data = isset($_GET[$param]) ? $_GET[$param] : (isset($_POST[$param]) ? $_POST[$param] : (isset($_REQUEST[$param]) ? $_REQUEST[$param] : $default));
        return trim($data);
    }
}

if (!function_exists('getParamInt')) {
    function getParamInt($aVarName, $aVarAlt = 0)
    {
        return intval(getParam($aVarName, $aVarAlt));
    }
}

if(!function_exists('site_route')){
    function site_route($name, $parameters = [], $secure = null){
        return app('url')->route('frontend.'.$name, $parameters, $secure);
    }
}

if (!function_exists('minify_output')) {
    function minify_output($buffer, $force = false)
    {
        $search = array('/\>[^\S]+/s', '/[^\S]+\</s', '/(\s)+/s');
        $replace = array('> ', ' <', '\\1');
        $buffer = preg_replace($search, $replace, $buffer);
        $buffer = str_replace('> <','><', $buffer);
        return $buffer;
    }
}

if (!function_exists('safe_name')) {
    function safe_name($str = '')
    {
        $str = html_entity_decode($str, ENT_QUOTES, "UTF-8");
        $filter_in = array('#(a|à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)#', '#(A|À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)#', '#(e|è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)#', '#(E|È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)#', '#(i|ì|í|ị|ỉ)#', '#(I|ĩ|Ì|Í|Ị|Ỉ|Ĩ)#', '#(o|ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)#', '#(O|Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)#', '#(u|ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)#', '#(U|Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)#', '#(y|ỳ|ý|ỵ|ỷ|ỹ)#', '#(Y|Ỳ|Ý|Ỵ|Ỷ|Ỹ)#', '#(d|đ)#', '#(D|Đ)#');
        $filter_out = array('a', 'A', 'e', 'E', 'i', 'I', 'o', 'O', 'u', 'U', 'y', 'Y', 'd', 'D');
        $text = preg_replace($filter_in, $filter_out, $str);
        $text = preg_replace('/[^a-zA-Z0-9]/', ' ', $text);
        return trim($text);
    }
}

if (!function_exists('safe_text')) {
    function safe_text($str = '')
    {
        $text = safe_name($str);
        $text = preg_replace('/ /', '-', trim(strtolower($text)));
        $text = preg_replace('/--/', '', $text);
        return trim($text);
    }
}

if (!function_exists('make_dir')) {
    function make_dir($dest, $permissions=0755, $create=true)
    {
        if (!is_dir(dirname($dest))) {
            make_dir(dirname($dest), $permissions, $create);
        } elseif (!is_dir($dest)) {
            mkdir($dest, $permissions, $create);
        } else {
            return true;
        }
    }
}

if (!function_exists('str_limit')) {
    function str_limit($string, $max = 255)
    {
        if (mb_strlen($string, 'utf-8') >= $max) {
            $string = mb_substr($string, 0, $max - 5, 'utf-8').'...';
        }
        return $string;
    }
}

if (!function_exists('is_url')) {
    function is_url($text)
    {
        return filter_var($text, FILTER_VALIDATE_URL) ? true : false;
    }
}

if (!function_exists('time_format')) {
    function time_format($duation = 0)
    {
        if ($duation < 60) {
            return $duation.' phút';
        }
        $h = round($duation/60);
        $p = $duation%60;
        return $p == 0 ? $h.' giờ' : $h.' giờ '.$p.' phút';
    }
}

if (!function_exists('is_mobile')) {
    function is_mobile()
    {
        $aMobileUA = array(
            '/iphone/i' => 'iPhone',
            '/ipod/i' => 'iPod',
            '/android/i' => 'Android',
            '/blackberry/i' => 'BlackBerry',
            '/webos/i' => 'Mobile'
        );

        foreach ($aMobileUA as $sMobileKey => $sMobileOS) {
            if (preg_match($sMobileKey, $_SERVER['HTTP_USER_AGENT'])) {
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('is_phone')) {
    function is_phone($value = '')
    {
        return preg_match('#^(01([0-9]{2})|09[0-9]|08[0-9])(\d{7})$#', $value);
    }
}

if (!function_exists('only_number')) {
    function only_number($input = '')
    {
        return preg_replace("/[^0-9]/", '', $input);
    }
}

if (! function_exists('vn_cookie')) {
    function vn_cookie($key, $default = '')
    {
        if (is_array($key)) {
            foreach ($key as $name => $val) {
                $cookieTime = $val ? TIME_NOW + (86400 * 30) : -1;  // 86400 = 1 day
                setcookie($name, $val, $cookieTime, "/");
            }
        } else {
            return $_COOKIE[$key] ?? $default;
        }
    }
}

if (!function_exists('flash')) {
    function flash($name, $message = null)
    {
        return session()->flash($name, $message);
    }
}

if (!function_exists('flash_message')) {
    function flash_message($message = null)
    {
        return session()->flash('message', $message);
    }
}

if (!function_exists('random_item')) {
    function random_item($arr)
    {
        if(is_array($arr)){
            $total = count($arr);
            if($total > 0){
                return $arr[rand(0, $total - 1)];
            }
        }
        return '';
    }
}

if(!function_exists('loremipsum')){
    // type : word | sentence | paragraph
    function loremipsum($total , $type = 'word'){
        $lorem = app('VnCoder\Helper\LoremIpsum');
        switch ($type) {
            case 'sentence':
                return $lorem->sentences($total);
                break;
            case 'paragraph':
                return $lorem->paragraphs($total, 'p');
                break;
            
            default:
                return $lorem->words($total);
                break;
        }

    }
}

if(!function_exists('deepFlatten')){
    // deepFlatten([1, [2], [[3], 4], 5]); // [1, 2, 3, 4, 5]
    function deepFlatten($items)
    {
        $result = [];
        foreach ($items as $item) {
            if (!is_array($item)) {
                $result[] = $item;
            } else {
                $result = array_merge($result, deepFlatten($item));
            }
        }

        return $result;
    }
}