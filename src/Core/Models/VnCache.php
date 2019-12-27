<?php

namespace VnCoder\Core\Models;

use Illuminate\Support\Facades\Cache;

trait VnCache
{
    // Set Cache
    protected static function setCache($cacheKey, $data = [], $minutes = 1440)
    {
        $cacheKey = with(new static)->getCacheKey($cacheKey);
        if ($data) {
            Cache::put($cacheKey, $data, $minutes);
        }
        return true;
    }

    // Get Cache
    protected static function getCache($cacheKey, $update = false)
    {
        if (env('APP_DEBUG') && !$update) {
            $update = getParam('_update', 0);
        }
        if ($update) {
            return false;
        }
        $cacheKey = with(new static)->getCacheKey($cacheKey);
        return Cache::get($cacheKey);
    }

    // Add Table Prefix to Cache key
    protected function getCacheKey($cacheKey){
        if(property_exists($this, 'table')){
            return 'vn_'.$this->table.'_'.$cacheKey;
        }
        return 'vncoder_'. $cacheKey;
    }
}
