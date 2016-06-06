<?php

namespace App\Http\Controllers;

use App\GameSession;
use App\MatchingWord;
use App\Pic;
use App\TaggingStamp;
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
   */
  public function index() {

    $user = Auth::user();

//    $pic = Pic::orderByRaw("RAND()")->first();

    $pic = Pic::where('id', '=', 13)->first();


    //Get taboo words for that picture
    $matchingWordsList = $this->getTabooWords($pic);



//    $mySessionsForThatPicture = $user->gameSessions()->where('pic_id', $pic->id)->get();
//
//    $myTags = array();
//
//    if ($mySessionsForThatPicture!=null){
//
//      $tagIds = array();
//
//
//
//      foreach ($mySessionsForThatPicture as $mySessionForThatPicture) {
//        array_push($tagIds, $mySessionForThatPicture->tag->id);
//
//      }
//
//      $myTags = Tag::find($tagIds);
//    }



    //Take random session for that picture and not by me
    $secondPlayerRandomSession = GameSession::where('pic_id', '=', $pic->id)->where('user_id', '<>', Auth::user()->id)->distinct()->orderByRaw("RAND()")->first();



    $secondPlayerName = "";

    //Second player found
    if ($secondPlayerRandomSession!=null && sizeof($secondPlayerRandomSession)>0){


      $secondPlayerName = $secondPlayerRandomSession->user->name;


//      \Debugbar::info($secondPlayerName);

      //Get all tags from that user for that picture
      $secondPlayerSessionTagsForThatPicture = $secondPlayerRandomSession->tags;

//      \Debugbar::info($secondPlayerSessionTagsForThatPicture);



      //Create a new session
      $myGameSession = GameSession::create(array(
          'user_id' => $user->id,
          'competitor_session_id' => $secondPlayerRandomSession->id,
          'pic_id' => $pic->id,
      ));


      $myGameSession->save();


    }else{

      $secondPlayerName = "you are the first one to tag this picture";

      //Create a new session
      $myGameSession = GameSession::create(array(
          'user_id' => $user->id,
          'competitor_session_id' => null,
          'pic_id' => $pic->id,
      ));


    }

    $myGameSession->save();



//    \Debugbar::info($matchingWordsList);


//
////    \Debugbar::info(Auth::user()->id);
//    \Debugbar::info($myTags);


    return array('my_session_id' => $myGameSession->id, 'second_player' => $secondPlayerName, 'matching_words_list' => $matchingWordsList, 'pic' => array('id'=> $pic->id, 'url'=> asset('pictures/'.$pic->filename)));


  }

  /**
   * Get a list of taboo words for that picture
   */

  public function getTabooWords(Pic $pic){
    //Get taboo words for that picture
    $matchingWordsList = array();
    $matchingWords = MatchingWord::all();

    foreach ($matchingWords as $matchingWord){
      $gameSession = $matchingWord->gameSession;
      if ($gameSession->pic_id == $pic->id){

        $matchingWordsList[$matchingWord->taggingStamp->tag->id] = $matchingWord->taggingStamp->tag->tag;
      }
    }

    return $matchingWordsList;
  }

  

  /**
   * Store a new tag
   *
   */
  public function store(Request $request) {

    //To lower case and remove spaces
    $input_tag = str_replace(' ', '-', strtolower($request->input('tag')['tag']));


    //Check if input tag is not in the list of taboo words
    $inTabooListFlag = false;
    //Get taboo words for that picture
    $pic = Pic::find($request->input('pic'));
    $matchingWords = $this->getTabooWords($pic);



    if(!empty($matchingWords)){

      foreach ($matchingWords as $matchingWord){

        if(strcmp($matchingWord, $input_tag)==0){
          $inTabooListFlag = true;

          return array('tag' => $input_tag, 'usedTagFlag' => false, 'matchingWordAddedFlag' => false, 'inTabooListFlag' => $inTabooListFlag);
        }
      }
    }


    //Check if there is already same tag in table
    $similar_tag = Tag::where('tag', 'like', '%' . $input_tag . '%')->first();

    $usedTagFlag=false;

    //Get my session
    $mySession = GameSession::find($request->input('my_session_id'));


    if($similar_tag != null && sizeof($similar_tag)>0){
      $tag = $similar_tag;



      //Check if this user already used this tag for this picture
      $usedTag = $mySession->tags()->where('tag_id', '=', $similar_tag->id)->first();



//      $usedTag = GameSession::where('tag_id', '=', $similar_tag->id)->where('user_id', '=', Auth::user()->id)->where('pic_id', '=', $request->input('pic'))->first();

      if(!empty($usedTag)){
        $usedTagFlag = true;
      }

    } else {
      $tag = Tag::create(array(
          'tag' => $input_tag,
      ));
      $usedTagFlag=false;
    }


    $matchingWordAddedFlag = false;

    if(!$usedTagFlag){
      $mySession->touch();


      $taggingStamp = TaggingStamp::create(array(
          'tag_id' => $tag->id,
          'game_session_id' => $mySession->id,
      ));


      $taggingStamp->save();



      //Get competitor session
      $competitorSession = GameSession::find($mySession->competitor_session_id);



      if($competitorSession!=null){
        //Get tags for that competitor session game
        $competitorTags = $competitorSession->tags;



        foreach ($competitorTags as $competitorTag){
          if ($competitorTag->tag_id == $tag->id){
            //Matching found

            $matchingWord = MatchingWord::create(array(
                'tagging_stamp_id' => $taggingStamp->id,
                'game_session_id' => $mySession->id,
            ));

            $matchingWord->save();

            $matchingWordAddedFlag = true;

          }
        }

      }
    }




    return array('tag' => $tag, 'usedTagFlag' => $usedTagFlag, 'matchingWordAddedFlag' => $matchingWordAddedFlag, 'inTabooListFlag' => false);
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
   * Remove the tag
   *
   * @param  int  $id
   */
  public function destroy(Request $request, $id) {

    //Get my session
    $mySession = GameSession::find($request->input('my_session_id'));


    $taggingStamp = TaggingStamp::where('tag_id', '=', $id)->where('game_session_id', '=', $mySession->id)->first();

    \Debugbar::info($taggingStamp->id);

    $matchingWord = MatchingWord::where('tagging_stamp_id', '=', $taggingStamp->id)->first();


    $deleteFromMatchingWordsFlag = false;

    if($matchingWord != null && sizeof($matchingWord)>0){
      $matchingWord->delete();
      $deleteFromMatchingWordsFlag = true;
    }

    $taggingStamp->delete();

    return array('deleteFromMatchingWordsFlag' => $deleteFromMatchingWordsFlag);

  }
}
