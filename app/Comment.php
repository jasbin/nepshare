<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //setting table name manually n if we ignore this table name will be Posts by default
    protected $table = "comments";

    //primary key
    protected $primaryKey = 'id';

    public function Posts(){
        return $this->belongsTo('App\Posts');
    }
    
}
