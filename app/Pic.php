<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pic extends Model
{
  protected $fillable = array('filename');


  public function gameSessions()
  {
    return $this->hasMany('App\GameSession');
  }
}
