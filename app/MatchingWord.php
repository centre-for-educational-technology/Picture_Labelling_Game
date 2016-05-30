<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatchingWord extends Model
{
  //


  protected $fillable = array('tagging_stamp_id', 'game_session_id');


  public function gameSession()
  {
    return $this->belongsTo('App\GameSession');
  }

  public function taggingStamp()
  {
    return $this->belongsTo('App\TaggingStamp');
  }



}
