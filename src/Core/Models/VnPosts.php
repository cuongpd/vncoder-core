<?php

namespace VnCoder\Core\Models;

class VnPosts extends VnModel
{
    protected $table = 'site_posts';
    protected $fillable = ['id', 'author_id', 'cat_id', 'title', 'description', 'photo', 'content'];
    protected $modelKey = ['author_id', 'category_name', 'photo_url', 'title', 'description'];
    protected $relations = ['category'];

    public function category(){
        return $this->belongsTo(VnCategory::class, 'cat_id', 'id');
    }

    public function getCategoryNameAttribute()
    {
        return $this->category->title;
    }

    public function getPhotoUrlAttribute()
    {
        return $this->photo ? '<img src="'.$this->photo.'" style="max-height:50px;" >' : '';
    }

    static function getRules(){
        return [
            'title' => ['required', 'string', 'max:90'],
            'description' => ['required', 'string', 'between:20,150'],
            'photo' => ['required', 'string'],
        ];
    }

    protected function formOption()
    {
        return [
            'cat_id' => ['type' => 'select2', 'name' => 'Danh mục', 'data' => VnCategory::selectData()],
            'title' => ['type' => 'text' , 'name' => 'Tiêu đề', 'maxlength' => 70],
            'description' => ['type' => 'textarea' , 'name' => 'Mô tả', 'maxlength' => 150],
            'photo' => ['type' => 'photo' , 'name' => 'Ảnh đại diện'],
            'content' => ['type' => 'editor' , 'name' => 'Nội dung'],
        ];
    }
}