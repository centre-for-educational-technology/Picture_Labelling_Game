<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;

use Illuminate\View\View;

use Illuminate\Support\Facades\Input;

use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\Hash;

use Validator;

use App\Pics;

use Intervention\Image\Facades\Image;




class AdminController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');

    $this->middleware('role.required');


  }

  /**
   * Display a listing of the user.
   *
   * @return Response
   */
  public function index()
  {

    $users = User::all();


    return view('admin.admin')
        ->with('users', $users);

  }

  /**
   * Show the form for creating a new user.
   *
   * @return Response
   */
  public function create()
  {

    return view('admin.create');
  }

  /**
   * Store a newly created user in storage.
   *
   * @return Response
   */
  public function store(Request $request)
  {

    $all_input_rule = array(
        'name' => 'required|max:255',
        'email' => 'required|email|max:255|unique:users',
        'password' => 'required|min:6|confirmed',
    );

    $all_input_validator = Validator::make($request->all(), $all_input_rule);

    if($all_input_validator->fails()) {

      return redirect('/admin/create')
          ->withErrors($all_input_validator)
          ->withInput($request->except('password', 'password_confirmation'));

    } else {

      $user = new User;

      $user->name   = $request->input('name');
      $user->email      = $request->input('email');
      $user->role_id      = $request->input('role');
      $user->password   = Hash::make($request->input('password'));

      if($user->save()){
        flash()->success('User '.$request->input('name').' has been created.');

        return Redirect::to('/admin');
      }


    }
    
    

  }

  /**
   * Show the form for editing the specified user.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    $user = User::find($id);


    return view('admin.edit')
        ->with('user', $user);
  }

  /**
   * Update the specified user in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update(Request $request, $id)
  {
    $user = User::find($id);


    if (!$request->has('password')){

      if($request->has('email') && $request->input('email') != $user->email){
        $all_input_rule = array(
            'email' => 'email|unique:users',
            'name' => 'max:255',
        );
        //Nothing changed
      } else if($request->input('role') == $user->role_id && $request->has('name') && $request->input('name') == $user->name){
        flash()->success('Nothing changed.');
        return view('admin.edit')
            ->with('user', $user);
      }
      else{
        $all_input_rule = array(
            'name' => 'max:255',
        );
      }


      $all_input_validator = Validator::make($request->all(), $all_input_rule);

      if($all_input_validator->fails()) {
        return redirect('/admin/'.$id.'/edit')
            ->withErrors($all_input_validator)
            ->withInput($request->except('password', 'password_confirmation'))
            ->with('user', $user);

      }else{
        // save the new email and password and name
        $name = $request->input('name');
        $user->name = $name;
        $email = $request->input('email');
        $user->email = $email;
        $password = $request->input('password');
        $user->password = Hash::make($password);
        $role = $request->input('role');
        $user->role_id = $role;
        if($user->save()) {
          flash()->success('Changes have been saved.');
          return view('admin.edit')
              ->with('user', $user);
        }
      }
    }else if ($request->has('password')){

      if($request->has('email') && $request->input('email') != $user->email){
        $all_input_rule = array(
            'email' => 'email|unique:users',
            'password' => 'min:6|confirmed',
            'name' => 'max:255',
        );
      }else{
        $all_input_rule = array(
            'password' => 'min:6|confirmed',
            'name' => 'max:255',
        );
      }

      $all_input_validator = Validator::make($request->all(), $all_input_rule);

      if($all_input_validator->fails()) {
        return redirect('/admin/'.$id.'/edit')
            ->withErrors($all_input_validator)
            ->withInput($request->except('password', 'password_confirmation'))
            ->with('user', $user);

      }else{
        // save the new email and password and name
        $name = $request->input('name');
        $user->name = $name;
        $email = $request->input('email');
        $user->email = $email;
        $role = $request->input('role');
        $user->role_id = $role;
        if($user->save()) {
          flash()->success('Changes have been changed.');
          return view('admin.edit')
              ->with('user', $user);
        }
      }
    }


//Does not include role
//    //Change name, email and password
//    if($request->has('email') && $request->input('email') != $user->email && $request->has('password') && $request->has('name') && $request->input('name') != $user->name){
//
//      $new_email_and_password_and_name_rule = array(
//          'email' => 'required|email|unique:users',
//          'password' => 'required|min:6|confirmed',
//          'name' => 'required|max:255',
//      );
//
//
//      $new_email_and_password_and_name_validator = Validator::make($request->all(), $new_email_and_password_and_name_rule);
//
//
//      if($new_email_and_password_and_name_validator->fails()) {
//        return redirect('/admin/'.$id.'/edit')
//            ->withErrors($new_email_and_password_and_name_validator)
//            ->withInput($request->except('password', 'password_confirmation'))
//            ->with('user', $user);
//
//      }else{
//        // save the new email and password and name
//        $name = $request->input('name');
//        $user->name = $name;
//        $email = $request->input('email');
//        $user->email = $email;
//        $password = $request->input('password');
//        $user->password = Hash::make($password);
//        if($user->save()) {
//          flash()->success('User email, password and name have been changed.');
//          return view('admin.edit')
//              ->with('user', $user);
//        }
//      }
//
//    }
//    //Change email and password
//    else if($request->has('email') && $request->input('email') != $user->email && $request->has('password')){
//
//      $new_email_and_password_rule = array(
//          'email' => 'required|email|unique:users',
//          'password' => 'required|min:6|confirmed',
//      );
//
//
//      $new_email_and_password_validator = Validator::make($request->all(), $new_email_and_password_rule);
//
//
//      if($new_email_and_password_validator->fails()) {
//        return redirect('/admin/'.$id.'/edit')
//            ->withErrors($new_email_and_password_validator)
//            ->withInput($request->except('password', 'password_confirmation'))
//            ->with('user', $user);
//
//      }else{
//        // save the new email and password
//        $email = $request->input('email');
//        $user->email = $email;
//        $password = $request->input('password');
//        $user->password = Hash::make($password);
//        if($user->save()) {
//          flash()->success('User email and password have been changed.');
//          return view('admin.edit')
//              ->with('user', $user);
//        }
//      }
//
//    }
//    //Change email and name
//    else if ($request->has('email') && $request->input('email') != $user->email && $request->has('name') && $request->input('name') != $user->name){
//
//      $new_email_and_name_rule = array(
//          'email' => 'required|email|unique:users',
//          'name' => 'required|max:255',
//      );
//
//
//      $new_email_and_password_validator = Validator::make($request->all(), $new_email_and_name_rule);
//
//
//      if($new_email_and_password_validator->fails()) {
//        return redirect('/admin/'.$id.'/edit')
//            ->withErrors($new_email_and_password_validator)
//            ->withInput($request->except('password'))
//            ->with('user', $user);
//
//      }else{
//        // save the new email and name
//        $email = $request->input('email');
//        $user->email = $email;
//        $name = $request->input('name');
//        $user->name = $name;
//        if($user->save()) {
//          flash()->success('User email and name have been changed.');
//          return view('admin.edit')
//              ->with('user', $user);
//        }
//      }
//
//    }
//    //Change email only
//    else if ($request->has('email') && $request->input('email') != $user->email){
//
//      $new_email_rule = array(
//          'email' => 'required|email|unique:users'
//      );
//
//
//      $new_email_validator = Validator::make($request->all(), $new_email_rule);
//
//      if($new_email_validator->fails())
//      {
//
//        return redirect('/admin/'.$id.'/edit')
//            ->withErrors($new_email_validator)
//            ->withInput($request->except('password', 'password_confirmation'))
//            ->with('user', $user);
//
//
//
//      } else {
//        // save the new email
//        $email = $request->input('email');
//        $user->email = $email;
//        if($user->save()) {
//          flash()->success('Your email has been changed.');
//          return view('admin.edit')
//              ->with('user', $user);
//        }
//
//      }
//
//    }
//    //Change password only
//    else if ($request->has('password')){
//      $new_password_rule = array(
//          'password' => 'required|min:6|confirmed',
//      );
//
//
//      $new_password_validator = Validator::make($request->all(), $new_password_rule);
//
//      if($new_password_validator->fails())
//      {
//
//        return redirect('/admin/'.$id.'/edit')
//            ->withErrors($new_password_validator)
//            ->with('user', $user);
//
//      } else {
//        // save the new password
//        $password = $request->input('password');
//        $user->password = Hash::make($password);
//        if($user->save()) {
//          flash()->success('User password has been changed. '.$password);
//          return view('admin.edit')
//              ->with('user', $user);
//        }
//
//      }
//
//    }
//    //Change name only
//    else if($request->has('name') && $request->input('name') != $user->name){
//
//      $new_name_rule = array(
//          'password' => 'required|max:255',
//      );
//
//
//      $new_name_validator = Validator::make($request->all(), $new_name_rule);
//
//      if($new_name_validator->fails())
//      {
//
//        return redirect('/admin/'.$id.'/edit')
//            ->withErrors($new_name_validator)
//            ->withInput($request)
//            ->with('user', $user);
//
//      } else {
//        // save the new name
//        $user->name = $request->input('name');
//        if($user->save()) {
//          flash()->success('User name has been changed.');
//          return view('admin.edit')
//              ->with('user', $user);
//        }
//
//      }
//
//    }else{
//      flash()->success('Nothing changed.'.$request->input('role'));
//      return view('admin.edit')
//          ->with('user', $user);
//    }



//    $user->name   = Input::get('name');
//    $user->email      = Input::get('email');
//    $user->password   = Hash::make(Input::get('password'));
//
//    $user->save();
//
//    return Redirect::to('/admin');
  }

  /**
   * Remove the specified user from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    User::destroy($id);

    return Redirect::to('/admin');
  }



  /*
   * Pictures management
   */


  public function listPictures()
  {

    $pics = Pics::all();


    return view('admin.pics')
        ->with('pics', $pics);

  }


  public function uploadPicture() {
    // getting all of the post data
    $file = array('image' => Input::file('image'));

    // setting up rules
    $rules = array('image' => 'required|image',); //mimes:jpeg,bmp,png and for max size max:10000
    // doing the validation, passing post data, rules and the messages
    $validator = Validator::make($file, $rules);
    if ($validator->fails()) {
      // send back to the page with the input data and errors
      return redirect('/admin/pictures')->withInput()->withErrors($validator);
    }
    else {
      // checking file is valid.
      if (Input::file('image')->isValid()) {
        $destinationPath = 'pictures/'; // upload path
        $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
        $fileName = rand(11111,99999).'.'.$extension; // renaming image

        $img = Image::make(Input::file('image'));
        // resize the image to a width of 500 and constrain aspect ratio (auto height)
        $img->resize(500, null, function ($constraint) {
          $constraint->aspectRatio();
        });

        $img->save($destinationPath.$fileName);



        $img_record = new Pics;

        $img_record->filename = $fileName;

        if($img_record->save()){
          flash()->success('Uploaded successfully.');
          return redirect('/admin/pictures');
        }




//        Input::file('image')->move($destinationPath, $fileName); // uploading file to given path
        // sending back with message

      }
      else {
        // sending back with error message.
        flash()->error('Uploaded file is not valid.');
        return redirect('/admin/pictures');
      }
    }
  }

  public function deletePic($id)
  {
    Pics::destroy($id);

    return Redirect::to('/admin/pictures');
  }

}
