<?php

namespace VnCoder\Core\Models;

class VnCategory extends VnModel
{
    protected $table = 'site_category';

    protected $fillable = ['id', 'parent_id', 'title', 'description', 'photo'];

    public function child()
    {
        return $this->hasMany(VnCategory::class, 'parent_id' , 'id');
    }

    public function parent(){
        return $this->hasOne(VnCategory::class, 'id' , 'parent_id');
    }

    static function selectData(){
        $data = self::with('child')->where('parent_id',0)->orderBy('id','asc')->get();
        $list = [];
        foreach ($data as $item){
            $list[$item->id] = $item->title;
            if($item->child){
                foreach ($item->child as $child){
                    $list[$child->id] = '----'.$child->title;
                }
            }
        }
        return $list;
    }
}