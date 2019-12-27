<?php

namespace Backend\Models;

use VnCoder\Models\VnModel;

class JournalDetails extends VnModel
{
    protected $table = "journal_details";



    public function customkey()
    {
        return $this->hasOne(CustomFields::class, 'id', 'prop_key');
    }
}
