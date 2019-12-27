<?php


namespace Backend\Models;

use VnCoder\Models\VnModel;

class Journals extends VnModel
{
    protected $table = "journals";


    public function details()
    {
        return $this->hasMany(JournalDetails::class, 'journal_id', 'id');
    }
}
