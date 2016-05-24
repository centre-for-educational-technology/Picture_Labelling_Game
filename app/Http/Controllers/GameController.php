<?php

namespace App\Http\Controllers;

use App\GameSession;
use App\Pic;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

use App\Tag;
use Illuminate\Support\Facades\Auth;



class GameController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index() {


    $tags = Tag::all();

    $user = Auth::user();




//    $pic = Pic::orderByRaw("RAND()")->first();

    $pic = Pic::where('id', '=', 13)->first();



    $mySessionsForThatPicture = $user->gameSessions()->where('pic_id', $pic->id)->get();

    $myTags = array();

    if ($mySessionsForThatPicture!=null){

      $tagIds = array();

      foreach ($mySessionsForThatPicture as $mySessionForThatPicture) {
        array_push($tagIds, $mySessionForThatPicture->tag->id);

      }

      $myTags = Tag::find($tagIds);
    }




    //Take random session for that picture and not by me
    $secondPlayerRandomSession = GameSession::where('pic_id', '=', $pic->id)->where('user_id', '<>', Auth::user()->id)->distinct()->orderByRaw("RAND()")->first();



    $secondPlayerName = "";

    //Second player found
    if ($secondPlayerRandomSession!=null){


      $secondPlayerName = $secondPlayerRandomSession->user->name;

      \Debugbar::info($secondPlayerName);

      //Get all tags from that user for that picture
      $secondPlayerSessionsForThatPicture = GameSession::where('pic_id', '=', $pic->id)->where('user_id', '=', $secondPlayerRandomSession->user->id)->get();


      $secondPlayerTags = array();

      foreach ($secondPlayerSessionsForThatPicture as $secondPlayerSessionForThatPicture) {
        $secondPlayerTags[$secondPlayerSessionForThatPicture->tag_id] = Tag::find($secondPlayerSessionForThatPicture->tag_id)->tag;

      }
    }else{

      $secondPlayerName = "you are the first one to tag this picture";
    }






//
////    \Debugbar::info(Auth::user()->id);
    \Debugbar::info($secondPlayerTags);


    return array('tags' => $myTags, 'second_player' => $secondPlayerName, 'pic' => array('id'=> $pic->id, 'url'=> asset('pictures/'.$pic->filename)));


  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(Request $request) {


    //To lower case and remove spaces
    $input_tag = str_replace(' ', '-', strtolower($request->input('tag')['tag']));

    \Debugbar::info($input_tag);

    $similar_tag = Tag::where('tag', 'like', '%' . $input_tag . '%')->first();

    $usedTagFlag=false;

    if(!empty($similar_tag)){
      $tag = $similar_tag;



      //Check if this user already used this tag for this picture
      $usedTag = GameSession::where('tag_id', '=', $similar_tag->id)->where('user_id', '=', Auth::user()->id)->where('pic_id', '=', $request->input('pic'))->first();

      if($usedTag!=null){
        $usedTagFlag = true;
      }

    }else {
      $tag = Tag::create(array(
          'tag' => $input_tag,
      ));
      $usedTagFlag=false;
    }





    $gameSession = GameSession::create(array(
        'user_id' => Auth::user()->id,
        'pic_id' => $request->input('pic'),
        'tag_id' => $tag->id,
    ));


    $gameSession->save();



    return array('tag' => $tag, 'usedTagFlag' => $usedTagFlag);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update(Request $request, $id) {
    $tag = Tag::find($id);
    $tag->tag = $request->input('tag');
    $tag->save();

    return $tag;
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id) {
    Tag::destroy($id);

    GameSession::where('tag_id', '=', $id)->delete();

  }
}
