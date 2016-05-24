<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameSession extends Model
{
    //

  protected $fillable = array('user_id', 'pic_id', 'tag_id');




  public function user()
  {
    return $this->belongsTo('App\User');
  }

  public function picture() {
    return $this->belongsTo('App\Pic');
  }

  public function tag() {
    return $this->belongsTo('App\Tag');
  }
}
