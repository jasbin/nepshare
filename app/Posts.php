<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    //setting table name manually n if we ignore this table name will be Posts by default
    protected $table = "posts";

    //primary key
    protected $primaryKey = 'id';

    //timestamps
    public $timestamps = true;
    //call using $post -> user -> its attribute name
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function comments(){
        return $this->hasMany('App\Comment');
    }
}
