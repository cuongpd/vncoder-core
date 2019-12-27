<?php

namespace VnCoder\Helper;
use VnCoder\Helper\GeoIP\Reader;

class GeoIP
{
    protected $geoDatabaseCountry = HELPER_PATH.'GeoIP/GeoLite2-Country.mmdb';

    public static function get($ip = null)
    {
        if(!$ip) $ip = request()->ip();
        $countryCode = "OTHER";
        $dbReader = new Reader(with(new static)->geoDatabaseCountry);
        $info = $dbReader->get($ip);
        if ($info && isset($info['country']['iso_code'])) {
            $countryCode = $info['country']['iso_code'];
        }
        return $countryCode;
    }

    public static function getInfo($ip = null)
    {
        if(!$ip) $ip = request()->ip();
        $data = [];
        $dbReader = new Reader(with(new static)->geoDatabaseCountry);

        $info = $dbReader->get($ip);
        if ($info) {
            $data['local'] = $info['continent']['names']['en'] ?? '';
            $data['country'] = $info['country']['names']['en'] ?? '';
        }
        return $data;
    }
}
