<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //
    protected $fillable = ['id', 'name'];
    
    public function posts(){
        return $this->belongsToMany('App\Post', 'post_tags', 'tag_id', 'post_id');
    }
    
    public function postTags(){
        return $this->hasMany('App\PostTag', 'tag_id', 'id');
    }
}
