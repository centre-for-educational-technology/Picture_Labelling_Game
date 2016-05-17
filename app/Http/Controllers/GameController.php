<?php

namespace App\Http\Controllers;

use App\GameSession;
use App\Pics;
use Illuminate\Http\Request;

use App\Http\Requests;

use App\Tags;
use Illuminate\Support\Facades\Auth;


class GameController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index() {

    $tags = Tags::all();

    $pic = Pics::orderByRaw("RAND()")->first();



    return array('tags' => $tags, 'pic' => array('id'=> $pic->id, 'url'=> asset('pictures/'.$pic->filename)));


  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(Request $request) {
    $tag = Tags::create($request->input('tag'));

    Pics::where('email', Input::get('email'))
        ->orWhere('name', 'like', '%' . Input::get('name') . '%')->get();
    
    
    $gameSession = GameSession::create(array(
        'user_id' => Auth::user()->id,
        'picture_id' => $request->input('pic'),
        'tag_id' => 1
    ));


    return $tag;
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update(Request $request, $id) {
    $tag = Tags::find($id);
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
    Tags::destroy($id);
  }
}
