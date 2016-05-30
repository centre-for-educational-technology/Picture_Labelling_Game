<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaggingStamp extends Model
{
    //

  protected $fillable = array('tag_id', 'game_session_id');


  public function gameSession()
  {
    return $this->belongsTo('App\GameSession');
  }

  public function tag() {
    return $this->belongsTo('App\Tag');
  }
}
