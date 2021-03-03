<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friends extends Model
{
       protected $table = 'friends';
        protected $fillable = [
        'user_id','req_sent', 'req_confirmed',];




       public function user(){
            return $this->belongsTo('App/User','user_id','id');
        }
}
