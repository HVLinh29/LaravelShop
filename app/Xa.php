<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Xa extends Model
{
    public $timestamps = false;
    protected $fillable = ['name_xaphuong','type','maqh'];
    protected $primaryKey = 'xaid';
    protected $table = 'tbl_xaphuongthitran';
}
