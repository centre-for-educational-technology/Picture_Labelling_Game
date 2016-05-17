<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameSession extends Model
{
    //

  protected $fillable = array('user_id', 'picture_id', 'tag_id');


  public function gamer() {
    return $this->belongsTo('User');
  }

  public function picture() {
    return $this->belongsTo('Picture');
  }

  public function tags() {
    return $this->hasMany('Tag');
  }
}
