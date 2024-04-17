<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    public $timestamps = false;
    protected $fillable = ['category_name','meta_keywords','category_status','category_desc'];
    protected $primaryKey = 'category_id';
    protected $table = 'tbl_category_product';
}
