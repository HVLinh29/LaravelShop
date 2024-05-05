<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    public $timestamps = false;
    protected $fillable = ['category_name','category_slug','meta_keywords','category_status','category_desc','category_parent'];
    protected $primaryKey = 'category_id';
    protected $table = 'tbl_category_product';

    public function product(){
        return $this->hasMany('App\Product');
    }
}
