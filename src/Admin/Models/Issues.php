<?php

namespace Backend\Models;

use VnCoder\Models\VnModel;

class Issues extends VnModel
{
    protected $table = 'issues';

//    protected $fillable = ['id','name','description','permission'];


    public function journal()
    {
        return $this->hasMany(Journals::class, 'journalized_id', 'id');
    }
}
