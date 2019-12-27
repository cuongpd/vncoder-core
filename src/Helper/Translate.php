<?php

namespace VnCoder\Helper;

class Translate
{
    public static function run($text, $lang, $format = 'plain')
    {
        $support = self::getSupportedLanguages($lang);
        if (!$support) {
            return $text;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://translate.yandex.net/api/v1.5/tr.json/translate');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'text='.urlencode($text).'&lang='.$lang.'&format='.$format.'&key='.env('YANDEX_API'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($ch));
        curl_close($ch);
        if (array_key_exists('text', $response)) {
            return $response->text[0];
        } else {
            throw new \Exception('This text could not be translated: the string you entered or the language code are maybe invalid. Run getSupportedLanguages() to get the list of supported languages.');
        }
    }

    public static function detectLanguage($text)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://translate.yandex.net/api/v1.5/tr.json/detect');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'text='.urlencode($text).'&key='.env('YANDEX_API'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($ch));
        curl_close($ch);
        if (array_key_exists('lang', $response) && $response->lang != null) {
            return $response->lang;
        } else {
            throw new \Exception('Could not get the language code: the entered string may not be valid.');
        }
    }

    public static function getSupportedLanguages($code = "")
    {
        if (!$code) {
            return false;
        }
        $all = ["af" => "Afrikaans", "am" => "Amharic", "ar" => "Arabic", "az" => "Azerbaijani", "ba" => "Bashkir", "be" => "Belarusian", "bg" => "Bulgarian", "bn" => "Bengali", "bs" => "Bosnian", "ca" => "Catalan", "ceb" => "Cebuano", "cs" => "Czech", "cy" => "Welsh", "da" => "Danish", "de" => "German", "el" => "Greek", "en" => "English", "eo" => "Esperanto", "es" => "Spanish", "et" => "Estonian", "eu" => "Basque", "fa" => "Persian", "fi" => "Finnish", "fr" => "French", "ga" => "Irish", "gd" => "Scottish Gaelic", "gl" => "Galician", "gu" => "Gujarati", "he" => "Hebrew", "hi" => "Hindi", "hr" => "Croatian", "ht" => "Haitian", "hu" => "Hungarian", "hy" => "Armenian", "id" => "Indonesian", "is" => "Icelandic", "it" => "Italian", "ja" => "Japanese", "jv" => "Javanese", "ka" => "Georgian", "kk" => "Kazakh", "km" => "Khmer", "kn" => "Kannada", "ko" => "Korean", "ky" => "Kyrgyz", "la" => "Latin", "lb" => "Luxembourgish", "lo" => "Lao", "lt" => "Lithuanian", "lv" => "Latvian", "mg" => "Malagasy", "mhr" => "Mari", "mi" => "Maori", "mk" => "Macedonian", "ml" => "Malayalam", "mn" => "Mongolian", "mr" => "Marathi", "mrj" => "Hill Mari", "ms" => "Malay", "mt" => "Maltese", "my" => "Burmese", "ne" => "Nepali", "nl" => "Dutch", "no" => "Norwegian", "pa" => "Punjabi", "pap" => "Papiamento", "pl" => "Polish", "pt" => "Portuguese", "ro" => "Romanian", "ru" => "Russian", "si" => "Sinhalese", "sk" => "Slovak", "sl" => "Slovenian", "sq" => "Albanian", "sr" => "Serbian", "su" => "Sundanese", "sv" => "Swedish", "sw" => "Swahili", "ta" => "Tamil", "te" => "Telugu", "tg" => "Tajik", "th" => "Thai", "tl" => "Tagalog", "tr" => "Turkish", "tt" => "Tatar", "udm" => "Udmurt", "uk" => "Ukrainian", "ur" => "Urdu", "uz" => "Uzbek", "vi" => "Vietnamese", "xh" => "Xhosa", "yi" => "Yiddish", "zh" => "Chinese"];

        return isset($all[$code]) ? true : false;
    }

    public static function getLanguages($codes = false)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://translate.yandex.net/api/v1.5/tr.json/getLangs');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'ui=en&key='.env('YANDEX_API'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($ch));
        curl_close($ch);
        if (array_key_exists('langs', $response)) {
            return $codes ? array_keys(json_decode(json_encode($response->langs), true)) : $response->langs;
        } else {
            throw new \Exception('An unknown error has occured while trying to fetch the list of supported languages.');
        }
    }
}
