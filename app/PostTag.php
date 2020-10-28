<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostTag extends Model
{
    //
    protected $fillable = ['post_id', 'tag_id'];
    
    public function post(){
        return $this->belongsTo('App\Post', 'post_id', 'id');
    }
    
    public function tag(){
        return $this->belongsTo('App\Tag', 'tag_id', 'id');
    }
}
