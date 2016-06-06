<?php

namespace App\Http\Controllers;

use App\GameSession;
use App\MatchingWord;
use Illuminate\Http\Request;

use App\Http\Requests;

use Validator;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Redirect;



class ProfileController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth');
  }


  public function user()
  {

    $user = Auth::user();

    $myGameSessions = $user->gameSessions;



    $myGameSessionsIds = array();

    foreach ($myGameSessions as $myGameSession){
      array_push($myGameSessionsIds, $myGameSession->id);
    }



    $matches = MatchingWord::whereIn('game_session_id', $myGameSessionsIds)->get();



    $matches_array = array();

    if ($matches != null && sizeof($matches) > 0){
      foreach ($matches as $match){
        $competitor = GameSession::find($match->gameSession->competitor_session_id)->user->name;
        $tag = $match->taggingStamp->tag->tag;
        $time = $match->taggingStamp->created_at->toDayDateTimeString();

        array_push($matches_array, [$competitor, $tag, $time]);

      }
    }



    //Game sessions where i was a competitor

    $gameSessionsWhereICompetitor = GameSession::whereIn('competitor_session_id', $myGameSessionsIds)->get();

    \Debugbar::info($gameSessionsWhereICompetitor);

    $gameSessionsWhereICompetitorIds = array();

    foreach ($gameSessionsWhereICompetitor as $gameSessionWhereICompetitor){
      array_push($gameSessionsWhereICompetitorIds, $gameSessionWhereICompetitor->id);
    }

    $gameSessionsWhereICompetitorMatches = MatchingWord::whereIn('game_session_id', $gameSessionsWhereICompetitorIds)->get();

    $gameSessionsWhereICompetitorMatches_array = array();

    if ($gameSessionsWhereICompetitorMatches != null && sizeof($gameSessionsWhereICompetitorMatches) > 0){
      foreach ($gameSessionsWhereICompetitorMatches as $gameSessionsWhereICompetitorMatch){


        $competitor = GameSession::find($gameSessionsWhereICompetitorMatch->gameSession->competitor_session_id)->user->name;
        $tag = $gameSessionsWhereICompetitorMatch->taggingStamp->tag->tag;
        $time = $gameSessionsWhereICompetitorMatch->taggingStamp->created_at->toDayDateTimeString();

        array_push($gameSessionsWhereICompetitorMatches_array, [$competitor, $tag, $time]);

      }
    }






    return view('profile.user')
        ->with('user', Auth::user())->with('my_matches', $matches_array)->with('others_matches', $gameSessionsWhereICompetitorMatches_array);


  }

  public function edit()
  {

    return view('profile.edit')
        ->with('user', Auth::user());

  }



  public function postChangePassword(Request $request) {

    $user = Auth::user();

    $old_password_rule = array(
      'old_password' => 'required',
    );

    $old_password_validator = Validator::make($request->all(), $old_password_rule);

    if ( $old_password_validator->fails() ){
      return view('profile.edit')
          ->withErrors($old_password_validator)
          ->with('user', Auth::user());
    } else {

      $old_password = $request['old_password'];

      if( !Hash::check($old_password, $user->getAuthPassword()) ){
        flash()->error('Your old password is incorrect.');
        return view('profile.edit')
            ->with('user', Auth::user());
      }
    }


    //Only password change
    if ($request->has('password') && $request->input('email') == $user->email) {
      $new_password_rule = array(
          'password' => 'required|min:6|confirmed',
      );


      $new_password_validator = Validator::make($request->all(), $new_password_rule);

      if($new_password_validator->fails())
      {

        return redirect('/user/edit')
            ->withErrors($new_password_validator)
            ->withInput($request->except('old_password', 'password', 'password_confirmation'))
            ->with('user', Auth::user());

      } else {
        // save the new password
        $password = $request->input('password');
        $user->password = Hash::make($password);
        if($user->save()) {
          flash()->success('Your password has been changed. '.$password);
          return view('profile.edit')
              ->with('user', Auth::user());
        }

        }
      }


    //Only email change
    else if ($request->has('email') && $request->input('email') != $user->email && !$request->has('password')) {
      $new_email_rule = array(
          'email' => 'required|email|unique:users'
      );


      $new_email_validator = Validator::make($request->all(), $new_email_rule);

      if($new_email_validator->fails())
      {

        return redirect('/user/edit')
            ->withErrors($new_email_validator)
            ->withInput($request->except('old_password', 'password', 'password_confirmation'))
            ->with('user', Auth::user());



      } else {
        // save the new email
        $email = $request->input('email');
        $user->email = $email;
        if($user->save()) {
          flash()->success('Your email has been changed.');
          return view('profile.edit')
              ->with('user', Auth::user());
        }

      }
    }


    //Change email and password
    else if ($request->has('email') && $request->input('email') != $user->email && $request->has('password')) {
      $new_email_and_password_rule = array(
          'email' => 'required|email|unique:users',
          'password' => 'required|min:6|confirmed',
      );


      $new_email_and_password_validator = Validator::make($request->all(), $new_email_and_password_rule);


      if($new_email_and_password_validator->fails()) {
        return redirect('/user/edit')
            ->withErrors($new_email_and_password_validator)
            ->withInput($request->except('old_password', 'password', 'password_confirmation'))
            ->with('user', Auth::user());

      }else{
        // save the new email and password
        $email = $request->input('email');
        $user->email = $email;
        $password = $request->input('password');
        $user->password = Hash::make($password);
        if($user->save()) {
          flash()->success('Your email and password have been changed.');
          return view('profile.edit')
              ->with('user', Auth::user());
        }
      }



    } else {
      flash()->success('Nothing changed.');
      return view('profile.edit')
          ->with('user', Auth::user());
    }












  }


}
