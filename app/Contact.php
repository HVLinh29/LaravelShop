<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    public $timestamps = false; 
    protected $fillable = [
    	'info_map', 'info_contact', 'info_logo','info_fanpage'
    ];
    protected $primaryKey = 'info_id';
 	protected $table = 'tbl_contact';
}
