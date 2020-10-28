<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $fillable = ['user_id', 'title', 'description', 'time_create'];
    
    public function user(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
    
    public function tags(){
        return $this->belongsToMany('App\Tag', 'post_tags', 'post_id', 'tag_id');
    }
    
    public function postTags(){
        return $this->hasMany('App\PostTag', 'post_id', 'id');
    }
}
