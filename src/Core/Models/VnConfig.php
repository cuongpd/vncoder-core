<?php

namespace VnCoder\Core\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class VnConfig extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $table = '__configs';
    protected $fillable = ['id','name','data'];

    protected $defaultKey = [
        'domain', 'name', 'title', 'description', 'keywords', 'logo', 'photo', 'favicon',
        'author', 'author_link', 'copyright',
        'email', 'phone', 'address'
    ];

    public function webConfig($update = false)
    {
        $cacheKey = 'vncoder_web_configs';
        $data = $this->getCache($cacheKey, $update);
        if ($update || !$data) {
            $data = with(new static)->select('name', 'data')->whereIn('name', with(new static)->defaultKey)->pluck('data', 'name')->toArray();
            $data = json_decode(json_encode($data));
            $this->setCache($cacheKey, $data);
        }
        return $data;
    }

    public function getConfig($key)
    {
        $configs = $this->getConfigs();
        if (isset($configs[$key])) {
            return $configs[$key];
        } else {
            $this->saveConfig($key, '');
            return false;
        }
    }

    public function getConfigs($update = false)
    {
        $cacheKey = 'vncoder_core_configs';
        $data = $this->getCache($cacheKey);
        if ($update || !$data) {
            $data = with(new static)->select('name', 'data')->pluck('data', 'name')->toArray();
            $this->setCache($cacheKey, $data);
        }
        return $data;
    }

    protected function setCache($cacheKey, $data = [], $minutes = 1440)
    {
        if ($data) {
            Cache::put($cacheKey, $data, $minutes);
        }
        return true;
    }

    protected function getCache($cacheKey, $update = false)
    {
        if ($update) {
            return false;
        }
        return Cache::get($cacheKey);
    }

    public function setConfig($data = [])
    {
        foreach ($data as $key => $val) {
            $this->saveConfig($key, $val);
        }
        // Update Cache
        $this->webConfig(true);
        $this->getConfigs(true);
    }

    public function saveConfig($name, $data)
    {
        $record = with(new static)->where('name', $name)->first();
        if (is_null($record)) {
            return with(new static)->create(['name' => $name , 'data' => $data]);
        } else {
            return with(new static)->where('name', $name)->update(['data' => $data]);
        }
    }
}
