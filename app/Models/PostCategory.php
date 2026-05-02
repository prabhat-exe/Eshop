<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
class PostCategory extends Model
{
    protected $fillable=['title','slug','status'];

    public function posts(){
        return $this->hasMany('App\Models\Post','post_cat_id','id')->where('status','active');
    }

    public function post(){
        return $this->posts();
    }

    public static function getBlogByCategory($slug){
        return PostCategory::with('posts')->where('slug',$slug)->first();
    }
}
