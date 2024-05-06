<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $timestamps = false;
    protected $fillable = ['post_title','post_desc','post_content','post_meta_desc','post_keywords','post_status',
    'post_image','cate_post_id','post_slug','post_view'];
    protected $primaryKey = 'post_id';
    protected $table = 'tbl_posts';

    public function cate_post(){
        return $this->belongsTo('App\CatePost','cate_post_id');
    }
}
