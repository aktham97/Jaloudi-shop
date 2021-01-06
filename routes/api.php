<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['prefix'=>'Men'],function(){
    Route::resource('shirts','Men\ShirtController');
    Route::resource('pants','Men\PantController');
    Route::resource('jackets','Men\JacketController');
    Route::post('shirts/rating/{id}','Men\ShirtController@addRating');
    Route::post('pants/rating/{id}','Men\PantController@addRating');
    Route::post('jackets/rating/{id}','Men\JacketController@addRating');
});
Route::group(['prefix'=>'Women'],function(){
    Route::resource('pants','Women\PantController');
    Route::resource('jackets','Women\JacketController');
    Route::resource('dresses','Women\DressController');
    Route::post('pants/rating/{id}','Women\PantController@addRating');
    Route::post('jackets/rating/{id}','Women\JacketController@addRating');
    Route::post('dresses/rating/{id}','Women\DressController@addRating');
});

Route::group(['prefix'=>'auth'],function (){

    Route::post('login','AppController@login');

    Route::post('register','AppController@register');

    Route::group(['middleware'=>'auth:api'],function (){

        Route::get('logout','AppController@logout');
    });


});
