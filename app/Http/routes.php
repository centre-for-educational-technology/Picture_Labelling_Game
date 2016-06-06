<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//View::addExtension('html', 'php');
View::addExtension('js', 'php'); // XXX BAD CHOICE


Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');


Route::get('/user',
    array('as' => 'profile-user',
        'uses' => 'ProfileController@user'
    ));

Route::get('/user/edit',
    array('as' => 'profile-edit',
        'uses' => 'ProfileController@edit'
    ));



Route::group(array('before' => 'auth'), function() {

    /* CSRF protection */
    Route::group(array('before' => 'csrf'), function() {

        Route::post('/user/edit',
            array('as' => 'profile-edit',
                'uses' => 'ProfileController@postChangePassword'
            ));
    });


});

//Used when validator lives in controller
//Route::group(array('before' => 'auth'), function() {
//
//    /* CSRF protection */
//    Route::group(array('before' => 'csrf'), function() {
//        /* Change password (POST) */
//        Route::post('/admin/{id}/edit',
//            array('as' => 'admin-edit',
//                'uses' => 'AdminController@update'
//            ));
//    });
//
//
//});

Route::post('/admin/{id}/edit', 'AdminController@update');

Route::post('/admin/create', 'AdminController@store');

Route::get('/admin/stats','AdminController@stats');

Route::post('/admin/stats', 'AdminController@getStats');

Route::get('/admin/pictures','AdminController@listPictures');

Route::post('/admin/pictures', 'AdminController@uploadPicture');

Route::delete('/admin/pictures/{id}',array('uses' => 'AdminController@deletePic'));


Route::resource('/admin', 'AdminController');

Route::resource('/api/game','GameController');


