<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
  protected $fillable = array('tag');

  public function gameSessions()
  {
    return $this->hasMany('App\TaggingStamp');
  }
}
