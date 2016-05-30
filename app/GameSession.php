<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameSession extends Model
{
    //

  protected $fillable = array('user_id', 'competitor_session_id', 'pic_id');




  public function user()
  {
    return $this->belongsTo('App\User');
  }

  public function picture() {
    return $this->belongsTo('App\Pic');
  }

  public function tags() {
    return $this->hasMany('App\TaggingStamp');
  }

}
