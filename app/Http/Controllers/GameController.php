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
   * Display game page
   *
   */
  public function index() {

    $user = Auth::user();

    $pic = Pic::orderByRaw("RAND()")->first();

//    $pic = Pic::where('id', '=', 15)->first();

    if($pic) {


      //Get taboo words for that picture
      $matchingWordsList = $this->getTabooWords($pic);


// Used if previous tags made by me for that picture do matter
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
      if ($secondPlayerRandomSession != null && sizeof($secondPlayerRandomSession) > 0) {


        $secondPlayerName = $secondPlayerRandomSession->user->name;


//      \Debugbar::info($secondPlayerName);

        //Get all tags from that user for that picture
//      $secondPlayerSessionTagsForThatPicture = $secondPlayerRandomSession->tags;

//      \Debugbar::info($secondPlayerSessionTagsForThatPicture);


        //Create a new session
        $myGameSession = GameSession::create(array(
            'user_id' => $user->id,
            'competitor_session_id' => $secondPlayerRandomSession->id,
            'pic_id' => $pic->id,
        ));


        $myGameSession->save();


      } else {

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


      return array('my_session_id' => $myGameSession->id, 'second_player' => $secondPlayerName, 'matching_words_list' => $matchingWordsList, 'pic' => array('id' => $pic->id, 'url' => asset('pictures/' . $pic->filename)), 'no_pictures_flag' => false);

    }else{
      return array('no_pictures_flag' => true);
    }

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
   * Store new tags
   *
   */
  public function store(Request $request) {
    $input_tags = $request->input('tags');



    //Get my session
    $mySession = GameSession::find($request->input('my_session_id'));
    $mySession->touch();



    $matchingWordAddedFlag = false;

    $matchingWordsList = array();



    foreach ($input_tags as $input_tag){

      $input_tag = $input_tag['tag'];
//      \Debugbar::info($input_tag);
      //Check if there is already same tag in table
      $similar_tag = Tag::where('tag', 'like', '%' . $input_tag . '%')->first();

      if($similar_tag != null && sizeof($similar_tag)>0){
        $tag = $similar_tag;

      }else{
        $tag = Tag::create(array(
            'tag' => $input_tag,
        ));
      }




      $taggingStamp = TaggingStamp::create(array(
          'tag_id' => $tag->id,
          'game_session_id' => $mySession->id,
      ));


      $taggingStamp->save();


      //Get competitor session
      if($mySession->competitor_session_id != null){

        $competitorSession = GameSession::find($mySession->competitor_session_id);
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

            array_push($matchingWordsList, $tag);

          }
        }

      }
    }

    return array('matchingWordAddedFlag' => $matchingWordAddedFlag, 'matchingWordsList' => $matchingWordsList);



  }

  /**
   * Update the specified tag in storage.
   *
   */
//  public function update(Request $request, $id) {
//    $tag = Tag::find($id);
//    $tag->tag = $request->input('tag');
//    $tag->save();
//
//    return $tag;
//  }
//
//  /**
//   * Remove the tag
//   *
//   */
//  public function destroy(Request $request, $id) {
//
//    //Get my session
//    $mySession = GameSession::find($request->input('my_session_id'));
//
//
//    $taggingStamp = TaggingStamp::where('tag_id', '=', $id)->where('game_session_id', '=', $mySession->id)->first();
//
//    \Debugbar::info($taggingStamp->id);
//
//    $matchingWord = MatchingWord::where('tagging_stamp_id', '=', $taggingStamp->id)->first();
//
//
//    $deleteFromMatchingWordsFlag = false;
//
//    if($matchingWord != null && sizeof($matchingWord)>0){
//      $matchingWord->delete();
//      $deleteFromMatchingWordsFlag = true;
//    }
//
//    $taggingStamp->delete();
//
//    return array('deleteFromMatchingWordsFlag' => $deleteFromMatchingWordsFlag);
//
//  }
}
