<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    public $timestamps = false; //set time to false
    protected $fillable = [
    	'product_id', 'rating'
        
    ];
    protected $primaryKey = 'id';
 	protected $table = 'tbl_rating';
}
